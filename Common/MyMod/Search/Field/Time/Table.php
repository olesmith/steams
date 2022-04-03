<?php


trait MyMod_Search_Field_Time_Table
{
    //*
    //* Generates time search fields as a table (matrix).
    //*

    function MyMod_Search_Field_Time_Table($data,$rdata,$rval)
    {
        $cgi=$this->MyMod_Search_Field_Time_CGI($data,$rdata,$rval);
        
        $table=array();
        foreach ($this->MyMod_Search_Field_Time_Fields() as $field)
        {
            array_push
            (
                $table,
                $this->MyMod_Search_Field_Time_Field_Row($cgi,$field,$data,$rdata,$rval)
            );
        }
        
        array_push
        (
            $table,
            array
            (
                join
                (
                    " - ",
                    array
                    (
                        $this->TimeStamp2Text
                        (
                            $this->MyTime_Info_2_MTime
                            (
                                $cgi[ "From" ]
                            )
                        ).
                        " (".$cgi[ "From" ][ "t" ].")",
                        $this->TimeStamp2Text
                        (
                            $this->MyTime_Info_2_MTime
                            (
                                $cgi[ "To"   ]
                            )
                        ),
                        " (".$cgi[ "To" ][ "t" ].")",
                        $cgi[ "To" ][ "t" ]-$cgi[ "From" ][ "t" ]
                    )
                ),
            )
        );
        
        return $table;
    }
}

?>