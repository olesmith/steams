<?php

trait MyMod_Group_Add
{
    //*
    //* Adds $groupdef to itemdata groups hash.
    //*

    function MyMod_Group_Add($group,$groupdef,$plural=TRUE)
    {
        $this->MyMod_Data_Group_Defaults_Take($groupdef);
        if ($plural)
        {
            $this->ItemDataGroups[ $group  ]=$groupdef;
        }
        else
        {
            $this->ItemDataSGroups[$group  ]=$groupdef;
        }
    }
}

?>