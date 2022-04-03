<?php


trait MyMod_Actions
{
    //*
    //* function  MyMod_Item_Action_Icon, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array()
    //*
    //* Generates only action icon.
    //*

    function MyMod_Item_Action_Icon($data,$item)
    {   
        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Download";
        $args[ "ID" ]= $item[ "ID" ];
        $args[ "Data" ]=$data;

        $img=$data;
        if (!empty($this->Actions[ $data ][ "Icon" ]))
        {
            $img=
                $this->IMG
                (
                    "icons/".$this->Actions[ $data ][ "Icon" ],
                    $data,
                    20,20
                );
        }

        return $img;
    }
    
}

?>