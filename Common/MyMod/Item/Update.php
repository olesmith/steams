<?php

include_once("Update/CGI.php");

trait MyMod_Item_Update
{
    use
        MyMod_Item_Update_CGI;
    
    //*
    //* Updates item form.
    //*

    function MyMod_Item_Update(&$item,$datas)
    {
        $items=$this->MyMod_Items_Update
        (
           array($item),
           $datas
        );

        return array_pop($items);
    }

    //*
    //* Updates item form.
    //*

    function MyMod_Item_Table_Update(&$args)
    {
        $args[ "Item" ]=
            $this->MyMod_Item_Update_CGI
            (
                $args[ "Item" ],
                $args[ "Datas" ],
                $args[ "Item" ][ "ID" ]."_"
            );
    }

    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_SGroup($item,$group,$prepost="",$postprocess=TRUE)
    {
        return
            $this->MyMod_Item_Update_CGI
            (
                $item,
                $this->MyMod_Data_Group_Datas_Get($group,TRUE),
                $prepost,
                $postprocess
            );
    }
    
    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_SGroups($item,$groups,$prepost="",$postprocess=TRUE)
    {
        foreach ($groups as $group)
        {
            $item=
                $this->MyMod_Item_Update_CGI
                (
                    $item,
                    $this->MyMod_Data_Group_Datas_Get($group,TRUE),
                    $prepost,
                    $postprocess
                );
        }

        return $item;
    }    
}

?>