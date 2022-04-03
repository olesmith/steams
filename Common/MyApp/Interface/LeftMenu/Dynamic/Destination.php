<?php


trait MyApp_Interface_LeftMenu_Dynamic_Destination
{
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Destination($base,$obj,$item,$class,$load_destinations)
    {
        return
            array
            (
                "ID" => $this->MyApp_Interface_LeftMenu_Dynamic_Destination_ID
                (
                    $base,$obj,$item
                ),
                "Class" => array($class),
                "Name"     =>  "",
                "Contents"     =>  "",
                "Trailing" =>  $this->MyApp_Interface_LeftMenu_Dynamic_Destination_Trailing
                (
                    $base,$obj,$item,$load_destinations
                ),
                       
                "Tag" => "DIV",
                    
                "Display" => 'none',
                "Hide"     => False,
            );
    }
    
    //*
    //*
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Destination_Trailing($base,$obj,$item,$load_destinations)
    {
        $content=array();
        if ($load_destinations)
        {
            $content=
                array
                (
                );
        }
        
        return $content;
    }
    
    //*
    //* ID (unique) for destination cell.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Destination_ID($base,$obj,$item)
    {
        if (!empty($base)) { $base.="_"; }
        
        return
            join
            (
                "_",
                array
                (
                    $base.
                    $obj->ModuleName,
                    $item[ "ID" ],
                    "Dest"
                )
            );
    }
}

?>