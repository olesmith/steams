<?php

include_once("Application/APIs.php");

include_once("APIs/Access.php");


class APIs extends Application_APIs
{
    use
        APIs_Access;
    
    //*
    //* Constructor.
    //*

    function APIs($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
            );
        $this->CellMethods[ "Application_API_Cell_Result" ]=TRUE;
                
        $this->Reverse=True;
        $this->Sort=array("CTime");
    }


    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }
}

?>