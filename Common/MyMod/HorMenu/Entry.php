<?php

include_once("Entry/ID.php");
include_once("Entry/URL.php");
include_once("Entry/JS.php");

trait MyMod_HorMenu_Entry
{
    use
        MyMod_HorMenu_Entry_ID,
        MyMod_HorMenu_Entry_URL,
        MyMod_HorMenu_Entry_JS;
        
    //*
    //* Generates $action entry.
    //*

    function MyMod_HorMenu_Entry($singular,$action,$cssclass,$id,$item)
    {
       $entry=
            array
            (
                "Tag" => "SPAN",
                "Class" => 'dynamicmenuitem',
                //"Debug" => True,
                
                "ID" => $this->MyMod_HorMenu_Entry_ID
                (
                    $action,
                    $id,
                    $item
                ),
                "Name" =>  $this->MyMod_HorMenu_Entry_Name
                (
                    $action,$id,$item
                ),
                       
                "Destination" => $this->MyMod_HorMenu_Destination_ID
                (
                    $action
                ),
                
                "Hide" => $this->MyMod_HorMenu_Action_Active($action),
                "Onclick" => $this->MyMod_HorMenu_Entry_JS
                (
                    $action,$id,$item
                ),
                "Offclick" => "1;",
            );

        return $entry;
    }

   
    //*
    //*
    //*

    function MyMod_HorMenu_Entry_Name($action,$id,$item,$key="Name")
    {
        return
            preg_replace
            (
                '/#ID/',$id,
                $this->LanguagesObj()->Language_Action_Name_Get
                (
                    $this,
                    $action,
                    $key
                )
            );
    }
    
}

?>