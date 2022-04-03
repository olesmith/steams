<?php

trait MyMod_Messages_List
{

    var $MyMod_Messages_List_Messages=array();
    
    
    //* 
    //*

    function MyMod_Messages_List_Messages_Empty()
    {
        $this->MyMod_Messages_List_Messages=array();
    }
    
    //*
    //*
    //*

    function MyMod_Messages_List_Message_Add($msgs)
    {
        if (!is_array($msgs))   { $msgs=array($msgs); }

        
        array_push
        (
            $this->MyMod_Messages_List_Messages,
            $msgs
        );
    }
    
    //*
    //* 
    //*

    function MyMod_Messages_List_Messages($item=array(),$title="")
    {
        if (empty($this->MyMod_Messages_List_Messages)) { return array(); }

        return
            array
            (
                $this->Htmls_Frame
                (
                    array
                    (
                        $this->MyMod_Messages_List_Messages_Title($title),
                        $this->MyMod_Messages_List_Messages_Html()
                    ),
                    array("ALIGN" => 'center')
                ),
                ""
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Messages_List_Messages_Html()
    {
        return
            $this->Htmls_Table
            (
                $this->MyMod_Messages_List_Messages_Titles(),
                $this->MyMod_Messages_List_Messages_Table()
            );
    }

    //*
    //* 
    //*

    function MyMod_Messages_List_Messages_Title($title="")
    {
        if (empty($title))
        {
            $title=
                $this->MyLanguage_GetMessage("Update").
                " ".
                $this->MyMod_ItemsName().
                ", ".
                $this->LanguagesObj()->MyMod_ItemsName().
                ":";
        }
        
        return $this->H(5,$title);
    }
    
    //*
    //* 
    //*

    function MyMod_Messages_List_Messages_Table($empty=True)
    {
        $table=array();
        foreach (array_keys($this->MyMod_Messages_List_Messages) as $id)
        {
            if (!is_array($this->MyMod_Messages_List_Messages[ $id ]))
            {
                $this->MyMod_Messages_List_Messages[ $id ]=
                    array
                    (
                        $this->MyMod_Messages_List_Messages[ $id ]
                    );
            }
            
            array_push
            (
                $table,
                array_merge
                (
                    array($id+1),
                    $this->MyMod_Messages_List_Messages[ $id ]
                )
            );
        }

        if ($empty)
        {
            $this->MyMod_Messages_List_Messages_Empty();
        }
        
        return $table;
    }
    
    //*
    //* 
    //*

    function MyMod_Messages_List_Messages_Titles()
    {
        return
            array("No.","Type","Status","Info");
    }
        
}

?>