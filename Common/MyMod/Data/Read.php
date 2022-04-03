<?php



trait MyMod_Data_Read
{
    //*
    //* function MyMod_Data_Read, Parameter list:
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Read()
    {
        $this->MyMod_Data_AddTimeData();

        //Allows defining more data, before we update module sql structure.
        if (method_exists($this,"PreProcessItemData"))
        {
            $this->PreProcessItemData();
        }

        //$this->MyMod_Data_TimeData_SET();

        
        foreach ($this->MyMod_Data_Files_Get() as $file)
        {
            if (file_exists($file))
            {
                $this->MyMod_Data_Add_File($file);
            }
        }

        $this->MyMod_Languaged_Datas_Add();
        
        //Allows defining more data, before we update module sql structure.
        if (method_exists($this,"PostProcessItemData"))
        {
            $this->PostProcessItemData();
        }

        $this->MyMod_Datas_AddDefaultKeys();
    }

    
    //*
    //* function MyMod_Data_Add_File, Parameter list: $file
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Add_File($file)
    {
        $itemdatas=$this->ReadPHPArray($file);
        foreach (array_keys($itemdatas) as $data)
        {
            $this->MyMod_Data_Add_Data($data,$itemdatas[ $data ],$file);
        }
    }

    
    //*
    //* function MyMod_Data_Add_Data, Parameter list: $file
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Add_Data($data,$hash,$file)
    {
        if (!isset($this->ItemData[ $data  ]) && is_array($hash))
        {
            $this->ItemData[ $data ]=$hash;
        }
        else
        {
            if (!is_array($hash)) { return; }
        
            foreach ($hash as $key => $value)
            {
                $this->ItemData[ $data ][ $key ]=$value;
            }
        }

        if (empty($this->ItemData[ $data ][ "Files" ]))
        {
            $this->ItemData[ $data ][ "Files" ]=array();
        }

        array_push($this->ItemData[ $data ][ "Files" ],$file);
        $this->ItemData[ $data ][ "File" ]=$file;
    }

    
    //*
    //* function , Parameter list: $items,$datas
    //*
    //* Reads $items sub $datas.
    //*

    function Items_Read_Modules_Data($items,$datas=array())
    {
        if (empty($datas)) { $datas=$this->MyMod_Data_Fields_Is_Sql(); }

        $this->ItemData();

        $rdatas=array();
        foreach ($datas as $data)
        {
            $res=$this->Items_Read_Module_Data($items,$data);
            if ($res) { array_push($rdatas,$data); }
        }

        #exit();
        return $rdatas;
    }
    
    //*
    //* function Items_Read_Module_Data, Parameter list: 
    //*
    //* Reads $items sub $data.
    //*

    function Items_Read_Module_Data($items,$data)
    {
        $rdata=$data;
        if (!empty($this->ItemData[ $data ][ "__Data__" ]))
        {
            $rdata=$this->ItemData[ $data ][ "__Data__" ];
        }
            
        $moduleobj=$this->MyMod_Data_Field_Sql_2_Module($data)."Obj";

        $res=False;
        if (count($items)>0)
        {
            if (!isset($items[0][ $data ]))
            {
                return $res;
            }
        }

        if (empty($this->ApplicationObj()->__Datas_Objs__[ $data ]))
        {
            $this->$moduleobj()->ItemData();

            $this->ApplicationObj()->__Datas_Objs__[ $data ]=$moduleobj;

            if (!isset($this->ApplicationObj()->__Datas__[ $rdata ]))
            {
                $this->ApplicationObj()->__Datas__[ $rdata ]=array();
            }

            foreach
                (
                    $this->$moduleobj()->Sql_Select_Hashes_ByID
                    (
                        array
                        (
                            "ID" => $this->MyHash_HashesList_Values
                            (
                                $items,
                                $data
                            )
                        )
                    ) as $id => $item
                )
            {
                $this->ApplicationObj()->__Datas__[ $rdata ][ $id ]=$item;
       
            }
            
            $res=True;
        }

        return $res;
    }
    //*
    //* function Item_Read_Module_Data, Parameter list: 
    //*
    //* Reads $item sub $data.
    //*

    function Item_Read_Module_Data($item,$data)
    {
        $moduleobj=$this->MyMod_Data_Field_Sql_2_Module($data)."Obj";
        $this->$moduleobj()->ItemData();

        $res=False;
        if (empty($this->ApplicationObj()->__Datas__[ $data ]))
        {
            $this->ApplicationObj()->__Datas__[ $data ]=array();
            $this->ApplicationObj()->__Datas_Objs__[ $data ]=$moduleobj;  
        }

        $value=$item[ $data ];
        if (empty($this->ApplicationObj()->__Datas__[ $data ][ $value ]))
        {
            $this->ApplicationObj()->__Datas__[ $data ][ $value ]=
                $this->$moduleobj()->Sql_Select_Hash
                (
                    array
                    (
                        "ID" => $value
                    )
                );

            $res=True;
        }

        return $res;
    }
}

?>