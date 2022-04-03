<?php

include_once("Prints/Sort.php");
include_once("Prints/Cells.php");
include_once("Prints/Rows.php");
include_once("Prints/Table.php");
include_once("Prints/Html.php");
include_once("Prints/Form.php");

trait MyMod_Handle_Prints
{
    use
        MyMod_Handle_Prints_Sort,
        MyMod_Handle_Prints_Cells,
        MyMod_Handle_Prints_Rows,
        MyMod_Handle_Prints_Table,
        MyMod_Handle_Prints_Html,
        MyMod_Handle_Prints_Form;
    //*
    //* Handles module object Prints.
    //*

    function MyMod_Handle_Prints($where=array(),$latexheaders=True)
    {
        $type="PluralLatexDocs";

        if (empty($_GET[ "Print" ]))
        {
            $this->Htmls_Echo
            (
                $this->MyMod_Handle_Prints_Html($type)
            );
            
            return;
        }

        $docno=$this->MyMod_Latex_DocNo();

        
        
        $this->MyMod_Items_Read
        (
            $where,
            array_keys($this->ItemData),
            False,True
        );

        $this->LastItem=$this->ItemHashes[0];
        
        $this->Sort=$this->MyMod_Handle_Prints_Sort($type,$docno);

        $type="Plural";
        
        $latex=
            $this->MyMod_Items_Latex();

        if ($latexheaders)
        {
            $latex=
                $this->MyMod_Latex_Skel
                (
                    $type,
                    "Head",
                    $docno
                ).
                $latex.
                $this->MyMod_Latex_Skel
                (
                    $type,
                    "Tail",
                    $docno
                );
        }
        
        $latex=$this->MyMod_Latex_Filter($latex);

        //Use last item to filter
        $latex=
            $this->FilterObject
            (
                $this->FilterHash
                (
                    $latex,
                    //Was saved by MyMod_Items_Latex
                    $this->LastItem
                )
            );

        
        $texfile=
            $this->MyMod_Handle_Prints_OutName($docno);

        $doc=$this->LatexDoc("PluralLatexDocs",$docno);
        if (!empty($doc[ "Debug" ]))
        {
            var_dump($texfile);
            $this->Latex_Code_Show($latex);
            exit();
        }        
        $this->Latex_PDF
        (
            $texfile,
            $latex
            //,
            //$printpdf = true, $runbibtex = false, $copypdfto = false
        );
        
       
    }

    //*
    //* 
    //*

    function MyMod_Handle_Prints_OutName($docno)
    {
        return
            preg_replace
            (
                '/\s+/',
                "-",
                $this->Html2Sort
                (
                    join
                    (
                        ".",
                        $this->MyMod_Handle_Prints_OutNames($docno)
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Prints_OutNames($docno)
    {
        return
            array
            (
                $this->LatexData[ "PluralLatexDocs" ][ "Docs" ]
                [ $docno ]
                [ "OutFile" ],
                
                $this->TimeStamp("","-",":"),
                "tex"
            );
    }

    
   
    //*
    //* Initializes print item.
    //*

    function MyMod_Handle_Prints_Init()
    {
        $this->BarDatas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->ItemData[ $data ][ "IsBarcode" ])
            {
                array_push($this->BarDatas,$data);
            }
        }
        
        foreach (array_keys($this->ItemHashes) as $id)
        {
            $this->MyMod_Handle_Print_Init($this->ItemHashes[$id]);
        }
    }
}

?>