<?php



trait MyMod_Data_TimeData
{
    //*
    //* function MyMod_Data_TimeData_SET, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Data_TimeData_SET()
    {
        $table=$this->SqlTableName();
        
        if (empty($table)) { return; }
        
        foreach (array("CTime","MTime","ATime") as $data)
        {
            $sql=
                "UPDATE ".$this->Sql_Table_Name_Qualify($table).
                " SET ".$this->Sql_Table_Column_Name_Qualify($data).
                "=".
                $this->Sql_Table_Column_Value_Qualify("0").
                " WHERE ".
                $this->Sql_Table_Column_Name_Qualify($data).
                " IS NULL".
                "";

            $result=$this->DB_Query($sql);
        }
    }
    
    //*
    //* function MyMod_Data_AddTimeData, Parameter list:
    //*
    //* Adds CTime, MTime e ATime to ItemData.
    //*

    function MyMod_Data_AddTimeData()
    {
        $base=array
        (
           "NoAdd" => TRUE,
           "Sql"      => "INT",
           "TimeType" => 1,

           "Public"   => 0,
           "Person"   => 0,
           "Admin"   => 1,
        );

        $defs=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Common/System/Data.Defaults.php"
            );
                   

        $search=False;
        foreach (array("MTime","CTime","ATime") as $data)
         {
             $this->ItemData[ $data ]=
                 array_merge($base,$defs[ $data ]);
         }
    }

}

?>