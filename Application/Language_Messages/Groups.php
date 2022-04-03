<?php

include_once("Groups/Defaults.php");
include_once("Groups/Names.php");
include_once("Groups/Titles.php");
include_once("Groups/Update.php");

class Language_Messages_Groups extends Language_Messages_Group
{
    use
        Language_Messages_Groups_Defaults,
        Language_Messages_Groups_Names,
        Language_Messages_Groups_Titles,
        Language_Messages_Groups_Update;
    
    //*
    //* 
    //*

    function Language_Group_Type_Get($singular)
    {
        $type=$this->Language_Group_Type;
        if ($singular) { $type=$this->Language_SGroup_Type; }

        return $type;
    }
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Messages()
    {
        $edit=$this->Profile_Admin_Is();;

        $item=$this->ItemHash;
        
        $item=$this->MyMod_Item_Update_CGI($item);
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    $edit,
                    "Edit_Message_".$item[ "ID" ],
                    $action="",
                    $this->Language_Message_Html
                    (
                        $edit,
                        $item
                    ),
                    array
                    (
                        "Buttons" => $this->Buttons()
                    )
                )
            )
        );
        
    }
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Html($edit,$item)
    {
        return
            $this->Htmls_Table
            (
                $this->Language_Message_Titles($edit),
                $this->Language_Message_Table($edit,$item)
            );
    }
    
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Table($edit,$item)
    {
        $table=array();
        foreach ($this->Language_Keys() as $lkey)
        {
            array_push
            (
                $table,
                $this->Language_Message_Row($edit,$item,$lkey)
            );
        }

        return $table;
    }
    
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Titles($edit)
    {
        return
            array_merge
            (
                array("Language"),
                array_keys($this->LanguageDataKeys)
            );
    }
    
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Row($edit,$item,$lkey)
    {
        $row=array($this->B($lkey));
        
        foreach (array_keys($this->LanguageDataKeys) as $key)
        {
            $redit=$edit;
            if ($key=="MTime") { $redit=0; }

            $data=$key."_".$lkey;
            
            array_push
            (
                $row,
                $this->MyMod_Data_Field($redit,$item,$data)
            );
        }

        return $row;
    }
}
?>