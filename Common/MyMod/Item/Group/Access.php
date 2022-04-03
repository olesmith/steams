<?php


trait MyMod_Item_Group_Access
{
    var $Group_Permissions_DB=True;
    
    //*
    //* function MyMod_Group_Permissions_Get, Parameter list: $data
    //*
    //* Generates data field.
    //*

    function MyMod_Group_Permissions_Get($group,$singular=True)
    {
        $perms=array();
        if ($this->Group_Permissions_DB)
        {
            $method="ItemDataGroups";
            $type=$this->LanguagesObj()->Language_Group_Type;
            
            if ($singular)
            {
                $type=$this->LanguagesObj()->Language_SGroup_Type;
                $method="ItemDataSGroups";
            }
            
            $perms=
                $this->LanguagesObj()->Permissions_Get
                (
                    $type,
                    $group,
                    $this->$method($group),
                    $this->ModuleName
                );
        }

        return $perms;
    }

    
    //*
    //* Detects if we should edit at least one in $groupdefs.
    //*

    function MyMod_Item_SGroups_Edit_Should($groupdefs)
    {
        foreach ($groupdefs as $groupdef)
        {
            foreach ($groupdef as $group => $edit)
            {
                if ($edit) { return TRUE; }
            }
        }

        return FALSE;
    }
}

?>