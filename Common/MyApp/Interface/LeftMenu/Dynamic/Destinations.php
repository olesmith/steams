<?php


trait MyApp_Interface_LeftMenu_Dynamic_Destinations
{
    //*
    //* Generates Dynamic Left menu Destinations for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Destinations($base,$obj,$items,$class,$load_destinations)
    {
        $destinations=array();
        foreach ($items as $id => $item)
        {
            $destinations[ $id ]=
                $this->MyApp_Interface_LeftMenu_Dynamic_Destination
                (
                    $base,$obj,$item,
                    $class,$load_destinations
                );
        }

        return $destinations;
    }
}

?>