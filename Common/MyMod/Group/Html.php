<?php

trait MyMod_Group_Html
{
     //*
    //* Returns Html version of Items table. Only in SiMON!!!
    //* 

    function MyMod_Group_Html($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    {
        $this->ItemData();
        $this->ItemDataGroups();
        $this->ItemDataSGroups();

        return
            array
            (
                $this->Htmls_Table
                (
                    $this->MyMod_Data_Titles($datas),
                    $this->MyMod_Group_Table_Rows
                    (
                        $title,
                        $edit,
                        $datas,
                        $items,
                        $countdef,
                        $titles,
                        $sumvars,
                        $cgiupdatevar
                    ),
                    array("CLASS"=> "teste1"), //????
                    array(),
                    array(),
                    TRUE,TRUE
                )
            );
    }

    
    //*
    //* Creates data group table, group $group.
    //* If $group=="", calls MyMod_Data_Group_Actual_Get to detect it.
    //* $title, $edit and $items are transferred calling ItemTable.
    //*

    function MyMod_Group_Html_Table($title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar="Update",$emptyhtml=array(),$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=False,$hover=False,$nosorticons=False)
    {
        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Data_Group_Table
                (
                    $title,
                    $edit,
                    $group,
                    $items,
                    $titles,
                    $cgiupdatevar,
                    $nosorticons
                ),
                $options,$troptions,$tdoptions,
                $evenodd,$hover
            );
    }
}

?>