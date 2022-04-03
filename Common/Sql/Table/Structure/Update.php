<?php


trait Sql_Table_Structure_Update
{
    var $Sql_Table_Structure_Update_Force=FALSE;
    var $Sql_Table_Structure_Defaults_Added=FALSE;
    var $Sql_Table_Structure_Updated=FALSE;
    var $Sql_Table_Structure_Created=FALSE;
    
    //*
    //* function Sql_Table_Structure_Update, Parameter list: 
    //*
    //* Updates structure of $table, satisfying $regexp. Take care!!
    //* 
    //* 

    function Sql_Table_Structure_Update($datas=array(),$datadefs=array(),$maycreate=TRUE,$table="",$exit_on_create=False)
    {
        if ($this->Sql_Table_Structure_Updated) { return True; }
        
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if ($this->IsMain() && preg_match('/(Logs)$/',$table)) { return; }

        if (count($datadefs)==0){ $datadefs=$this->ItemData(); }
        if (count($datas)==0) {$datas=array_keys($datadefs); }

        $this->Sql_Table_Structure_Update_Prepare($maycreate,$table);

        //Retrieve table info
        $tableinfo=$this->Sql_Tables_Info_Get($table);
        $this->Sql_Table_Structure_Updated=False;

        $res=TRUE;
        $mtime=$this->MyMod_Data_Files_MTime();
        
        if
            (
                $mtime>$tableinfo[ "Time" ]
                ||
                $this->Sql_Table_Structure_Update_Force
            )
        {
            $res=$this->Sql_Table_Fields_Update($datas,$datadefs,$table);

            //Update table info with .
            if ($mtime>$tableinfo[ "Time" ])
            {
                $this->Sql_Tables_Info_Set($table,array("Time" => $mtime));
            }

            $this->Sql_Table_Structure_Updated=True;
            $this->Sql_Table_Structure_Update_Force=False;
        }

        if
            (
                !$this->Sql_Table_Structure_Defaults_Added
                &&
                $this->Sql_Table_Exists($table)
            )
        {
            $this->Sql_Tables_Structure_Default_Items_Add();
            $this->Sql_Table_Structure_Defaults_Added=True;
        }
        
        $this->Sql_Table_Structure_Updated=True;

        if
            (
                $exit_on_create
                &&
                $this->Sql_Table_Structure_Created
                &&
                $this->MakeCGI_CLI_Is()
            )
        {
            print
                "SQL Table ".$table." created - exit and restart\n".
                "Reload (F5) to continue\n\n";

            #system("/usr/bin/php ".join(" ",$_SERVER[ "argv" ]));
            
            exit();
        }
        
        return $res;
    }
    
    //*
    //* function Sql_Tables_Structure_Update, Parameter list: $regexp=""
    //*
    //* Updates structured of tables, conforming to $regexp. Take care!!
    //* 
    //* 

    function Sql_Tables_Structure_Update($regexp="",$where=array(),$datas=array())
    {
        if (empty($regexp)) { $regexp=$this->ModuleName.'$'; }
        
        $tables=$this->Sql_Table_Names($regexp);

        $items=array();
        foreach ($tables as $table)
        {
            $this->Sql_Table_Structure_Update(array(),array(),TRUE,$table);
        }
    }
    
    //*
    //* function Sql_Table_Structure_Update_Prepare, Parameter list: 
    //*
    //* Prepares structure of $table, creating empty table if allowed.
    //* 
    //* 

    function Sql_Table_Structure_Update_Prepare($maycreate=TRUE,$table="")
    {
        $this->ApplicationObj()->TablesColumns[ $table ]=array();
        if
            (
                $maycreate
                &&
                !$this->Sql_Table_Exists($table)
            )
        {
            $this->Sql_Table_Create($table);
            
            //something low, to force update. 0 wont do!
            $this->Sql_Tables_Info_Set
            (
                $table,array("Time" => 1)
            );

            $this->Sql_Table_Structure_Created=True;
        }

        if (!$this->Sql_Table_Exists($table) && !empty($table))
        {
            $this->DoDie
            (
               $this->ModuleName.
               ": Cannot create SQL table: '".
               $this->SqlTableName($table).
               "'",
               $maycreate,
               $this->ApplicationObj()->DBHash
            );
        }
    }
    
}
?>