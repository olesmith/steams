<?php


trait MyApp_Interface_LeftMenu_Dynamic_Item_Options
{
    //*
    //* ONCLICK  for $item Link.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Options($base,$obj,$item,$activeid,$name)
    {
        $display='none';
        if ($item[ "ID" ]==$activeid)
        {
            $display='initial';
        }

        return
            array
            (
                "ID" => $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID($base,$obj,$item),
                "STYLE" => array
                (
                    'display' => $display,
                ),
                "TITLE" => array
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Item_Name($name,$item)
                )
            );
    }
    
        
    
    //*
    //* ID  for $item DIV.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_ID($base,$obj,$item,$key="LM")
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
                    $key,
                    $item[ "ID" ]
                )
            );
    }
}

?>