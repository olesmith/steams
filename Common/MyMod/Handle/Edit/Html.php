<?php

trait MyMod_Handle_Edit_Html
{
    //*
    //* Cretaes table of sgroups table as listed html.
    //*

    function MyMod_Handle_Edit_Htmls($title,$edit,$item,$datas,$extrarows)
    {
        if (!is_array($title))
        {
            $title=$this->H(1,$title);
        }

        
        return
            array
            (
                $title,
                $this->MyMod_Handle_Edit_Info_Table($item),
                $this->MyMod_Handle_Edit_Table($edit,$item,$datas,$extrarows),
             );
    }
}

?>