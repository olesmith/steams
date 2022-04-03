<?php


trait MyMod_Handle_Import_Show
{
    //*
    //* Shows the detected info.
    //*

    function MyMod_Handle_Import_Items_Show()
    {
        $file="";
        if (!empty($_FILES[ "File" ]))
        {
            $file=$_FILES[ "File" ][ "name" ];
        }
        elseif (!empty($_POST[ "FileName" ]))
        {
            $file=$this->CGI_POST("FileName");
        }

        $url=$this->CGI_URI2Hash();
        $url[ "PDF" ]=1;
        
        return
            $this->Htmls_Form
            (
                1,
                $this->ModuleName."_Entries",
                "",

                //$contents=
                array
                (
                    $this->H(2,"Entries in File: ".$file),
                    $this->Htmls_Table
                    (
                        $this->MyMod_Handle_Import_Titles(),
                        $this->MyMod_Handle_Import_Table()
                    ),
                ),

                //$args=
                array
                (
                    "Hiddens" => array
                    (
                        "FileName" => $file,
                        "Save"     => 1,
                        "Receit"     => " ",
                    ),
                    "Buttons" => array
                    (
                        $this->Htmls_Buttons()
                    ),
                )
            );
    }    
}
?>