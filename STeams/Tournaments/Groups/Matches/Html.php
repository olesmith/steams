<?php

trait Tournament_Groups_Matches_Html
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Html($edit,$group)
    {
        $teams=
            $this->Tournament_Group_Teams_Read($group);

        $teams_ids=
            $this->MyHash_HashesList_Values($teams,"Team");

        $this->__Teams__=
            $this->TeamsObj()->Sql_Select_Hashes_ByID
            (
                array("ID" => $teams_ids)
            );
        
        $matches=
            $this->Tournament_Group_Matches_Read($group);
        
        return
            array
            (
                $this->Htmls_Table
                (
                    $this->Tournament_Group_Matches_Titles
                    (
                        $group,
                        $teams
                    ),
                    $this->Tournament_Group_Matches_Table
                    (
                        $edit,$group,
                        $teams,
                        $matches
                    )
                )
            );
    }
}

?>