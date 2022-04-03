<?php

trait MyMod_Group_Menu_Entries
{
    //*
    //* Generates menu entry cells.
    //*

    function MyMod_Groups_Menu_Entries($item,$cellid,$singular=True)
    {
        $items=array();

        $groups=array();
        if ($singular) { $groups=$this->ItemDataSGroups; }
        else           { $groups=$this->ItemDataGroups; }
        
        foreach ($groups as $group => $groupdef)
        {
            if (!isset($groupdef[ "Visible" ]))
            {
                $groupdef[ "Visible" ]=True;
            }
            
            if
                (
                    !$groupdef[ "Visible" ]
                    ||
                    !$this->MyMod_Group_Allowed($groupdef,$item)
                )
            {
                continue;
            }
                        
            $items[ $group ]=
                $this->MyMod_Groups_Menu_Entry
                (
                    $item,$cellid,$group
                );
        }

        return $items;
    }
}
?>