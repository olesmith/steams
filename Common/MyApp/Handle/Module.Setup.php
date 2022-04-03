<?php

trait MyApp_Handle_ModuleSetup
{
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_ModuleSetup0000()
    {
        $this->MyApp_Interface_Head();

        $dbhash=$this->DBHash();
        
        $formtable="";
        if (isset($dbhash[ "Mod" ]) && !empty($dbhash[ "Mod" ]))
        {
            $formtable=
                $this->StartForm().
                $this->H
                (
                   5,
                   "Transferir Módulos: ".
                   $this->MakeCheckBox("TransferModule").
                   $this->Button("submit","Transferir")
                ).
                $this->EndForm();
            
            $formtable.=
                $this->StartForm().
                $this->H
                (
                   5,
                   "Transferir Sistema: ".
                   $this->MakeCheckBox("Transfer").
                   $this->Button("submit","Transferir")
                ).
                $this->EndForm();
        }
        
        if ($this->CGI_POST("TransferModule")=='on')
        {
            $this->TransferModuleProfiles();
        }

        if ($this->CGI_POST("Transfer")=='on')
        {
            $this->TransferProfiles();
        }

        echo
            $this->H(2,"Permissions and Profiles").
            $this->HtmlTable
            (
               "",
               array
               (
                  array($formtable)
               )
            );
    }

    //*
    //* Transfers profiles for all handlers.
    //*

    function TransferModuleProfiles()
    {
        foreach (array_keys($this->ModuleDependencies) as $module)
        {
            $class=$this->ApplicationClass;

            $mhash=array
            (
                  "ReadOnly"        => $this->ReadOnly,
                  "DBHash"          => $this->DBHash,
                  "LoginType"       => $this->LoginType,
                  "LoginData"       => $this->LoginData,
                  "LoginID"         => $this->LoginID,
                  "AuthHash"        => $this->AuthHash,
                  "ModuleName"      => $module,
                  "SqlTable"        => $this->SqlTable,
                  "SqlTableVars"    => $this->SqlTableVars,
                  "DefaultAction"   => $this->DefaultAction,
                  "DefaultProfile"  => $this->DefaultProfile,
                  "Profile"         => $this->Profile,
                  "ModuleLevel"     => 1,
                  "CompanyHash"     => $this->CompanyHash,
                  "MailInfo"        => $this->ApplicationObj()->MyApp_Mail_Info_Get(),
                  "URL_CommonArgs"  => $this->URL_CommonArgs,
                  "MySqlActions"    => $this->MySqlActions,
                  "Handle"          => FALSE,
            );

            if (isset($this->Period))
            {
                $mhash[ "Period" ]=$this->Period;
            }

            $object=new $class ($mhash);
            $object->InitModule($module,array(),FALSE);

            $object->Module->TransferProfiles();
        }
    }

   //*
    //* Transfers profiles for all handlers.
    //*

    function TransferProfiles()
    {
        $moduleaccesses=array();
        foreach (array_keys($this->ModuleDependencies) as $module)
        {
            $access=$this->ReadPHPArray($this->MyMod_Setup_Profiles_File($module));

            $access=$access[ "Access" ];

            $moduleaccesses[ $module ]=array();
            foreach ($this->GetListOfProfiles() as $profile)
            {
                $moduleaccesses[ $module ][ $profile ]=$access[ $profile ];
            }
        }

        $dbhash=$this->DBHash();
        
        if (isset($dbhash[ "Mod" ]) && !empty($dbhash[ "Mod" ]))
        {
            $file=$this->MyMod_Setup_Profiles_File();
            $this->WritePHPArray($file,$moduleaccesses);

            print $this->H(4,"System Accesses written to ".$file);
        }
    }


}

?>