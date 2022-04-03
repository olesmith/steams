<?php

include_once("HorMenu/Action.php");
include_once("HorMenu/Actions.php");


include_once("HorMenu/Entry.php");
include_once("HorMenu/Entries.php");
include_once("HorMenu/Destination.php");
include_once("HorMenu/Destinations.php");
include_once("HorMenu/Loads.php");

include_once("HorMenu/Info.php");

trait MyMod_HorMenu
{
    var $MyMod_HorMenu_Send=0;

    //ByLoad False more eficient.
    var $MyMod_HorMenu_Dynamic_ByLoad=True;

    use 
        MyMod_HorMenu_Action,
        MyMod_HorMenu_Actions,
        MyMod_HorMenu_Entry,
        MyMod_HorMenu_Entries,
        MyMod_HorMenu_Destination,
        MyMod_HorMenu_Destinations,
        MyMod_HorMenu_Loads,
        MyMod_HorMenu_Info;

    //*
    //* function MyMod_HorMenu_Menues, Parameter list: $singular,$id=""
    //*
    //* Returns horisontal menues of Singular or Plural actions.
    //*

    function MyMod_HorMenu_Menues($singular,$id="")
    {
        $item=$this->ItemHash;
        if (empty($id) && !empty($item[ "ID" ])) { $id=$item[ "ID" ]; }

        return
            $this->Htmls_Menues_Dynamic
            (
                //$menu info
                array
                (
                    "Name" => "",
                    "Title" => "Horisontal Menu",
                    "Color" => "orange",
                    "Hide_Color" => "grey",
                    "Reload_Color" => "#efa572",
                    "Toggle_Others" => True,
                    "Items_Per_Line" => 8,
                ),
                
                $this->MyMod_HorMenues_Entries
                (
                    $singular,$id,$item
                ),
                
                $this->MyMod_HorMenues_Destinations
                (
                    $singular,$id,$item
                ),
                
                $this->MyMod_HorMenu_Loads
                (
                    $id,$item
                ),
                
                $debug=False
            );
        
    }
    
    
    //*
    //* Prints horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Should()
    {
        return empty($this->CGI_GETint("NoHorMenu"));
    }
    
    //*
    //* Prints horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Echo($plural=FALSE,$id="")
    {
        if ($this->MyMod_HorMenu_Send!=0) { return; }
        
        if (!$this->MyMod_HorMenu_Should())
        {
            return;
        }
        
        $singular=$this->MyMod_HorMenu_IsSingular();

        if (method_exists($this->ApplicationObj(),"PreInterfaceMenu"))
        {
            $this->ApplicationObj()->PreInterfaceMenu(!$singular,$id);
        }
        elseif (method_exists($this,"PreInterfaceMenu"))
        {
            $this->PreInterfaceMenu(!$singular,$id);
        }

        
        $this->Htmls_Echo
        (
            $this->Htmls_DIV
            (
                $this->MyMod_HorMenu_Gen(!$singular,$id),
                array
                (
                    "ID" => "HorMenu",
                    "CLASS" => "center tablemenu",
                )
            )
        );

        if (method_exists($this,"PostInterfaceMenu"))
        {
            $this->PostInterfaceMenu(!$singular,$id);
        }
        elseif (method_exists($this->ApplicationObj(),"PostInterfaceMenu"))
        {
            $this->ApplicationObj()->PostInterfaceMenu(!$singular,$id);
        }

        //$this->MyMod_HorMenu_Send=1;

        //Exit after sending menu.
        if ($this->MyMod_HorMenu_Dynamic_ByLoad)
        {
            exit();
        }
    }

    //*
    //* function MyMod_HorMenu_Gen, Parameter list: $plural=FALSE,$id=""
    //*
    //* Returns horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Gen($plural=FALSE,$id="")
    {
        return
            array
            (
                $this->Htmls_Comment_Section
                (
                    "Horisontal Menu",
                    $this->Htmls_Tag
                    (
                        "NAV",
                        array_merge
                        (
                            $this->ApplicationObj()->MyApp_Module_Group_Menu_Horisontal($this),
                            $this->MyMod_HorMenu_Menues(!$plural,$id)
                        )
                    )
                )
            );
    }
    
    //*
    //* function MyMod_HorMenu_Get, Parameter list: $singular
    //*
    //* Return HorMenu Plural or Singular menus.
    //*

    function MyMod_HorMenu_Get($singular)
    {
        if ($singular)
        {
            return $this-> MyMod_HorMenu_Singulars();
        }
        else
        {
            return $this->MyMod_HorMenu_Plurals();
        }
    }
 
    //*
    //* function MyMod_HorMenu_Singulars, Parameter list: 
    //*
    //* Return HorMenu Singular menus.
    //*

    function MyMod_HorMenu_Singulars()
    {
        $singulars=$this->MyMod_HorMenu_Menu_Actions("ActionsSingular");
        if (preg_match('/^Admin$/',$this->Profile()))
        {
            array_push($singulars,"Info");//,"Test");
        }
        
        return
            array
            (
                "sptablemenu" => $this->MyMod_HorMenu_Menu_Actions("SingularPlural"),
                "atablemenu"  => $singulars,
                "stablemenu"  => $this->MyMod_HorMenu_Menu_Actions("Singular"),
            );
    }

    //*
    //* function MyMod_HorMenu_Plurals, Parameter list: 
    //*
    //* Return HorMenu Plural menus.
    //*

    function MyMod_HorMenu_Plurals()
    {
        $plurals=$this->MyMod_HorMenu_Menu_Actions("Plural");
        if (preg_match('/^Admin$/',$this->Profile()))
        {
            array_push($plurals,"Info");
        }
        
        return
            array
            (
                "sptablemenu" => $this->MyMod_HorMenu_Menu_Actions("SingularPlural"),
                "ptablemenu"  => $plurals,
                "atablemenu"  => $this->MyMod_HorMenu_Menu_Actions("ActionsPlural"),
            );
    }
    
    //*
    //* function MyMod_Action_IsSingular, Parameter list: $action=""
    //*
    //* Detects whether oMod $action is sinngular or not.
    //*

    function MyMod_HorMenu_IsSingular($action="")
    {
        if (empty($action)) { $action=$this->MyActions_Detect(); }

        if (is_string($action) && !empty($this->Actions[ $action ]))
        {
            $action=$this->Actions[ $action ];
        }

        $res=FALSE;
        if (!empty($action[ "Singular" ]))
        {
            $res=TRUE;
        }

        return $res;
    }
    
}

?>