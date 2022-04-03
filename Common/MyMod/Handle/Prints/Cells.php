<?php

trait MyMod_Handle_Prints_Cells
{    
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Cell($type,$docno,$doc)
    {
        $title=$doc[ "Name" ];
        if (!empty($doc[ "Title" ]))
        {
            $title=$doc[ "Title" ];
        }
        return
            $this->Htmls_HRef
            (
                $this->MyMod_Handle_Print_URL($type,$docno,$doc),
                $doc[ "Name" ],

                $title,$class="",$args=array(),
                //$options=
                array
                (
                    "TARGET" => '_blank',
                )
            );
    }

    
    //*
    //* 
    //*

    function MyMod_Handle_Print_URL($type,$docno,$doc)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                array_merge
                (
                    $this->CGI_URI2Hash(),
                    array
                    (
                        "Action" => $this->MyMod_Handle_Print_Action
                        (
                            $type,$docno,$doc
                        ),
                        "Print" => 1,
                        $this->MyMod_Latex_CGI_DocNo => $docno,
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Print_Action($type,$docno,$doc)
    {
        $action="Prints";
        if ($type=="SingularLatexDocs" || $this->Singular)
        {
            $action="Print";
        }
        
        return $action;
    }
 }

?>