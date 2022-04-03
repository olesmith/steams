<?php


trait MyApp_Interface_LeftMenu_Dynamic_Entries
{
    //*
    //* Generates Dynamic Left menu Entries for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entries($base,$obj,$items,$action,$href,$cgivar,$name,$title,$class)
    {
        $entries=array();
        foreach ($items as $id => $item)
        {
            $entries[ $id ]=
                $this->MyApp_Interface_LeftMenu_Dynamic_Entry
                (
                    $base,$obj,$item,
                    $action,
                    $href,$cgivar,$name,$title,
                    $class
                );
        }      

        return $entries;
    }
    
}

?>