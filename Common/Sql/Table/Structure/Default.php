<?php


trait Sql_Table_Structure_Default
{    
    //*
    //* Adds items in $this->Sql_Table_Default_Items, in case DB is empty.
    //* 
    //* 

    function Sql_Tables_Structure_Default_Items_Add()
    {
        if
            (
                $this->Sql_Table_Exists()
                &&
                $this->Sql_Select_NHashes
                (
                    $this->Sql_Tables_Structure_Default_No_Items_SqlWhere()
                )==0
            )
        {
            #var_dump($this->ModuleName,$this->Sql_Table_Default_Items());
            foreach ($this->Sql_Table_Default_Items() as $item)
            {
                $item=$this->Sql_Tables_Structure_Default_Item_Init($item);
                //For some reason we must turn check columns off
                $this->Sql_Insert_Item($item,"",$nocheckcols=False);
            }
        }
    }
    
    //*
    //* Returns objects to insert in empty tables.
    //* Meant to be overriden by psecific modules.
    //* 

    function Sql_Table_Default_Items()
    {
        return array();
    }
    
    
    //*
    //* function Sql_Tables_Structure_No_Items_SqlWhere, Parameter list: 
    //*
    //* The table no items sqlwhere, meant to be overwritten.
    //* For example returning $this->UnitEventWhere();
    //* 

    function Sql_Tables_Structure_Default_No_Items_SqlWhere()
    {
        return array();
    }
    
    //*
    //* function Sql_Tables_Structure_Default_Item_Prepare, Parameter list: $item
    //*
    //* Prepares default $item, does nothing but return $item, meant to be overwritten.
    //* Allows doing more to the items inserted.
    //* 

    function Sql_Tables_Structure_Default_Item_Init($item)
    {
        return $item;
    }

}
?>