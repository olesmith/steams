<?php

trait MyMod_Group_Menu_Destinations
{
    //*
    //* Generate group destinations.
    //*

    function MyMod_Groups_Menu_Destinations($item,$cellid,$singular=True)
    {
        $destinations=array();

        $groups=array();
        if ($singular) { $groups=$this->ItemDataSGroups; }
        else           { $groups=$this->ItemDataGroups; }
        
        foreach ($groups as $group => $groupdef)
        {
            if (!$this->MyMod_Group_Allowed($groupdef,$item))
            {
                continue;
            }
            
            $destinations[ $group ]=
                $this->MyMod_Groups_Menu_Destination
                (
                    $item,$cellid,
                    $group,$singular
                );
        }

        return $destinations;
    }
}

?>