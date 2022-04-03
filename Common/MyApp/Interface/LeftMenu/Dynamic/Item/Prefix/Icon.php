<?php

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Icon
{
    //*
    //* Generates Dynamic Left menu icon for $item.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Icon($base,$obj,$item,$active,$name,$title,$href,$class,$type,$options=array(),$style=array())
    {
        $icon="fas fa-minus";
        if ($type=="Add") { $icon="fas fa-plus"; }
        
        return
            $this->Htmls_Span
            (
                $this->Htmls_Span
                (
                    array
                    (
                        $this->MyMod_Interface_Icon
                        (
                            $icon,array(),'fa-sm'
                        ),
                        $this->MyApp_Interface_LeftMenu_Dynamic_Item_Name($name,$item),
                    ),
                    array
                    (
                        "STYLE" => array
                        (
                            "white-space" =>  'nowrap',
                        ),
                    )
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Options
                (
                    $base,$obj,$item,$active,$type,
                    $href,$options
                )
            ); 
            
    }
}

?>