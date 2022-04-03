<?php

trait MyMod_Handle_Print
{
    var $BarDatas=array();
    
    //*
    //* function MyMod_Handle_Print, Parameter list: 
    //*
    //* Handles module one object Print.
    //*

    function MyMod_Handle_Print($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        $item=$this->MyMod_Item_Latex_Trim($item);

        if (empty($_GET[ "Print" ]))
        {
            $this->Htmls_Echo
            (
                $this->MyMod_Handle_Prints_Html("SingularLatexDocs",$item)
            );
            
            return;
        }

        $latexdocno=$this->CGI2LatexDocNo();

        $this->LatexData();
        if
            (
                !empty
                (
                    $this->LatexData
                    [ "SingularLatexDocs" ][ "Docs" ]
                    [ $latexdocno ][ "AltHandler" ]
                )
            )
        {
            $handler=
                $this->LatexData
                [ "SingularLatexDocs" ][ "Docs" ]
                [ $latexdocno ][ "AltHandler" ];
            
            $this->$handler();
            return;
        }

        if (method_exists($this,"InitPrint"))
        {
            $item=$this->InitPrint($item);
        }
        
        $this->MyMod_Item_Print($item);
    }
    
    //*
    //* function MyMod_Handle_Print_Init, Parameter list: &$item
    //*
    //* Initializes print item. May be overridden=, but should call this parent.
    //* 
    //*

    function MyMod_Handle_Print_Init(&$item)
    {
        if (method_exists($this,"InitPrint"))
        {
            $item=$this->InitPrint($item);
        }

        foreach ($this->BarDatas as $data)
        {
            $file=$this->BarCode_File($item);
            if (!file_exists($file))
            {
                $this->BarCode_Generate($item);
            }
            
            $item[ $data."_File" ]=$file;
        }
        
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Print_OutNames($item,$docno)
    {
        return
            array
            (
                $this->LatexData[ "SingularLatexDocs" ][ "Docs" ]
                [ $docno ]
                [ "OutFile" ],
                
                $this->TimeStamp("","-",":"),
                "tex"
            );
    }

}

?>