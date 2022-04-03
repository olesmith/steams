<?php


include_once("Items/Trim.php"); 
include_once("Items/Read.php"); 
include_once("Items/Ors.php"); 
include_once("Items/Row.php"); 
include_once("Items/Table.php"); 
include_once("Items/Html.php"); 
include_once("Items/Menu.php"); 
include_once("Items/Group.php"); 
include_once("Items/Post.php"); 
include_once("Items/Search.php"); 
include_once("Items/PHP.php"); 
include_once("Items/Print.php"); 
include_once("Items/Latex.php"); 
include_once("Items/Update.php"); 
include_once("Items/Rows.php"); 
include_once("Items/Dynamic.php");

//Exports
include_once("Items/CSV.php"); 
include_once("Items/JSON.php"); 
include_once("Items/SQL.php"); 

trait MyMod_Items
{
    use
        MyMod_Items_Trim,
        MyMod_Items_Read,
        MyMod_Items_Table,
        MyMod_Items_Html,
        MyMod_Items_Menu,
        MyMod_Items_Group,
        MyMod_Items_Post,
        MyMod_Items_Row,
        MyMod_Items_Ors,
        MyMod_Items_Search,
        MyMod_Items_PHP,
        MyMod_Items_Print,
        MyMod_Items_Latex,
        MyMod_Items_Update,
        MyMod_Items_Rows,
        MyMod_Items_Dynamic,

        //Exports
        MyMod_Items_CSV,
        MyMod_Items_JSON,
        MyMod_Items_SQL;
        
    //*
    //* function MyMod_Items_Where_Clause_Real, Parameter list: $where="",$data=""
    //*
    //* Returns the real where clause, that is $this->SqlWhere properly
    //* prepended.
    //*

    function MyMod_Items_Where_Clause_Real($where="",$data="")
    {
        if (is_array($where)) { $wheres=$where; }
        else                  { $wheres=$this->SqlClause2Hash($where); }

        $rwheres=$this->SqlWhere;
        if (!is_array($this->SqlWhere))
        {
            $rwheres=$this->SqlClause2Hash($this->SqlWhere);
        }

        
        foreach ($rwheres as $key => $value)
        {
            if (empty($wheres[ $key ]))
            {
                $wheres[ $key ]=$value;
            }
        }
        //$where=$this->Sql_Where_From_Hash($wheres);

        if ($this->LoginType!="Public")
        {
            foreach ($wheres as $key => $value)
            {
                if (is_string($value))
                {
                    $where[ $key ]=
                        preg_replace
                        (
                            '/#Login/',
                            $this->LoginData[ "ID" ],
                            $value
                        );
                }
            }
        }

        if
            (
                //empty($where) &&
                method_exists($this,"Default_Sql_Where")
            )
        {
            $wheres=$this->Default_Sql_Where($wheres);
        }
        
        return $wheres;
    }

    //*
    //* function SkipNonAllowedItems, Parameter list: 
    //*
    //* Reviews all items in $this->ItemHashes:
    //*
    //* If $this->ConditionalShow or $this->Actions[ "Show" ][ "AccessMethod" ]
    //* are defined, calls $this test method on each item.
    //* If test method does not return TRUE, unsets item in $this->ItemHashes.
    //*

    function MyMod_Items_Non_Allowed_Skip()
    {
        if ($this->LoginType!="Admin")
        {
            $method=$this->ConditionalShow;
            if ($method=="" && isset($this->Actions[ "Show" ]))
            {
                $method=$this->Actions[ "Show" ][ "AccessMethod" ];
            }

            if (!empty($method))
            {
                foreach ($this->ItemHashes as $id => $item)
                {
                    if (!$this->$method($item))
                    {
                       unset($this->ItemHashes[ $id ]);
                    }
                }
            }

        }
    }

    
    
    //*
    //* Set item default values for all items in $this->ItemHashes.
    //*

    function MyMod_Items_Defaults_Set($datas,$ids=array())
    {
        if (count($ids)==0) { $ids=array_keys($this->ItemHashes); }

        $rdatas=array();
        foreach ($datas as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Default" ]))
            {
                array_push($rdatas,$data);
            }
        }


        foreach ($ids as $id)
        {
            foreach ($rdatas as $data)
            {
                if (!isset($this->ItemHashes[$id][ $data ])                   )
                {
                    $this->ItemHashes[$id][ $data ]=
                        $this->ItemData[ $data ][ "Default" ];

                    if ($this->Sql_Table_Field_Exists($data))
                    {
                        $this->Sql_Update_Item_Value_Set
                        (
                            $this->ItemHashes[$id][ "ID" ],
                            $data,
                            $this->ItemData[ $data ][ "Default" ]
                        );
                    }
                }
            }
        }
    }
    
    //*
    //* Numbers items according to their order.
    //*

    function MyMod_Items_Number(&$items,$n=1)
    {
        $nn=$n+count($items);

        #Number of zeros
        $m=1;
        while ($nn<$m)
        {
            $m=$m*10;
            $m++;
        }

        foreach (array_keys($items) as $id)
        {
            $items[ $id ][ "No" ]=sprintf("%0".$m."d",$n++);
        }
    }
}

?>