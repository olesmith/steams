<?php

trait Sql_Unique
{
    var $UniqueColumns=array();
    var $TestUnicity=TRUE;
    var $CroakUnicity=TRUE;
    var $AutoCorrectUnicity=TRUE;
    
    //*
    //* Makes sure $item exists in SQL $table, according to $where. If not creates it.
    //* If $item exists, updates it.
    //* 

    function Sql_Unique_Item_Update($where,&$item,$table="",$nocheckcols=FALSE)
    {
        $ritem=
            $this->Sql_Select_Hash
            (
                $where,
                TRUE,
                array("ID"),
                $table
            );

        if (empty($ritem))
        {
            if ($table!="__Table__")
            {
                foreach (array("ATime","CTime","MTime") as $key)
                {
                    $item[ $key ]=time();
                }
            }

            $this->Sql_Insert_Item($item,$table,$nocheckcols);
        }
        else
        {
            $this->Sql_Update_Item($item,$where,array(),$table);
        }

        return $item;
    }

    //*
    //* Adds $item according to whether exists with $where.
    //* If $item already exists, updates.
    //* 

    function Sql_Unique_Add_Or_Update($where,&$item,$namekey="ID",$readdatas=array(),$table="")
    {
        if ($table=="") { $table=$this->SqlTableName($table); }

        $ritem=
            $this->Sql_Select_Hash
            (
                $where,
                array("ID"),
                TRUE,
                $table
            );

        if (!empty($ritem))
        {
            //Retrieve ID and update
            $item[ "ID" ]=$ritem[ "ID" ];
            foreach ($readdatas as $key)
            {
                if (!isset($item[ $key ]))
                {
                    $item[ $key ]="";
                }
            }

            $this->Sql_Update_Item
            (
               $item,
               array("ID" => $item[ "ID" ]),
               array(),
               $table
            );

            print "update<BR>";var_dump($item);
            return 2;
        }
        else
        {
            foreach (array("ATime","CTime","MTime") as $key)
            {
                $item[ $key ]=time();
            }

            $res=$this->Sql_Insert_Item($item,$table);

            //print "insert<BR>";
            //var_dump($item,$table);
            return 1;
        }

        return -1;
    }

    //*
    //* Returns Unique SQL where as hash.
    //*

    function Sql_Unique_Read($where)
    {
        //$this->TestUnicity($where);
        $items=
            $this->Sql_Select_Hashes
            (
                $where,
                array()
            );

        $item=array();
        if (count($items)>1)
        {
            $ids=array();
            foreach ($items as $item)
            {
                array_push($ids,$item[ "ID" ]);
            }

            array_pop($ids);
            $this->Sql_Delete_Items
            (
                array_merge
                (
                    $where,
                    array("ID" => $ids)
                )
            );

            $items=
                $this->Sql_Select_Hashes
                (
                    $where,
                    array()
                );
            
            var_dump("Non-unique items",$ids);
        }
        
        if (count($items)>=1)
        {
            $item=array_pop($items);
            //var_dump("Unique item",$item[ "ID" ]);
        }

        return $item;
    }

    //*
    //* Creates unique entry.
    //*

    function Sql_Unique_Create($where,$values=array())
    {
        //var_dump("create");
        $nentries=
            $this->Sql_Select_NHashes($where);
        if ($nentries>1)
        {
            var_dump("Sql_Unique_Create:  doubled item");
        }

        $item=array();
        if ($nentries==0)
        {
            $item=$where;
            foreach ($values as $key => $value)
            {
                $item[ $key ]=$value;
            }

            $this->Sql_Insert_Item($item);

            return TRUE;
        }
    }

    //*
    //* Updates unique entry.
    //*

    function Sql_Unique_Update($where,$values=array())
    {
        $item=$this->Sql_Unique_Read($where);
        if ($this->Sql_Select_NHashes($where)==1)
        {
            foreach ($values as $key => $value)
            {
                $item[ $key ]=$value;
            }

            $this->Sql_Update_Item_Values_Set(array_keys($values),$item);
            //var_dump("update",$this->Sql_Update_Item_Values_Set_Query(array_keys($values),$item));
        }

        return FALSE;
    }
    
    //*
    //* Deletes unique entry.
    //*

    function Sql_Unique_Delete($where)
    {
        //var_dump("delete");
        if ($this->Sql_Select_NHashes($where)==1)
        {
            $this->Sql_Delete_Items($where);
            return TRUE;
        }

        return FALSE;
    }

}
?>