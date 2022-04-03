<?php

include_once("Application/App.Permissions.php");
include_once("Permissions/Access.php");
include_once("Permissions/Units.php");
include_once("Permissions/Users.php");
include_once("Permissions/User.php");
include_once("Permissions/Select.php");


class Permissions extends Permissions_Select
{
    var
        $Permissions_Units_Edit_Type=1;
    
    //*
    //* function , Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Permissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("User","Unit");
        $this->Sort=array("User");
        $this->ItemNamer="User";
        $this->IDGETVar="Permission";
    }

    
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table)) { $table="Permissions"; }
        
        return $table;
    }

    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function MyMod_Data_Upload_Pathuuuu()
    {
        $path="Uploads/".$this->Unit("ID")."/Permissions";
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }

    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
    }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
        $this->IncludeAllDefault=TRUE;
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push
        (
            $this->ItemDataFiles,
            "Data.Access.php",
            "Data.Languages.php"
        );
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
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
        $module=$this->GetGET("ModuleName");
        if ($module!="Permissions")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }

    //*
    //* Trigger Function for City, Campus, Entity, Course.
    //* Sets 'upwards' data correspondingly.
    //* For inst. if Course is set, set Entity, Campus and City.
    //*

    function Permission_Set(&$item,$data,$newvalue,$prepostkey)
    {
        if ($item[ $data ]==$newvalue) { return; }
        
        $item[ $data ]=$newvalue;

        
        $updatedatas=array();

        foreach ($this->ItemData[ $data ][ "Datas_Zero"  ] as $rdata)
        {
            if (!empty($item[ $rdata ]))
            {
                $item[ $rdata ]=0;
                $item[ $rdata."_ReadOnly" ]=True;
                array_push($updatedatas,$rdata);
            }
        }

        $sub_item=
            $this->MyMod_Data_Module_Object($data)->Sql_Select_Hash
            (
                array("ID" => $item[ $data ]),
                $this->ItemData[ $data ][ "Datas_Set"  ]
            );
        
        foreach ($this->ItemData[ $data ][ "Datas_Set"  ] as $rdata)
        {
            if
                (
                    !empty($sub_item[ $rdata ])
                    &&
                    (
                        empty($item[ $rdata ])
                        ||
                        $item[ $rdata ]!=$sub_item[ $rdata ]
                    )
                )
            {
                $item[ $rdata ]=$sub_item[ $rdata ];
                $item[ $rdata."_ReadOnly" ]=True;
                array_push($updatedatas,$rdata);
            }
        }

        //var_dump($updatedatas,$sub_item);
        if (count($updatedatas)>0)
        {
            array_push($updatedatas,$data);
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
    }
    
    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_Friend_Datas_Get($data,$user=array())
    {
        return
            $this->MyHash_HashesList_Values
            (
                $this->Permissions_Friend_Get($user),
                $data
            );
    }

    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_Item_Data_Has($data,$item,$user=array())
    {
        $res=False;
        if
            (
                count
                (
                    preg_grep
                    (
                        '/^'.$item[ $data ].'$/',
                        $this->Permissions_Friend_Datas_Get
                        (
                            $data,
                            $user=array()
                        )
                    )
                )>0)
        {
            $res=True;
        }
        
        return $res;
    }
    //*
    //* Returns Profile's select names.
    //*

    function Permissions_Profile_Select_Names()
    {
        $names=array();
        foreach ($this->Profiles() as $profile => $profile_hash)
        {
            if (!empty($profile_hash[ "N" ]))
            {
                $names[ $profile_hash[ "N" ]-1 ]=
                    $this->ApplicationObj()->MyApp_Profile_Name
                    (
                        $profile
                    );
            }
        }

        return $names;
    }
    
    //*
    //* Returns Profile's. Syncronized with Permissions_Profile_Select_Names.
    //*

    function Permissions_Profile_Selects()
    {
        $profiles=array();
        foreach ($this->Profiles() as $profile => $profile_hash)
        {
            if (!empty($profile_hash[ "N" ]))
            {
                $profiles[ $profile_hash[ "N" ]-1 ]=$profile;
            }
        }

        return $profiles;
    }
}

?>