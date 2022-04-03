<?php


trait Sql_Table_Structure_Column_Rename
{
    //*
    //* Returns query for renaming a column.
    //* 

    function Sql_Table_Column_Rename_Query($oldname,$newname,$table="")
    {
        $dialect=$this->DB_Dialect();
        $query="";
        if ($dialect=="mysql")
        {
            $oldcolinfo=$this->Sql_Table_Column_Info($oldname);
            $oldcolinfo=$this->Sql_Table_Column_Hash($oldname,$table);
            
            //var_dump($oldname,$info);
            if (!empty($oldcolinfo))
            {
                $query=
                    "ALTER TABLE ".
                    $this->Sql_Table_Name_Qualify($table).
                    " CHANGE COLUMN ".
                    $this->Sql_Table_Column_Name_Qualify($oldname).
                    " ".
                    $this->Sql_Table_Column_Name_Qualify($newname).
                    " ".
                    $oldcolinfo[ "column_type" ];
            }
        }
        elseif ($dialect=="pgsql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " RENAME COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($oldname).
                " TO ".
                $this->Sql_Table_Column_Name_Qualify($newname);
        }

        return $query;
    }

    //*
    //* Safely rename column in table.
    //* 
    //* 

    function Sql_Table_Column_Rename($oldname,$newname,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        if (!$this->Sql_Table_Exists($table)) { return "$table nonexistent"; }

        $message="";
        if ($this->Sql_Table_Field_Exists($oldname,$table))
        {
            if (!$this->Sql_Table_Field_Exists($newname,$table))
            {
                $query=$this->Sql_Table_Column_Rename_Query($oldname,$newname,$table);
                
                $this->DB_Query($query);

                $message="Source column: ".$oldname." renamed to ".$newname;
            }
            else
            {
                $message="Destination column: ".$newname." already exists!";
            }
            
            $this->ApplicationObj()->MyApp_Interface_Message_Add($this->ModuleName.": ".$message);
        }
        else
        {
            $message="Source column: ".$oldname." does not exist. OK!";
            if ($this->Sql_Table_Field_Exists($newname,$table))
            {
                $message=
                    "Destination column: ".$newname." OK!";
            }
            
        }

        return
            $this->ModuleName.", ".$table.": ".
            $message;
    }
}
?>
