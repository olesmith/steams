<?php

trait MyMod_Handle_Edit_Table
{
    //*
    //* Cretaes table of sgroups table.
    //*

    function MyMod_Handle_Edit_Table($edit,$item,$datas,$extrarows)
    {
        $tbl=array();
        if ($this->SinglePrintables)
        {
            array_push($tbl,$this->GenerateLatexHorMenu());
        }


        if (count($datas)>0)
        {
            //$tbl=$this->MyMod_Item_Table_PreKey($edit,$item,FALSE,$datas);
            $tbl=$this->MyMod_Item_Table($edit,$item,$datas);
        }
        else
        {
            var_dump
            (
                "MyMod_Handle_Edit_Table!!!!",
                $datas,
                $this->MyMod_Handle_Show_SGroup_CGI()
            );
        }
        

        return 
            $this->Htmls_Table
            (
               "",
               array_merge($tbl,$extrarows),
               array
               (
                   //"WIDTH" => "50%",
                   "CLASS" => 'sgroupstable borderless-table',
               ),
               array(),
               array
               (
                   "WIDTH" => '50%',
                   "CLASS" => 'sgroupstabledata'
               )
            );

    }
}

?>