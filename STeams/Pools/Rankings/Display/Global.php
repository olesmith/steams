<?php

trait Pool_Rankings_Display_Global
{
    //*
    //* 
    //*

    function Pool_Rankings_Display_Global_Table($pool)
    {
        return
            $this->MyMod_Items_Dynamic_Table
            (
                0,
                $this->Pool_Rankings_Display_Read
                (
                    $pool
                ),
                $group="Basic"
            );
    }
}

?>