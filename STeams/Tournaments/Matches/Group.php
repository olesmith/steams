<?php

/* include_once("Group/Cells.php"); */
/* include_once("Group/Title.php"); */
/* include_once("Group/Titles.php"); */
/* include_once("Group/Rows.php"); */
/* include_once("Group/Table.php"); */

trait Tournament_Matches_Group
{
    /* use */
    /*     Tournament_Matches_Group_Cells, */
    /*     Tournament_Matches_Group_Title, */
    /*     Tournament_Matches_Group_Titles, */
    /*     Tournament_Matches_Group_Rows, */
    /*     Tournament_Matches_Group_Table; */
    //*
    //* 
    //*

    function Tournament_Matches_Groups_Tables($edit,$tournament,$groups,$teams,$matches)
    {
        $table=array();
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Tournament_Matches_Group_Table
                    (
                        $edit,$tournament,$group_id,
                        $groups[ $group_id ],
                        $this->__Teams__[ $group_id ],
                        $matches[ $group_id ]
                    )
                );
        }

        return $table;
    }
}

?>
