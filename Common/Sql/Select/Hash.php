<?php


trait Sql_Select_Hash
{
    var $Sql_Hash_Echo=False;
    
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $filednames is not an array.. 
    //*
    //* 

    function Sql_Select_Hash($where,$sqldata=array(),$noecho=FALSE,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (!is_array($where) && preg_match('/^\d+$/',$where))
        {
            $where=array("ID" => $where);
        }
        
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        if (count($sqldata)==0) { $sqldata=array(); }

        if ($this->Sql_Hash_Echo)
        {
            print
                $this->Sql_Select_Hashes_Query
                (
                    $where,
                    $sqldata,
                    "",
                    $postprocess=FALSE,
                    $table
                ).
                "\n";
        }

        $items=
            $this->Sql_Select_Hashes($where,$sqldata,"",$postprocess=FALSE,$table);

        $item=NULL;
        if (count($items)==0 && !$noecho)
        { 
            $this->AddMsg
            (
                 $this->ModuleName.
                 ", Sql_Select_Hash: No such item in table: $where'",
                 2
            );
        }
        elseif (count($items)>1 && !$noecho)
        {
            $this->AddMsg
            (
               $this->ModuleName.
               ", Sql_Select_Hash: More than one item in table: '$where'",
               2
            );
        }
        
        $keys=array_keys($items);
        if (count($items)>=1)
        {
            $key=$keys[0];
            //if (!isset($items[])) { var_dump($items); }
            
            $item=$items[ $key ];
        }
        
        return $item;
    }
    
   
    //*
    //* Makes sure that item has read all $datas.
    //*
    //* 

    function Sql_Select_Hash_Datas_Read(&$item,$datas,$table="")
    {
        if (!is_array($datas)) { $datas=array($datas); }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (!isset($item[ $data ]))# || empty($item[ $data ]))
            {
                array_push($rdatas,$data);
            }
        }

        if (count($rdatas)>0 && !empty($item[ "ID" ]))
        {
            $ritem=
                $this->Sql_Select_Hash
                (
                   array("ID" => $item[ "ID" ]),
                   $rdatas,
                   FALSE,
                   $table
                );
            
            foreach ($rdatas as $id => $data)
            {
                $item[ $data ]="";
                if (isset($ritem[ $data ])) { $item[ $data ]=$ritem[ $data ]; }
            }
        }
    }
    
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $filednames is not an array.. 
    //*
    //* 

    function Sql_Select_Hash_Query($where,$sqldata=array(),$noecho=FALSE,$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($sqldata)) { $sqldata=array_keys($this->ItemData); }

        return $this->Sql_Select_Hashes_Query($where,$sqldata,"",$table);
    }

    
    //*
    //* Returns True, if table contains entries conforming to $where.
    //*
    //* 

    function Sql_Select_Exists($where,$table="")
    {
        $item=
            $this->Sql_Select_Hash
            (
                $where,
                array("ID"),
                False,
                $table
            );

        $res=False;
        if (!empty($item[ "ID" ])) { $res=True; }

        return $res;        
    }
    

    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fieldnames or all data if $sqldata is not an array.. 
    //*
    //* 

    function Sql_Select_Hash_Unique($where,$noecho=FALSE,$sqldata=array(),$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (count($sqldata)==0) { $sqldata="*"; }

        $items=$this->Sql_Select_Hashes($where,$sqldata,"ID",FALSE,$table);
        $item=NULL;
        if (count($items)==0 && !$noecho)
        { 
            $this->AddMsg
            (
                 $this->ModuleName.
                 ": SelectUniqueHash: No such item in table $table: $where'",
                 2
            );
        }
        elseif (count($items)>1 && !$noecho)
        {
            $this->AddMsg
            (
               $this->ModuleName.
               ", SelectUniqueHash: More than one item in table $table: '$where'",
               2
            );
        }

        if (count($items)>=1){ $item=$items[0]; }

        return $item;
    }
    
    //*
    //* Locates first (lowest ID) item in SQL table.
    //*
    //* 

    function Sql_Select_First($where=array(),$sqldata=array(),$idfield="ID",$noecho=FALSE,$table="")
    {
        $ids=$this->Sql_Select_Hashes($where,array($idfield),$idfield);
        
        $item=array();
        if (count($ids)>0)
        {
            $where[ $idfield ]=array_shift($ids);
            $item=
                $this->Sql_Select_Hash
                (
                    $where,
                    $sqldata,
                    $noecho,
                    $table
                );
        }

        return $item;
    }
    
}
?>