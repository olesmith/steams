<?php


trait MyMod_Item_Group_Table
{
    var $Datas_Included=array();
    //*
    //* Create item Group table (matrix).
    //*

    function MyMod_Item_Group_Table($edit,$group,$item,$plural=FALSE,$precgikey="",$title="",$precols=array(),$postcols=array())
    {
        $datas=
            $this->MyMod_Item_Group_Table_Datas($group,$item);

        $table=
            $this->MyMod_Item_Table
            (
                $edit,
                $item,
                $datas,
                $plural,
                $includename=FALSE,
                $includecompulsorymsg=FALSE
            );

        if (empty($table)) { return array(); }
        
        $table=
            $this->Html_Table_Pad
            (
                $table,
                $precols,$postcols
            );

        

        if ($this->SGroups_NumberItems)
        {
            $n=1;
            foreach (array_keys($table) as $id)
            {
                array_unshift($table[ $id ],$this->B($n.":"));
                $n++;
            }
        }

        if (!is_bool($title))
        {
            if (empty($title))
            {
                $title=$this->MyMod_Item_Group_Table_Title($edit,$group);
            }

            array_unshift
            (
                $table,
                $title
            );
        }

        foreach ($datas as $data)
        {
            $key=$data."_".$item[ "ID" ];
            if (empty($this->Datas_Included[ $key  ]))
            {
                $this->Datas_Included[ $key ]=True;
            }
        }
        
       return $table;
    }
    
    //*
    //* Returns datas for item data group.
    //*

    function MyMod_Item_Group_Table_Datas($group,$item=array())
    {
        $this->ItemDataSGroups();
        
        $datas=array();
        if (!empty($this->ItemDataSGroups[ $group ][ "TableDataMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "TableDataMethod" ];

            $datas=$this->$method($group,$item);
        }
        elseif (!empty($this->ItemDataSGroups[ $group ][ "Data" ]))
        {
            $datas=$this->ItemDataSGroups[ $group ][ "Data" ];
        }
        elseif (!empty($this->ItemDataSGroups[ $group ][ "TableDataMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "TableDataMethod" ];
            $datas=$this->$method($group,$item);
        }

        $rdatas=array();
        foreach ($datas as $data)
        {
            if (empty($this->Datas_Included[ $data ]))
            {
                array_push($rdatas,$data);
                $this->Datas_Included[ $data ]=True;
            }
        }

        return $rdatas;
    }
    
    //*
    //* Returns title for item data group.
    //*

    function MyMod_Item_Group_Table_Title($edit,$group)
    {
        $title=
            $this->LanguagesObj()->Language_Group_Title_Get($this,$group,True);

        if ($edit==1) { $title.=$this->SUP("","&dagger;"); }

        if ($this->LatexMode())
        {
            $title=
                "\\large{\\textbf{".$title."}}".
                "";
        }
        else
        {
            $title=$this->H(3,$title);
        }

        return $title;
    }
    
    
    //*
    //* MyMod_Item_Group_Table_Text_Pre
    //*

    function MyMod_Item_Group_Table_Text_Pre($group)
    {
        $pre="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PreText" ]))
        {
            $pre=$this->ItemDataSGroups[ $group ][ "PreText" ];
        }
        
        return $pre;
    }
    
    //*
    //* MyMod_Item_Group_Table_Text_Post
    //*

    function MyMod_Item_Group_Table_Text_Post($group)
    {
        $pre="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PostText" ]))
        {
            $pre=$this->ItemDataSGroups[ $group ][ "PostText" ];
        }

        return $pre;
    }
    

}

?>