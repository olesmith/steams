<?php

include_once("Messages/List.php");

trait MyMod_Messages
{
    use MyMod_Messages_List;
    //*
    //* function MyMod_Messages_Files, Parameter list: 
    //*
    //* Returns list of module messaged files.
    //*

    function MyMod_Messages_Files()
    {
        return 
            array_merge
            (
               $this->MyMod_Data_Files_Get(),
               $this->MyActions_GetFiles(),
               $this->MyMod_Data_Groups_Files_GetFiles(FALSE),
               $this->MyMod_Data_Groups_Files_GetFiles(TRUE)
            );
    }
    
    //*
    //* function MyMod_Messages_Edit, Parameter list: $edit
    //*
    //* Handles message editing
    //*

    function MyMod_Messages_Edit($edit)
    {        
        $table=$this->ApplicationObj()->MyApp_Messages_Edit_Title_Rows("");
        
        foreach ($this->MyMod_Messages_Files() as $file)
        {
            $rtable=
               $this->ApplicationObj()->MyApp_Messages_Edit_File
               (
                  $edit,
                  "",
                  $file,
                  array("Name","Title","ShortName")
                );
            
            $path=dirname($file);
            foreach (array_keys($rtable) as $n)
            {
                array_unshift($rtable[ $n ],$path);
                //$path="";
            }

            $table=array_merge($table,$rtable);
        }

         return
            $this->H(1,"System Messages").
            $this->H(2,"Module: ".$this->ModuleName).
            $this->Html_Table("",$table).
            "";
    }

    var $Has_Messages_Access=-1;

    //*
    //* Checks whether we have access to messages.
    //*

    function MyMod_Messages_Access_Has()
    {
        if ($this->Has_Messages_Access<0)
        {
            $this->Has_Messages_Access=
                $this->MyMod_Messages_Access_Detect();
        }

        return $this->Has_Messages_Access;
    }
    
    //*
    //* Checks whether we have access to messages.
    //*

    function MyMod_Messages_Access_Detect()
    {
        $res=False;
        if ($this->Current_User_Admin_Is())
        {
            $res=True;
        }

        if
            (
                 $this->Profile_Trust()>=$this->Profile_Trust("Coordinator")
            )
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* function MyMod_Action_Name, Parameter list: 
    //*
    //* Returns name or title of $action.
    //*

    function MyMod_Action_Name($action,$key="Name")
    {
        return  $this->LanguagesObj()->Language_Action_Title_Get($this,"Questionary");
    }
}

?>