<?php

trait MyMod_Items_Dynamic_Paging_Destination
{
    //*
    //* Dynamic items page menu item.
    //*

    function MyMod_Items_Dynamic_Paging_Destination($page,$items_table)
    {
         return
            array
            (
                "Tag" => "DIV",
                "Display" => 'initial',
                "Hide"     => $this->MyMod_Items_Dynamic_Paging_Destination_Hide($page),
                
                "ID"       => $this->MyMod_Items_Dynamic_Paging_Destination_Cell_ID($page),
                
                "Title"     => "Title",
                "Name"     => "Name",
                
                "Contents" => $this->MyMod_Items_Dynamic_Paging_Destination_Contents
                (
                    $page,$items_table
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Destination_Hide($page)
    {
        return ($page!=$this->MyMod_Paging_No);
    }
    //*
    //* Dynamic items page menu item.
    //*

    function MyMod_Items_Dynamic_Paging_Destination_Contents($page,$items_table)
    {
        $contents="Loading Page ".$page;
        if ($page==$this->MyMod_Paging_No) { $contents=$items_table; }

        return
            array
            (
                $contents,
                $this->MyLanguage_GetMessage("Page").
                " ".
                $page,
            );
    }
    
    //*
    //* Dynamic items page menu item.
    //*

    function MyMod_Items_Dynamic_Paging_Destination_Cell_ID($page,$key="Dest")
    {
        return
            $this->CGI_GET("Dest")."_".$page."_".$key;
    }
    
}

?>