<?php

trait MyMod_Handle_Export_Table
{
    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function MyMod_Handle_Export_Table_Datas()
    {
        return $this->MyMod_Handle_Export_CGI_Fields_Datas();
    }
    
    //*
    //* Generates data select table.
    //*

    function MyMod_Handle_Export_Datas_Table()
    {
        $nmax=$this->MyMod_Handle_Export_CGI_NFields();

        $table=array();
        for ($n=1;$n<=$nmax;$n++)
        {
            array_push
            (
                $table,
                array
                (
                    $this->B("Col. #".$n),
                    $this->MakeSelectField
                    (
                        "Data_".$n,
                        $this->Export_Datas,
                        $this->Export_Data_Names,
                        $this->MyMod_Handle_Export_CGI_Fields($n,"Data")
                    ),
                    $this->MakeCheckBox
                    (
                        "Sort_".$n,
                        1,
                        $this->MyMod_Handle_Export_CGI_Fields($n,"Sort")
                    )
                )
            );
        }

        return $table;
     }

    //*
    //* Generates exports select table.
    //*

    function MyMod_Handle_Export_Types_Table()
    {
        $exports=array("HTML","CSV","LaTeX","PDF","SQL","PHP");

        $table=array();
        array_push
        (
            $table,
            array
            (
                $this->B($this->MyLanguage_GetMessage("Export_Form_NColumns_Title").":"),
                $this->MakeInput
                (
                    "NFields",
                    $this->MyMod_Handle_Export_CGI_NFields(),
                    2
                ),
                $this->B($this->MyLanguage_GetMessage("Export_Form_Reverse_Title").":"),
                $this->MakeCheckBox
                (
                    "Sort_Reverse",
                    1,
                    $this->MyMod_Handle_Export_CGI_Reverse()
                )
            ),
            array
            (
                $this->B($this->MyLanguage_GetMessage("Export_Form_Format_Title").":"),
                $this->MakeSelectField
                (
                    "Export_Type",
                    $exports,
                    $exports,
                    $this->MyMod_Handle_Export_CGI_Type()
                ),
                $this->B($this->MyLanguage_GetMessage("Export_Form_No_Enums_Title").":"),
                $this->MakeCheckBox
                (
                    "No_Enums",
                    1,
                    $this->MyMod_Handle_Export_CGI_No_Enums()
                )
            )
        );

        return $table;
    }

    //*
    //* Returns No col formatter.
    //*

    function MyMod_Handle_Export_Table_Format()
    {
        $format="%d";
        $nc=count(array_keys($this->ItemHashes));

            if ($nc>10000)  { $format="%05d"; }
        elseif ($nc>100000) { $format="%06d"; }
        elseif ($nc>1000)   { $format="%04d"; }
        elseif ($nc>100)    { $format="%03d"; }
        elseif ($nc>10)     { $format="%02d"; }

        return $format;
    }
    
    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function MyMod_Handle_Export_Table($fields,$applyenums=TRUE,$links=TRUE)
    {
        $this->MyMod_Handle_Export_Read();

        $this->MyMod_Handle_Export_Sort_Do();

        $format=$this->MyMod_Handle_Export_Table_Format();
        
        $this->DatasRead=array();

        $table=array();
        $m=1;
        foreach (array_keys($this->ItemHashes) as $id)
        {
            array_push
            (
                $table,
                $this->MyMod_Handle_Export_Row
                (
                    sprintf($format,$m),
                    $this->MyMod_Handle_Export_Table_Datas(),
                    $this->ItemHashes[ $id ]
                )
            );
            $m++;
        }

        return $table;

    }
}
?>