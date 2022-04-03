<?php

trait MyMod_HorMenu_Actions
{
    var $MyMod_HorMenues_Actions=array();
    
    //*
    //* function MyMod_HorMenu_Menu_Actions, Parameter list: $menu
    //*
    //* Returns actions for $menu.

    function MyMod_HorMenu_Menu_Actions($menu)
    {
        return $this->ProfileHash[ "Menues" ][ $menu ];
    }

    //*
    //* Generates and prints menu of actions as in $pactions,
    //* using $cssclass as CSS class parameter to ActionEntry.
    //* Prints horisontal menu of actions.
    //*

    function MyMod_HorMenu_Actions($pactions,$cssclass="",$id="",$item=array(),$title="",$caction="")
    {
        if (empty($caction))  { $caction=$this->MyActions_Detect(); }
        if (empty($item)) { $item=$this->ItemHash; }

        $args=$_SERVER[ "QUERY_STRING" ];
        $hrefs=array();

        $included=array();
        foreach ($pactions as $action)
        {
            $raction=$action;
            $res=$this->MyAction_Allowed($action,$item);

            if (!empty($this->Actions[ $action ][ "AltAction" ]))
            {
                if (!$res || $caction==$action)
                {
                    $raction=$this->Actions[ $action ][ "AltAction" ];
                }
            }
            elseif (!$res) { continue; }

            if (!empty($included[ $raction ])) { continue; }

            //Exclude both - or just one
            $included[ $raction ]=1;
            $included[ $action ]=1;

            $href=
                $this->MyMod_HorMenu_Action
                (
                    $raction,
                    $cssclass,
                    $id,
                    $item,
                    $title,
                    $caction
                );

            if (!empty($href))
            {
                array_push($hrefs,$href);
            }
        }

        if (empty($hrefs)) { return array(); }

        return
            $this->Htmls_DIV
            (
                array
                (
                    $this->Htmls_HRef_Menu($cssclass,$title,$hrefs)
                ),
                array
                (
                    "ID" => $cssclass,
                    "CLASS" => 'hormenu',
                )
            );
    }

    //*
    //*
    //*

    function MyMod_HorMenu_Actions_Get($singular,$pactions,$id,$item)
    {
        $included=array();
        $actions=array();
        foreach ($pactions as $action)
        {
            $raction=
                $this->MyMod_HorMenu_Action_Get
                (
                    $singular,
                    $action,$id,$item
                );
            
            $res=$this->MyAction_Allowed($raction,$item);

            if (!$res) { continue; }
            
            if (empty($included[ $action ]))
            {
                array_push($actions,$action);
                $included[ $raction ]=True;
            }
        }
            
        return $actions;
    }
}

?>