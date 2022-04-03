<?php

include_once("DBData/Access.php");
include_once("DBData/Languages.php");
include_once("DBData/Pertains.php");
include_once("DBData/Cells.php");
include_once("DBData/Quest.php");
include_once("DBData/Update.php");
include_once("DBData/Form.php");

class DBData extends DBDataForm
{
    //*
    //* function Datas, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function DBData($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("SortOrder","Name","SqlKey");
        $this->Sort=array("DataGroup","SortOrder","Name");

    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("DBData",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return
            join
            (
                "/",
                array
                (
                    $this->ApplicationObj()->MyApp_Setup_Root(),
                    "Application","System","DBData","Profiles.php"
                )
            );
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        $this->Sql_Table_Column_Rename("Candidate","Friend");
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreActions()
    {
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->Languages_Init_ItemData();
    }
    

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }


        $updatedatas=array();
        if (empty($item[ "SqlDef" ]) && !empty($item[ "Type" ]))
        {
            $item[ "SqlDef" ]=
                $this->ItemData[ "Type" ][ "SQLDefault" ][ $item[ "Type" ]-1 ];
            array_push($updatedatas,"SqlDef");
        }

        if (empty($item[ "SortOrder" ]) && !empty($item[ "ID" ]))
        {
            $item[ "SortOrder" ]=$item[ "ID" ];
            array_push($updatedatas,"SortOrder");
        }

        foreach (array("UK") as $lang)
        {
            $data="SValues";
            $rdata=$data."_".$lang;
            
            if (empty($item[ $rdata ]) && !empty($item[ $data ]))
            {
                $item[ $rdata ]=$item[ $data ];
                array_push($updatedatas,$rdata);
            }
        }

        foreach (array("Text","Text_UK") as $data)
        {
            $rdata=preg_replace('/^Text/',"Title",$data);
            if (empty($item[ $rdata ]) && !empty($item[ $data ]))
            {
                $item[ $rdata ]=$item[ $data ];
                array_push($updatedatas,$rdata);
            }
        }



        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }

    
    //*
    //* function Edit_Default_Field, Parameter list: $item
    //*
    //* Creates sutiable default spec field.
    //*

    function Edit_Default_Field($data,$item,$edit=0,$rdata="")
    {
        if ($item[ "SqlDef" ]=="ENUM")
        {
            $valuenames=$this->GetRealNameKey($item,"SValues");
            $valuenames=preg_split('/\s*,\s*/',$valuenames);
            $values=array();

            $n=1;
            foreach ($valuenames as $valuename)
            {
                array_push($values,$n++);
            }
            array_unshift($values,0);
            array_unshift($valuenames,"");
            
            $value=$this->MakeSelectField($rdata,$values,$valuenames,$item[ $data ]);
            return $value;
        }

        return
            $this->MyMod_Data_Fields_Edit
            (
                $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,
                $callmethod=FALSE,
                $rdata
            );
    }
    
    //*
    //* function DBData_First_Group_ID, Parameter list:
    //*
    //* Tries to locate the first data group item.
    //*

    function DBData_First_Group_ID()
    {       
        $this->GroupDatasObj()->Sql_Tables_Structure_Default_Items_Add();
        
        $groupids=
            $this->GroupDatasObj()->Sql_Select_Unique_Col_Values
            (
                "ID",
                $this->UnitEventWhere()
            );

        $groupid=0;
        if (count($groupids)>0)
        {
            $groupid=array_shift($groupids);
        }

        return $groupid;
    }
    
    //*
    //* function Sql_Table_Default_Items, Parameter list:
    //*
    //* Returns items to add to empty table.
    //*

    function Sql_Table_Default_Items()
    {
        $groupid=$this->DBData_First_Group_ID();
        
        $items=array();
        if ($groupid>0)
        {
            $items=
                array
                (
                    array_merge
                    (
                        $this->UnitEventWhere(),
                        array
                        (
                            "SortOrder" => 1,
                            "DataGroup" => $groupid,
                            #"Pertains" => 1,
                            "Type" => 1,
                            "SqlKey" => "City",
                            "SqlDef" => "VARCHAR(256)",
                            "SqlDefault" => "",
                            "Text_PT"    => "Cidade",
                            "Text_UK" => "Cidade",
                            /* "Title"    => "Institutição", */
                            /* "Title_UK" => "Institution", */
                        )
                    )
                );
        }

        return $items;
    }        
    
    //*
    //* function Sql_Tables_Structure_Default_Item_Init, Parameter list: $item
    //*
    //* Overrides Sql_Tables_Structure_Default_Item_Init. Scans out first avaliable data group.
    //*

    function Sql_Tables_Structure_Default_Item_Init00000($item)
    {
        #Sets Unit and Event key
        $item=parent::Sql_Tables_Structure_Default_Item_Init($item);
        
        $this->GroupDatasObj()->Sql_Tables_Structure_Default_Items_Add();
        
        $groupids=
            $this->GroupDatasObj()->Sql_Select_Unique_Col_Values
            (
                "ID",
                $this->UnitEventWhere()
            );
        
        if (count($groupids)>0)
        {
            $groupid=array_shift($groupids);
            $item[ "DataGroup" ]=$groupid;
        }

        return $item;
    }
    
    //*
    //* 
    //*

    function Data_Is_Input($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==1) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_Enum($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==2) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_File($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==3) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_Radio($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==4) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_CheckBox($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==5) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_Area($item,$data)
    {
        $res=False;
        if ($item[ "Type" ]==6) { $res=True; }
        
        return $res;
    }
    //*
    //* 
    //*

    function Data_Is_Password($item,$data)
    {
        $res=False;
        
        if ($item[ "Type" ]==7) { $res=True; }
        
        return $res;
    }
}

?>