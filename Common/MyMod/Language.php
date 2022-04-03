<?php

trait MyMod_Language
{
    //*
    //* Returns the default language, PT
    //*

    function Default_Language()
    {
        return "PT";
    }
    //*
    //* Tries a good guess on whether to show languaged values.
    //*

    function Language()
    {
        return $this->ApplicationObj()->Language;
    }
    
    //*
    //* function MyMod_Language_Data_Tabled, Parameter list: 
    //*
    //* Tries a good guess on whether to show languaged values.
    //*

    function MyMod_Language_Data_Tabled()
    {
        $trust=intval($this->Profiles($this->Profile(),"Trust"));

        $res=($trust<5);

        return $res;
    }
    
    //*
    //* function MyMod_Language_Read, Parameter list: 
    //*
    //* Module language initializer.
    //* Reads System/$module/Messages.php, if exists.
    //*

    function MyMod_Language_Read()
    {
        if (!empty($this->Messages)) { return; }
        
        $file=
            $this->ApplicationObj()->MyApp_Setup_Path().
            "/Messages/".
            $this->ModuleName.
            ".php";

        if (file_exists($file))
        {
            $this->Messages=$this->ReadPHPArray($file);
        }
    }
    
    //*
    //* function MyMod_Language_Message, Parameter list: $key,$skey="Name",$filter=array()
    //*
    //* Module language initializer.
    //* Reads System/$module/Messages.php, if exists.
    //*

    function MyMod_Language_Message($key,$skey="Name",$filter=array())
    {
        if (empty($this->Messages))
        {
            $this->MyMod_Language_Read();
        }
        
        $msg=$this->Messages($key,$skey);
        if (!empty($filter))
        {
            $msg=$this->FilterHash($msg,$filter);
        }

        return $msg;
    }

    //*
    //* Return list of langauged data derived from $data.
    //*

    function MyMod_Language_ItemData_Names($data)
    {
        $datas=array();
        foreach ($this->LanguagesObj()->Language_Keys() as $lkey)
        {            
            $rdata=$data."_".$lkey;
            array_push($datas,$rdata);
        }

        return $datas;
    }
    
    //*
    //* Add Languaged ItemDatas from file.
    //*

    function MyMod_Language_ItemData_Ors($data,$datavalues)
    {
        if (is_array($datavalues)) { return $datavalues; }
        
        $ors=array();
        foreach ($this->LanguagesObj()->Language_Keys() as $lkey)
        {
            $rdata=$data."_".$lkey;
            array_push
            (
                $ors,
                $this->Sql_Table_Column_Name_Qualify($rdata).
                " LIKE ".
                $this->Sql_Table_Column_Value_Qualify("%".$datavalues."%")
            );

        }
        
        return "(".join(" OR ",$ors).")";
    }
    
    //*
    //* Add Languaged ItemDatas from file.
    //*

    function MyMod_Language_ItemData_File_Add($file,$commondefs=array())
    {
        $this->MyMod_Language_ItemDatas_Add
        (
            $this->ReadPHPArray($file),
            $commondefs
        );
    }
    
    //*
    //* Add Languaged ItemDatas.
    //*

    function MyMod_Language_ItemDatas_Add($defs,$commondefs=array())
    {
        foreach ($defs as $data => $def)
        {
            $this->MyMod_Language_ItemData_Add($data,$def,$commondefs);
        }
    }
    
    //*
    //* Add Languaged ItemData.
    //*

    function MyMod_Language_ItemData_Add($data,$def,$commondefs=array())
    {
        $language=$this->Language();

        $datas=array();
        foreach ($this->LanguagesObj()->Language_Keys() as $lkey)
        {
            $search=False;
            if ($language==$lkey)
            {
                $search=True;
            }
            
            $rdata=$data."_".$lkey;
            $this->ItemData[ $rdata ]=
                $this->MyHash_Filter_Hash
                (
                    $def,
                    array("Lang" => $lkey)
                );
                
            $this->ItemData[ $rdata ]=
                array_merge
                (
                    $this->ItemData[ $rdata ],
                    $commondefs
                );
            $this->ItemData[ $rdata ][ "Search" ]=$search;
            $this->ItemData[ $rdata ][ "SqlMethod" ]=$data."_Search_Clause";
            
            array_push($datas,$rdata);
        }

        return $datas;
    }
}

?>