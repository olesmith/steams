<?php

trait Tournament_Groups_Matches_Rows
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Rows($team1_n,$edit,$group,$teams,$rmatches,$team)
    {
        return
           array
           (
               array
               (
                   "Row" => 
                   $this->Tournament_Group_Matches_Row
                   (
                       $team1_n,$edit,$group,$teams,$rmatches,$team
                   ),
                   /* "Options" => array */
                   /* ( */
                   /*     "ONMOUSEOVER" => "Highlight_TR(this,'white');", */
                   /*     "ONMOUSEOUT" =>  "Highlight_TR(this);", */
                   /* ), */
               )
           );
    }
}

?>