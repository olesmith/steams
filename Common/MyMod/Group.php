<?php

include_once("Group/Allowed.php");
include_once("Group/Datas.php");
include_once("Group/Cells.php");
include_once("Group/Titles.php");
include_once("Group/Row.php");
include_once("Group/Rows.php");
include_once("Group/Table.php");
include_once("Group/SumVars.php");
include_once("Group/Html.php");
include_once("Group/Form.php");
include_once("Group/Add.php");
include_once("Group/Menu.php");

trait MyMod_Group
{
    use
        MyMod_Group_Allowed,
        MyMod_Group_Datas,
        MyMod_Group_Cells,
        MyMod_Group_Titles,
        MyMod_Group_Row,
        MyMod_Group_Rows,
        MyMod_Group_Table,
        MyMod_Group_SumVars,
        MyMod_Group_Html,
        MyMod_Group_Form,
        MyMod_Group_Add,
        MyMod_Group_Menu;
    
    //*
    //* SGroup titles won't get right, unless they are COLSPAN>=2!?
    //* Create $title in such one such rows. Do also an Htmls_H($h).
    //*

    function MyMod_SGroup_Title_Rows($title,$h=3)
    {
        return
            array
            (
                array
                (
                    array
                    (
                        "Cell" => array
                        (
                            $this->Htmls_H($h,$title)
                                
                        ),
                        "Options" => array
                        (
                            "COLSPAN" => 2,
                        )
                    ),
                ),
            );
    }
}

?>