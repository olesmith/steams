<?php



trait MyMod_Data_Files
{
    var $DataFilesMTime=0;
    
    //*
    //* function MyMod_Data_Paths, Parameter list: 
    //*
    //* Returns paths to use when looking form group files.
    //*

    function MyMod_Data_File_Path()
    {
        return
            preg_replace
            (
                '/\.php$/',"",
                $this->ApplicationObj()->SubModulesVars
                [ $this->ModuleName ][ "SqlFile" ]
            );        
    }

    //*
    //* function MyMod_Data_Paths, Parameter list: 
    //*
    //* Returns paths to use when looking form group files.
    //*

    function MyMod_Data_Paths()
    {
        if ($this->ModuleName()=="Application") { return array(); }
        
        $hash=array
        (
           "Module" => $this->MyMod_Data_File_Path(),
           "System" => $this->MyMod_Setup_Path(),
        );
        
        foreach (array_keys($this->ItemDataPaths) as $id)
        {
            $this->ItemDataPaths[ $id ]=
                $this->Filter($this->ItemDataPaths[ $id ],$hash);
        }

        return $this->ItemDataPaths;
    }

    //*
    //* function MyMod_Data_Files, Parameter list: 
    //*
    //* Returns files with item data.
    //*

    function MyMod_Data_Files()
    {
        if ($this->ModuleName()=="Application") { return array(); }
        
        $hash=array
        (
           "Module" => $this->MyMod_Data_File_Path(),
           "System" => $this->MyMod_Setup_Path(),
        );
        
        if (!isset($this->ItemDataFiles)) { $this->ItemDataFiles=array(); }
        
        foreach (array_keys($this->ItemDataFiles) as $id)
        {
            $this->ItemDataFiles[ $id ]=$this->Filter($this->ItemDataFiles[ $id ],$hash);
        }

        return $this->ItemDataFiles;
    }


     //*
    //* function MyMod_Data_Files_Get, Parameter list:
    //*
    //* Returns item  data files expanding over paths and files.
    //*

    function MyMod_Data_Files_Get($debug=False)
    {
        $files=$this->MyFile_Paths_Existent
        (
           $this->MyMod_Data_Paths(),
           $this->MyMod_Data_Files(),
           $debug
        );

        foreach ($files as $file)
        {
            $this->DataFilesMTime=
                $this->Max(filemtime($file),$this->DataFilesMTime);
        }

        return $files;
    }
    
    //*
    //* function MyMod_Data_Files_MTime, Parameter list:
    //*
    //* Returns item  data files last modiication stamp..
    //*

    function MyMod_Data_Files_MTime()
    {
        if (empty($this->DataFilesMTime))
        {
            $this->MyMod_Data_Files_Get();
        }

        return $this->DataFilesMTime;
    }
    
    //*
    //* function MyMod_Data_Files_MTime_Get, Parameter list:
    //*
    //* Returns $this->DataFilesMTime - if this is 0, updates.
    //*

    function MyMod_Data_Files_MTime_Get()
    {
        if ($this->DataFilesMTime==0)
        {
            $this->MyMod_Data_Files_Get();
        }

        return $this->DataFilesMTime;
    }
}

?>