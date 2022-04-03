<?php


trait MyActions_Access
{
    var $Actions_Permissions_DB=True;
    
    
    //*
    //* function MyAction_Allowed, Parameter list: $action,$item=array()
    //*
    //*

    function MyAction_Allowed($action,$item=array(),$debug=False)
    {
        $perms=$this->MyAction_Allowed_Permissions_Get($action);

        
        $res=FALSE;
        if
            (
                $this->MyMod_Access_Has()
                &&
                !empty($perms)
            )
        {
            $actiondef=$this->Actions($action);
            
            $res=$this->MyMod_Access_HashAccess($perms,array(1,2));

            if ($debug) { var_dump($action,$res); }
            if ($res && !empty($actiondef[ "AccessMethod" ]))
            {
                $perms[ "AccessMethod" ]=$actiondef[ "AccessMethod" ];
                $res=$this->MyAction_Access_Method_Apply($action,$perms,$item);
                
                if ($debug) { var_dump($perms[ "AccessMethod" ],$res); }
            }
        }
        
        if ($debug) { var_dump($action,$res); }
        return $res;
    }

    
    //*
    //*
    //*

    function MyAction_Allowed_Permissions_Get($action)
    {
        $perms=array();
        if ($this->Actions_Permissions_DB)
        {
            $perms=
                $this->LanguagesObj()->Permissions_Get
                (
                    $this->LanguagesObj()->Language_Action_Type,
                    $action,
                    $this->Actions($action),
                    $this->ModuleName
                );
        }
        
        return $perms;
    }
    
    //*
    //* function MyAction_AccessMethod, Parameter list: $action
    //*
    //*

    function MyAction_AccessMethod($action)
    {
        return $this->Actions($action,"AccessMethod");
    }
    //*
    //* function MyAction_Access_Method_Apply, Parameter list: $action
    //*
    //* Checks if we have  module access - returns TRUE/FALSE.
    //* Uses $profiledef[ $module ][ "Access" ] to assess if allowed.
    //* If $module is empty or not given, uses $this->ModuleName as module.
    //*

    function MyAction_Access_Method_Apply($action,$actiondef,$item)
    {
        return $this->MyHash_Access_Method_Apply($action,$actiondef,$item);
    }

    //*
    //* function MyAction_Access_Has, Parameter list: $action
    //*
    //* Checks if we have  module access - returns TRUE/FALSE.
    //* Uses $profiledef[ $module ][ "Access" ] to assess if allowed.
    //* If $module is empty or not given, uses $this->ModuleName as module.
    //*

    function MyAction_Access_Has($action)
    {
        return $this->MyAction_Allowed($action);
    }

    //*
    //* function MyAction_Action_Require, Parameter list: $action
    //*
    //* Requires module access - exits if not.
    //*

    function MyAction_Access_Require($action)
    {
        if ($this->MyAction_Access_Has($action))
        {
            return TRUE;
        }

        $this->MyAction_Error
        (
           "No ".$this->Profile()." access to Action ".$this->ModuleName."#".$action,
           $this->MyAction_Allowed_Permissions_Get($action)
        );
    }
}
?>