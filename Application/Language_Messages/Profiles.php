<?php

class Language_Messages_Profiles extends Language_Messages_Types
{
    //*
    //* function Language_Profiles_Update, Parameter list: 
    //*
    //* 

    function Language_Profiles_Update()
    {
        $table=$this->Language_Profiles_2_DB();
        
        return
            array
            (
                $this->H(1,"Profiles in Files"),
                $this->Htmls_Table
                (
                    "",
                    $table
                ),
            );
    }
    
    //*
    //* function , Parameter list: 
    //*
    //* 

    function Language_Profiles_2_DB()
    {
        $table=array();
        $n=1;
        foreach ($this->ApplicationObj()->Profiles as $profile => $item)
        {
            #First singular (Friend)
            $item[ "File" ]=$this->ApplicationObj()->MyApp_Setup_Profiles_File();
            
            $name=$profile;
            if (!empty($item[ "Name"]))
            {
                $name=$item[ "Name"];
            }
            
            $ritem=
                array
                (
                    "Name" => $name,
                    "File" => $this->ApplicationObj()->MyApp_Setup_Profiles_File(),
                );
            
            foreach ($this->Language_Keys() as $language)
            {
                if (!empty($item[ "Name_".$language ]))
                {
                    $ritem[ "Name_".$language ]=$item[ "Name_".$language ];
                }
                else { $ritem[ "Name_".$language ]=$ritem[ "Name" ]; }
            }
            
            $table=
                array_merge
                (
                    $table,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module="",
                        $item[ "File" ],
                        $profile,
                        $ritem,
                        $this->Language_Profile_Type
                    )
                );
            
            #Now plural (Friends)
            $name=$profile;
            if (!empty($item[ "PName"]))
            {
                $name=$item[ "PName"];
            }
            
            $ritem=
                array
                (
                    "Name" => $name,
                    "File" => $item[ "File" ],
                );
            
            foreach ($this->Language_Keys() as $language)
            {
                if (!empty($item[ "PName_".$language ]))
                {
                    $ritem[ "Name_".$language ]=$item[ "PName_".$language ];
                }
                else { $ritem[ "Name_".$language ]=$ritem[ "Name" ]; }
            }

            $table=
                array_merge
                (
                    $table,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module="",
                        $item[ "File" ],
                        $profile."s",
                        $ritem,
                        $this->Language_Profile_Type
                    )
                );
        }

        return $table;
    }
    
    //*
    //* function Language_Profile_Name_Singular, Parameter list: 
    //*
    //* 

    function Language_Profile_Name_Singular($profile)
    {
      return $this->Message_Debug_Pre.
            $this->Language_Message_Get
            (
                $this->Language_Profile_Type,
                $profile,
                array("Name")
            );
    }
    
    //*
    //* function , Parameter list:
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function Language_Profile_Name_Plural($profile)
    {
        return $this->Message_Debug_Pre.
            $this->Language_Message_Get
            (
                $this->Language_Profile_Type,
                $profile."s",
                array("Name")
            );
    }
}
?>