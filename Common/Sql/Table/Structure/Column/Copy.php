<?php


trait Sql_Table_Structure_Column_Copy
{
    //*
    //* Returns query for renaming a column.
    //* 

    function Sql_Table_Column_Copy_Query_Update($oldname,$newname,$table="")
    {
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).

            " SET ".
            $this->Sql_Table_Column_Name_Qualify($newname).
            "=".
            $this->Sql_Table_Column_Name_Qualify($oldname).
            "";
    }
    
    //*
    //* Returns query for renaming a column.
    //* 

    function Sql_Table_Column_Copy_Query($oldname,$newname,$table="")
    {
        $dialect=$this->DB_Dialect();
        $query="";

        $update_query=
            $this->Sql_Table_Column_Copy_Query_Update($oldname,$newname,$table);
        
        if ($dialect=="mysql")
        {
            //$oldcolinfo=$this->Sql_Table_Column_Info($oldname);
            $oldcolinfo=$this->Sql_Table_Column_Hash($oldname,$table);
            
            //var_dump($oldname,$info);
            if (!empty($oldcolinfo))
            {
                $query=
                    "ALTER TABLE ".

                    //ALTER TABLE `tablename` ADD `column2` TEXT NOT NULL;
                    $this->Sql_Table_Name_Qualify($table).
                    " ADD ".
                    $this->Sql_Table_Column_Name_Qualify($newname).
                    " ".
                    $oldcolinfo[ "column_type" ].
                    ";".
                    $update_query.
                    "";
            }
        }
        elseif ($dialect=="pgsql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " ADD ".
                " TO ".
                $this->Sql_Table_Column_Name_Qualify($newname).
                ";".
                $update_query.
                "";
        }

        return $query;
    }

    //*
    //* Safely rename column in table.
    //* 
    //* 

    function Sql_Table_Column_Copy($oldname,$newname,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        if (!$this->Sql_Table_Exists($table)) { return "$table nonexistent"; }

        $message="";
        if ($this->Sql_Table_Field_Exists($oldname,$table))
        {
            if (!$this->Sql_Table_Field_Exists($newname,$table))
            {
                $query=$this->Sql_Table_Column_Copy_Query($oldname,$newname,$table);
                
                $this->DB_Query($query);

                $message="Source column: ".$oldname." copied to ".$newname;
                $this->ApplicationObj()->MyApp_Interface_Message_Add($message);
            }
            else
            {
                $message=$this->ModuleName.": Destination column: ".$newname." already exists (Copy)!";
            }
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
