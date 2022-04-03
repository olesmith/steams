<?php


trait MyMod_Item_Unique
{
    //*
    //* Extracts unicity keys from $item.
    //*

    function MyMod_Item_Unicity_Where($item,$datas=array())
    {
        $datas=array_merge($this->MyMod_Unicity_Fields,$datas);

        $where=array();
        foreach ($datas as $data)
        {
            $where[ $data ]=$item[ $data ];
        }

        return $where;
    }
    
    //*
    //* Tests if data declared uniques ("Unique" => 1) is really unique.
    //* First detects the list of data that needs to be unique.
    //* Then queiries the DB if any of these values in $item
    //* are already present.
    //* Returns the TRUE, if everything OK, FALSE it nonunique.
    //*

    function MyMod_Item_Unique_Is(&$item)
    {
        foreach ($this->ItemData as $data => $value)
        {
            if (empty($this->ItemData[ $data ][ "Unique" ])) { continue; }
            if (empty($item[ $data ])) { continue; }

            $nitems=$this->Sql_Select_NHashes(array($data => $item[ $data ]));
            if ($nitems>0)
            {

                $this->ApplicationObj->MyApp_Interface_Message_Add
                (
                    $this->MyMod_ItemName().
                    " ".
                    $this->MyLanguage_GetMessage("Item_Not_Unique").
                    " ".
                    $data
                );

                $this->MyMod_Unicity_Field_Offending=$data." (".$item[ $data ].")";
                return FALSE; // return right away, minimizing mysql talks
            }
        }

        if (!empty($this->UniqueSqlWhere))
        {
            $nitems=$this->Sql_Select_NHashes($this->UniqueSqlWhere);

            if ($nitems>0)
            {
                $this->ApplicationObj()->MyApp_Interface_Message_Add
                (
                    $this->MyMod_ItemName().
                    " ".
                    $this->MyLanguage_GetMessage("Item_Not_Unique")
                );
                
                return FALSE; 
            }
            
        }

        if (!empty($this->MyMod_Unicity_Fields))
        {
            if
                (
                    $this->Sql_Select_NHashes
                    (
                        $this->MyMod_Item_Unicity_Where($item)
                    )>0
                )
            {
                $msg=
                    $this->MyMod_ItemName().
                    " ".
                    $this->MyLanguage_GetMessage("Item_Not_Unique").
                    " ".
                    $this->MyLanguage_GetMessage("Item_Not_Added");
                
                $this->ApplicationObj()->MyApp_Interface_Message_Add($msg);
                $this->MyMod_Handle_Message=$this->Span($msg,array("CLASS" => 'error'));
                
                return FALSE;                 
            }
            
        }

        return TRUE;
    }

 }

?>