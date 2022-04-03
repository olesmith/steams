<?php


trait MyActions_Files
{
    //*
    //* function MyActions_Paths, Parameter list: 
    //*
    //* Returns paths to use when looking form group files.
    //*

    function MyActions_Paths()
    {
        $paths=$this->ActionPaths;

        if (!$this->IsMain())
        {
            array_push($paths,$this->MyMod_Setup_Path());
        }

        $base=dirname($this->ApplicationObj()->MyApp_Setup_Path());

        foreach (array_keys($paths) as $pid)
        {
            if (!preg_match('/^\//',$paths[ $pid ]))
            {
                $paths[ $pid ]=$base."/".$paths[ $pid ];
            }
        }

        return $this->MyMod_Setup_Parse($paths);
    }

    //*
    //* function MyActions_Files, Parameter list: 
    //*
    //* Returns contents of $this->ActionFiles.
    //*

    function MyActions_Files()
    {
        return $this->MyMod_Setup_Parse($this->ActionFiles);
    }

    //*
    //* function MyActions_GetFiles, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyActions_GetFiles()
    {
        return $this->MyFile_Paths_Existent
        (
           $this->MyActions_Paths(),
           $this->MyActions_Files()
        );
    }
}

?>