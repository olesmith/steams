<?php


trait MyApp_SubModules
{
    //*
    //* Overrides SigaZ version.
    //*

    function MyApp_SubModules_File_Add($file)
    {
        $file=$this->MyApp_Setup_FileName($file);

        foreach ($this->ReadPHPArray($file) as $module => $module_def)
        {
            if
                (
                    isset($this->SubModulesVars[$module ])
                    &&
                    is_array($this->SubModulesVars[$module ])
                )
            {
                foreach ($module_def as $key => $value)
                {                    
                    $this->SubModulesVars[ $module ][ $key ]=$value;

                }
            }
            else
            {
                $this->SubModulesVars[ $module ]=$module_def;
            }
                    
            if (empty($this->SubModulesVars[ $module ][ "File" ]))
            {
                $this->SubModulesVars[ $module ][ "File" ]=array();
            }
                    
            array_push($this->SubModulesVars[ $module ][ "File" ],$file);
        }
    }

    
    //*
    //* Loads app modules (in $this->AppLoadModules).
    //*

    function MyApp_SubModules_Load()
    {        
        foreach ($this->AppLoadModules as $submodule)
        {
            $this->MyMod_SubModule_Load($submodule,FALSE,TRUE,FALSE);
        }
    }
}

?>