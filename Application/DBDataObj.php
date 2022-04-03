<?php

include_once("DBDataObj/Datas.php");
include_once("DBDataObj/Groups.php");
    

class DBDataObj extends Table
{
    use
        DBDataObj_Datas,
        DBDataObj_Groups;
    
    var $DatasData=array();
    var $DatasGroups=array();
    

    //*
    //* Tests if user has coordenator edit access to module.
    //*

    function Module_Profile_User_Edit_May($user=array(),$profile="Coordinator")
    {
        if (empty($user))    { $user=$this->LoginData(); }
        if (empty($profile)) { $profile=$this->Profile(); }
        
        return
            $this->PermissionsObj()->Permissions_User_Coordinator_Type_Is
            (
                $user,
                $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ $profile."_Types" ]
            );
    }

    //*
    //* Tests if user may coordinator edit in module.
    //*

    function Module_Profile_Current_User_Edit_May($user=array(),$profile="Coordinator")
    {
        return $this->Module_Profile_User_Edit_May($user,$profile);
    }


    //*
    //* Returns the coordinator groups/types. Used for all
    //* access checking.
    //*

    function Module_Profile_Module_2_Types($profile,$key="Types")
    {
        return
            $this->ApplicationObj()->SubModulesVars
            [ $this->ModuleName ]
            [ $profile."_".$key ];
    }
    
    //*
    //* Returns the profile groups/types. Used for all
    //* access checking.
    //*

    function Module_Profile_Module_2_Edit_Types($profile="Coordinator",$key="Types")
    {
        return $this->EventMod_Coordinator_Module_2_Types($profile,$key);
    }    
}

?>