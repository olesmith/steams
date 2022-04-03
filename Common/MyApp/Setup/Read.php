<?php


trait MyApp_Setup_Read
{
    //Change these lists for 'derived' apps.
    var $MyApp_Setup_Files_Html=array("Html.php");
    var $MyApp_Setup_Files_Company=array("Company.php");
    
    //*
    //* Reads SubModules setup: does nothing, supposed to be overwritten.
    //*

    function MyApp_SubModules_Read()
    {
    }
    
    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_FileName($file)
    {
        return $this->MyApp_Setup_Path()."/".$file;
    }

    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_LoadFile($file,$destination)
    {
        $this->$destination=
            $this->ReadPHPArray
            (
                $this->MyApp_Setup_FileName($file)
            );
    }

    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_LoadFiles($files,$destination)
    {
        $this->$destination=array();
        foreach ($files as $file)
        {
            $this->$destination=
                array_merge
                (
                    $this->$destination,
                    $this->ReadPHPArray
                    (
                        $this->MyApp_Setup_FileName($file)
                    )
                );
        }
    }

    //*
    //* Returns App global data file name.
    //*

    function MyApp_Setup_Globals_File()
    {
        return $this->MyApp_Setup_FileName("Globals.php");
    }

    //*
    //* Returns App global data file name.
    //*

    function MyApp_Setup_Globals_Read()
    {
        return $this->ReadPHPArray
        (
           $this->MyApp_Setup_Globals_File()
        );
    }

    //*
    //* Loads App global data file name.
    //*

    function MyApp_Setup_Globals_Load()
    {
        $hash=$this->MyApp_Setup_Globals_Read();
        $this->MyHash_Args2Object($hash);
    }

    
    
    //*
    //* Read setup.
    //*

    function MyApp_Setup_Read()
    {
        $this->MyApp_Setup_Globals_Load();

        $this->MyApp_Setup_LoadFiles
        (
            $this->MyApp_Setup_Files_Html,
            "HtmlSetupHash"
        );
        
        $this->MyApp_Setup_LoadFiles
        (
            $this->MyApp_Setup_Files_Company,
            "CompanyHash"
        );
    }
}

?>