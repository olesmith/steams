<?php

trait Tournament_Matches_Group_Rows
{
    //*
    //* 
    //*

    function Tournament_Matches_Group_Rows($team1_n,$edit,$tournament,$group_id,$group,$teams,$matches,$team_id)
    {
        return
           array
           (
               array
               (
                   "Row" => 
                   $this->Tournament_Matches_Group_Row
                   (
                       $team1_n,$edit,$tournament,$group_id,$group,$teams,$matches,$team_id
                   ),
                   /* "Options" => array */
                   /* ( */
                   /*     "ONMOUSEOVER" => "Highlight_TR(this,'white');", */
                   /*     "ONMOUSEOUT" =>  "Highlight_TR(this);", */
                   /* ), */
               )
           );
    }
    
    //*
    //* 
    //*

    function Tournament_Matches_Group_Row($team1_n,$edit,$tournament,$group_id,$group,$teams,$matches,$team_id1)
    {
        $key="Name_".$this->MyLanguage_Get();
        
        $matches=
            $this->MyHash_HashesList_2ID
            (
                $matches,
                "Team2"
            );
        
        $row=
           array
           (
               $this->Tournament_Matches_Group_Initials_Team
               (
                   $tournament,
                   $teams[ $team_id1 ],
                   0,
                   array
                   (
                       "CLASS" => $this->Tournament_Match_Classes_Group_Teams
                       (
                           $tournament,$group,$team1_n,0
                       )
                   )
               ),
               $this->Tournament_Matches_Group_Icon_Team
               (
                   $tournament,
                   $teams[ $team_id1 ],
                   0,
                   $this->Tournament_Match_Classes_Group_Teams
                   (
                       $tournament,$group,$team1_n,0
                   )
               ),               
           );



        $team2_n=0;
        foreach ($tournament[ "Groups" ][ $group_id ] as $team_id2)
        {
            $team2_n++;
            $rmatch=array();
            if (!empty($matches[ $team_id2 ]))
            {
                $rmatch=$matches[ $team_id2 ];
            }

            array_push
            (
                $row,
                array
                (
                    "Text" => 
                    $this->Tournament_Matches_Group_Cells
                    (
                        $team1_n,$team2_n,$edit,$tournament,
                        $group,$teams,
                        $rmatch
                    ),
                    "Options" => $this->Tournament_Match_TD_Options
                    (
                        $team1_n,$team2_n,
                        $edit,$tournament,$rmatch,$group
                    ),
                )
            );
        }

        return $row;
        
    }
}

?>
