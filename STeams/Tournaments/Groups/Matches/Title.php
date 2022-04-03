<?php

trait Tournament_Groups_Matches_Title
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Title($group)
    {
        return
            $this->Htmls_H
            (
                1,
                array
                (
                    $this->Tournament_GroupsObj()->MyMod_ItemName(),
                    $group[ "Name" ]
                )
            );
    }

    
    //*
    //* 
    //*

    function Tournament_Group_Matches_Title_TD($group,$html="")
    {
        return
            array
            (
                "Text" => $html,
                "Options" => $this->Tournament_Group_Matches_Options
                (
                    $group
                )
            );
        
    }

    
    //*
    //*
    //*

    function Tournament_Group_Matches_Team_Icon($group,$team,$n,$classes)
    {
        $key="Title_".$this->MyLanguage_Get();

        $rteam=
            $this->__Teams__[ $team[ "Team" ] ];
        
       return
            array
            (
                "Text" => 
                $this->Htmls_Center
                (
                    $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                    (
                        $rteam,"Icon"
                    )
                ),
                "Options" => $this->Tournament_Group_Matches_Options
                (
                    $group,$n,
                    array
                    (
                        "TITLE" => $rteam[ $key ],
                        "CLASS" =>$classes,
                    )
                )
            );
    }

    //*
    //*
    //*

    function Tournament_Group_Matches_Team_Initials($group,$team,$n,$options=array())
    {
        $init_key="Initials_".$this->MyLanguage_Get();
        $key="Title_".$this->MyLanguage_Get();

        $rteam=
            $this->__Teams__[ $team[ "Team" ] ];
        
        return
            array
            (
                "Text" =>
                $this->TeamsObj()->MyMod_Data_Fields_Show
                (
                    $init_key,
                    $rteam,
                    $plural=FALSE,$iconify=TRUE,$callmethod=TRUE,
                    //$options=
                    array
                    (
                        "STYLE" => array
                        (
                            "font-weigth" => 'bold',
                            "font-size" => '15px',
                            "text-decoration" => 'italic',
                        )
                    )
                ),
                "Options" => $this->Tournament_Group_Matches_Options
                (
                    $group,$n,
                    array_merge
                    (
                        array
                        (
                            "TITLE" => $rteam[ $key ]
                        ),
                        $options
                    )
                ),
            );
    }

}

?>