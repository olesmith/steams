<?php

include_once("Group/Access.php");
include_once("Group/Data.php");
include_once("Group/CGI.php");
include_once("Group/Table.php");
include_once("Group/Tables.php");
include_once("Group/Update.php");
include_once("Group/Html.php");
include_once("Group/Latex.php");
include_once("Group/Form.php");

trait MyMod_Item_Group
{
    var $SGroups_NumberItems=FALSE;
    
    use
        MyMod_Item_Group_Access,
        MyMod_Item_Group_Data,
        MyMod_Item_Group_CGI,
        MyMod_Item_Group_Table,
        MyMod_Item_Group_Tables,
        MyMod_Item_Group_Update,
        MyMod_Item_Group_Html,
        MyMod_Item_Group_Latex,
        MyMod_Item_Group_Form;

    
    //*
    //* Returns number loaded ItemDataSGroups. 
    //*

    function MyMod_Item_N_SGroups($edit,$groupsperrow=3)
    {
        $nsgroups=0;
        foreach ($this->MyMod_Item_SGroups($edit,$groupsperrow) as $groups)
        {
            $nsgroups+=count($groups);
        }

        return $nsgroups;
    }
    
    //*
    //* Returns loaded ItemDataSGroups. 
    //*

    function MyMod_Item_SGroups($edit,$groupsperrow=3)
    {
        $profile=$this->Profile();
        
        
        $sgroups=array();
        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (
                  !empty($this->ItemDataSGroups[ $group ][ $profile ])
                  &&
                  count($this->ItemDataSGroups[ $group ][ "Data" ])>0
               )
            {
                array_push($sgroups,$group);
            }
        }
        
        $groups=array();
        foreach ($this->PageArray($sgroups,$groupsperrow) as $row => $rgroups)
        {
            $groups[ $row ]=array();

            foreach ($rgroups as $group)
            {
                if (empty($this->ItemDataSGroups[ $group ][ "Visible" ])) { continue; }
                
                $redit=$edit;
                if ($this->MyMod_Group_Allowed($this->ItemDataSGroups[ $group ]))
                {
                    if ($edit==1) { $redit=$this->ItemDataSGroups[ $group ][ $profile ]-1; }

                    $groups[ $row ][ $group ]=$redit;
                }
            }
        }

        return $groups;
    }    
    
    //*
    //* Detects editable groups from $groupdefs.
    //*

    function MyMod_Item_Group_Defs2Groups($groupdefs)
    {
        $groups=array();
        foreach ($groupdefs as $groupdef)
        {
            if (!empty($groupdef[ '__Key__' ]))
            {

                array_push($groups,$groupdef[ '__Key__' ]);
            }
        }

        return $groups;
    }
    

}

?>