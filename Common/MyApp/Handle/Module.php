<?php

trait MyApp_Handle_Module
{    
    //*
    //* Returns $action detectable and accessible from CGI and Module defaults.
    //* False if nothing accessible.
    //*

    function MyApp_Handle_Module_Action_Allowed()
    {
        //Test Module access
        $res=$this->MyApp_Module_Access_Has($this->ModuleName);

        if (!$res) { return FALSE; }
        
        //Load module, if necessary
        if (!$this->Module)
        {
            $this->MyApp_Module_Load($this->ModuleName);
        }
        
        $action=$this->MyApp_Handle_Action_CGI();
        if ($this->Module)
        {
            $res=$this->Module->MyAction_Allowed($action);
        }

        if (!$res)
        {
            if (!empty($this->Module->Actions[ $action ][ "AltAction" ]))
            {
                $action=$this->Module->Actions[ $action ][ "AltAction" ];
                $res=$this->Module->MyAction_Allowed($action);
            }
        }

        if ($res) { return $action; }
        
        return False;
    }
        
    //*
    //* Tries to handle Application module, detecting action., 
    //*

    function MyApp_Handle_Module_Try()
    {
        $action=$this->MyApp_Handle_Module_Action_Allowed();
        
        if (!$action) { return FALSE; }

        return $this->MyApp_Handle_Module_Exec($action);
    }
 
    //*
    //* Tries to handle Application by a module, if allowed.
    //*

    function MyApp_Handle_Module_Exec($action)
    {
        $action=$this->MyApp_Handle_Module_Action_Allowed();
        
        if (!$action) { return FALSE; }
 
        //Handle module
        $this->ExecMTime=time();
        if ($this->Module)
        {
            $res=$this->Module->MyAction_Allowed($action);

            if (!$res) { return FALSE; }
        
            $this->Module->LoginType=$this->LoginType;

            $this->MyApp_Handle_Module_Cookies();
            $this->Module->MyMod_Handle();
        }

        $this->ExecMTime=time()-$this->ExecMTime;

        return TRUE;
    }

    
    //*
    //* Send cookies.
    //*

    function MyApp_Handle_Module_Cookies()
    {
        $cookies=array();
        if (isset($this->Module->CGIArgs))
        {
            $cookies=array_keys($this->Module->CGIArgs);
        }

        $this->Module->Handle=TRUE; //bug - SetCookieVars changes Handle??
        $this->Module->MyMod_Search_CGI_Vars_2_Cookies();
            
        $this->Module->MakeCGI_Cookies_Set
        (
            array_merge
            (
                $cookies,
                $this->ApplicationObj()->CookieVars
            )
        );
        
        #$this->MakeCGI_Cookies_Show();
    }
 
}

?>