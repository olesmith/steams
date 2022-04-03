<?php

include_once("Import/Read.php");
include_once("Import/Titles.php");
include_once("Import/Cells.php");
include_once("Import/Rows.php");
include_once("Import/Table.php");
include_once("Import/Detect.php");
include_once("Import/Update.php");
include_once("Import/Show.php");


trait MyMod_Handle_Import
{
    use
        MyMod_Handle_Import_Read,
        MyMod_Handle_Import_Titles,
        MyMod_Handle_Import_Cells,
        MyMod_Handle_Import_Rows,
        MyMod_Handle_Import_Table,
        MyMod_Handle_Import_Detect,
        MyMod_Handle_Import_Update,
        MyMod_Handle_Import_Show;
    
    var $Import_Datas=array();
    
    //*
    //* function MyMod_Handle_Import, Parameter list: 
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import()
    {
        if ($this->CGI_GETint("Sample")==1)
        {
            $this->MyMod_Handle_Import_Sample();
            exit();
        }

        if ($this->CGI_POSTint("Receit")==1)
        {
            $this->MyMod_Handle_Import_Receit();
            exit();
        }

        
        $this->Htmls_Echo
        (
            array
            (
                $this->H(1,"Import Inscriptions from Text File"),
                $this->MyMod_Handle_Import_Form(),
            )
        );

        if ($this->CGI_POSTint("Detect")==1 || $this->CGI_POSTint("Save")==1)
        {
            $this->Htmls_Echo
            (
                $this->MyMod_Handle_Import_Items_Show()
            );
            
        }
    }

    
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import_Form()
    {
        return
            $this->Htmls_Form
            (
                1,
                $this->ModuleName."_Import",
                "",

                //$contents=
                array
                (
                    $this->Htmls_Table
                    (
                        "",
                        array
                        (
                            $this->MyMod_Handle_Import_Datas_Row(),
                            $this->MyMod_Handle_Import_Sample_File_Row(),
                            array
                            (
                                $this->B
                                (
                                    $this->MyLanguage_GetMessage("Select").
                                    " ".
                                    $this->MyLanguage_GetMessage("File").
                                    ":"
                                ),
                                $this->Htmls_Input
                                (
                                    "file",
                                    "File",
                                    "",
                                    $options=array()
                                )
                            ),
                        )
                    )
                ),

                //$args=
                array
                (
                    "Hiddens" => array
                    (
                        "Detect" => 1,
                    ),
                    "Buttons" => $this->Button("submit","GO"),
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Import_Sample_File_Row()
    {
        $uri=$this->CGI_URI2Hash();
        $uri[ "Sample" ]=1;
        $uri[ "RAW" ]=1;
        $uri[ "NoHTML" ]=1;
        $uri[ "NoHorMenu" ]=1;
        $uri[ "NoHeads" ]=1;
        $uri[ "Menu" ]=0;
        
        return
            array
            (
                "",
                $this->Htmls_Href
                (
                    "?".
                    $this->CGI_Hash2URI($uri),
                    $this->MyLanguage_GetMessage("Import_Sample_File"),
                    "",
                    "",
                    array(),
                    array
                    (
                        "TARGET" => "_blank",
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Import_Datas_Row()
    {
        $names=array();
        foreach ($this->Import_Datas as $data)
        {
            array_push
            (
                $names,
                $this->MyMod_Data_Title($data,$nohtml=True)
            );
        }
        return
            array
            (
                $this->B
                (
                    $this->MyLanguage_GetMessage("Data")
                ),
                $this->MyMod_Handle_Import_Datas_Cell()
            );
    }

    
    //*
    //* 
    //*

    function MyMod_Handle_Import_Datas_Cell()
    {
        return
            join
            (
                ", ",
                $this->MyMod_Handle_Import_Data_Names()
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Import_Data_Names()
    {
        $names=array();
        foreach ($this->Import_Datas as $data)
        {
            array_push
            (
                $names,
                $this->MyMod_Data_Title($data,$nohtml=True)
            );
        }
        
        return $names;
    }

    
    //*
    //* 
    //*

    function MyMod_Handle_Import_Data_Empties()
    {
        $empties=array();
        for ($n=1;$n<=5;$n++)
        {
            $empty=array($n);
            foreach ($this->Import_Datas as $data)
            {
                array_push
                (
                    $empty,
                    ""
                );
            }

            array_push($empties,join(";",$empty));
                
        }
        
        return join("\n",$empties);
    }

    
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import_Sample()
    {
        $names=$this->MyMod_Handle_Import_Data_Names();

        $empties=array();
        foreach ($names as $name) { array_push($empties,""); }

        $this->MyMod_Doc_Header_Send("csv",$this->ModuleName.".csv");
        
        echo
            "#".join(";",$names)."\n".
            "#Do NOT insert or remove columns below\n".
            "#\n".

            $this->MyMod_Handle_Import_Data_Empties().
            "";
    }

    
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import_Receit()
    {
        $items=
            $this->MyMod_Handle_Import_Read_Items_From_CGI();
        
        $names=$this->MyMod_Handle_Import_Data_Names();

        $lines=
            array
            (
                "#".join(";",$names),
                "#Do not insert or remove columns below",
                "#"
            );


        foreach ($items as $item)
        {
            $row=$this->MyMod_Handle_Import_Item_Row($item);
            array_pop($row);
            
            array_push($lines,join(";",$row));
            
        }
        
        $this->MyMod_Doc_Header_Send("csv",$this->ModuleName.".csv");
        
        echo
            join("\n",$lines).
            "\n";
    }
}
?>