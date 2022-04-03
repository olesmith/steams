<?php

trait Tournaments_Seasons_Select_Actions
{
    //*
    //* 
    //*

    function Tournament_Season_Select_Actions($dest_id,$actions,$default_action)
    {
        $this->TournamentsObj()->Actions();
                
        return
            array
            (
                $this->Tournament_Season_Select_Actions_Field
                (
                    $dest_id,$actions,$default_action
                ),
                $this->Tournament_Season_Select_Actions_SPAN($dest_id),
                $this->Tournament_Season_Select_Actions_SCRIPT
                (
                    $dest_id,$default_action
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Select_Actions_Field($dest_id,$actions,$default_action)
    {
        $values=array(0);
        $names=array("");
        foreach ($actions as $action)
        {
            if
                (
                    !$this->TournamentsObj()->MyAction_Allowed
                    (
                        $action,
                        $this->Tournament()
                    )
                )
            {
                continue;
            }
            
            array_push($values,$action);
            array_push
            (
                $names,
                $this->TournamentsObj()->MyActions_Entry_Name($action,$noicons=True)
            );
        }

        return
            $this->Htmls_Select
            (
                "Action",
                $values,
                $names,
                $default_action,
                array(),
                array
                (
                    "ONCHANGE" => array
                    (                            
                        $this->JS_Select_Send
                        (
                            $this->Tournament_Seasons_Select_Actions_URL($dest_id),
                            "Action"
                        ),
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Select_Actions_SPAN($dest_id)
    {
        return
            $this->Htmls_SPAN
            (
                "",
                array
                (
                    "ID" => $dest_id,
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Select_Actions_SCRIPT($dest_id,$default_action)
    {    
        if (!empty($_GET[ "Pool" ]))
        {
            return array();
        }
        
        return
            $this->Htmls_SCRIPT
            (
                $this->JS_Load_Once
                (
                    $this->Tournament_Seasons_Select_Action_URL
                    (
                        $dest_id,
                        $default_action
                    ),
                    $dest_id
                )
            );            
    }
    
    //*
    //*
    //* 
    //*

    function Tournament_Seasons_Select_Action_URL($dest_id,$action)
    {
        return
            array_merge
            (
                $this->Tournament_Seasons_Select_Actions_URL($dest_id),
                array
                (
                    "Action" => $action,
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Seasons_Select_Actions_URL($dest_id)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "NoHorMenu" => 1,
                    "ModuleName" => "Tournaments",
                    "Dest" => $dest_id,
                )
            );
    }
}

?>