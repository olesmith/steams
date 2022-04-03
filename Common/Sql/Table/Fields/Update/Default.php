<?php

trait Sql_Table_Fields_Update_Default
{
    //*
    //* function Sql_Table_Field_Default_Set_Query, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds column $data to $table.
    //* 

    function Sql_Table_Field_Default_Set_Query($data,$value,$table="")
    {
        return
            "ALTER TABLE ".
            $this->Sql_Table_Name_Qualify($table).
            " ALTER COLUMN ".
            $this->Sql_Table_Column_Name_Qualify($data).
            " SET DEFAULT ".
            $this->Sql_Table_Column_Value_Qualify($value);
    }
    
     //*
    //* function Sql_Table_Field_Default_Should, Parameter list: $data,$datadef=array()
    //*
    //* Sets column default to $value.
    //* 

    function Sql_Table_Field_Default_Should($data,$datadef=array())
    {        
        if (empty($datadef) && !empty($this->ItemData[ $data ])) { $datadef=$this->ItemData[ $data ]; }

        $res=FALSE;
        if (
              !empty($datadef[ "Default" ])
              &&
              $datadef[ "Default" ]!="0 "
              &&
              !preg_match('/^(TEXT|BLOB)$/i',$datadef[ "Sql" ])
           )
        {
            $res=TRUE;
        }

        return $res;
    }

    
   //*
    //* function Sql_Table_Field_Default_Set, Parameter list: $data,$value,$table=""
    //*
    //* Sets column default to $value.
    //* 

    function Sql_Table_Field_Default_Set($data,$value,$table="")
    {        
        //if (empty($value) || $value=="0 ")    { return; }

        $query=
            $this->Sql_Table_Field_Default_Set_Query($data,$value,$table);
        
        $this->QueryDB($query);

        $msg=
            $query."<BR>".
            "Alter ".$table.": ".$data." default => ".$value;
      
        $this->ApplicationObj()->AddPostMessage($msg,1,TRUE);
        if (!$this->MakeCGI_CLI_Is())
        {
            $this->ApplicationObj->LogMessage(5,$msg);
        }
    }
}


?>