<?php


trait MyMod_Search_Rows
{   
    //*
    //* Creates form search vars table rows as matrix.
    //*

    function MyMod_Search_Rows_Generate($data,$fixedvalues,$omitvars,$details,$rval="")
    {
        //Search may have been disabled, since call to InitSearchVars - so check again
        $rows=array();
        if
            (
                empty($this->ItemData[ $data ][ "Search" ])
                ||
                !empty($this->ItemData[ $data ][ "NoSearchRow" ])
                ||
                !$this->MyMod_Search_Var_Access($data)
                ||
                !$this->MyMod_Data_Field_Is_Search($data)
            )
        {
            return $rows;
        }

        $rvar=$data;
        if ($this->CheckHashKeyValue($this->ItemData[ $data ],"Compound",1))
        {
            $rvar=$this->SearchVars[ $data ][ "Var" ];
        }

        $rows=array();
        if (!preg_match('/^('. join("|",$omitvars)  .')$/',$rvar))
        {
            if (
                  $this->MyMod_Data_Access($data)>=1
                  ||
                  $this->CheckHashKeyValue($this->ItemData[ $data ],"Compound",1)
                )
            {
                array_push
                (
                    $rows,
                    $this->MyMod_Search_Row_Generate($data,$fixedvalues,$details,$rval)
                );
            }
        }        

        return $rows;
    }

    
}

?>