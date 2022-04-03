<?php

trait Tournament_Matches_Group_Title
{
    //*
    //* 
    //*

    function Tournament_Matches_Group_Title($tournament,$group)
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

    function Tournament_Matches_Group_Text($tournament,$html="")
    {
        return
            array
            (
                "Text" => $html,
                "Options" => $this->Tournament_Matches_Group_Options
                (
                    $tournament
                )
            );
        
    }
    
    //*
    //* 
    //*

    function Tournament_Matches_Group_Options($tournament,$n=0,$options=array(),$max=4)
    {
        if (empty($options[ "STYLE" ])) { $options[ "STYLE" ]=array(); }
        
        return
            array_merge
            (
                $options,
                array
                (
                    "STYLE" =>
                    array_merge
                    (
                        $options[ "STYLE" ],
                        $this->Tournament_Matches_Group_Style
                        (
                            $tournament,$n,$max
                        )
                    ),
                )
            );
    }
        
    //*
    //* 
    //*

    function Tournament_Matches_Group_Opacity($tournament,$n=0,$max=4)
    {
        $n=$n % $max;
        return
           1-(1.0*$n)/(2.0*$max);
    }
    //*
    //* 
    //*

    function Tournament_Matches_Group_Style($tournament,$n=0,$max=4)
    {
       return
           array
           (
               "background-color" => '#3399ff',
               "opacity"          =>
               $this->Tournament_Matches_Group_Opacity
               (
                   $tournament,$n,$max
               ),
           );
    }
    
    //*
    //* 
    //*

    function Tournament_Matches_Group_Icon_Team($tournament,$team,$team2_n,$classes)
    {
        $key="Title_".$this->MyLanguage_Get();

        return
            array
            (
                "Text" => 
                $this->Htmls_Center
                (
                    $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                    (
                        $team,"Icon"
                    )
                ),
                "Options" => $this->Tournament_Matches_Group_Options
                (
                    $tournament,$team2_n,
                    array
                    (
                        "TITLE" => $team[ $key ],
                        "CLASS" =>$classes,
                    )
                )
            );
    }
    //*
    //* 
    //*

    function Tournament_Matches_Group_Initials_Team($tournament,$team,$team2_n=0,$options=array())
    {
        $init_key="Initials_".$this->MyLanguage_Get();
        $key="Title_".$this->MyLanguage_Get();

        return
            array
            (
                "Text" =>
                $this->TeamsObj()->MyMod_Data_Fields_Show
                (
                    $init_key,
                    $team,
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
                "Options" => $this->Tournament_Matches_Group_Options
                (
                    $tournament,$team2_n,
                    array_merge
                    (
                        array
                        (
                            "TITLE" => $team[ $key ]
                        ),
                        $options
                    )
                ),
            );
    }
}

?>
