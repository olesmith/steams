<?php

trait MyMod_Items_Dynamic_Paging_Entries
{
    //*
    //* Dynamic items paging menu.
    //*

    function MyMod_Items_Dynamic_Paging_Entries()
    {
        $entries=array();
        for ($n=1;$n<=$this->MyMod_Paging_N;$n++)
        {
            array_push
            (
                $entries,
                $this->MyMod_Items_Dynamic_Paging_Entry($n)
            );
        }

        return $entries;
    }
}

?>