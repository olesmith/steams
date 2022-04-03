<?php

include_once("Entry/Alert.php");
include_once("Entry/Name.php");
include_once("Entry/Icon.php");
include_once("Entry/Url.php");

trait MyActions_Entry
{
    use
        MyActions_Entry_Alert,
        MyActions_Entry_Name,
        MyActions_Entry_Icon,
        MyActions_Entry_Url;
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry($action,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$alt=FALSE,$icon="",$name="",$size="",$itemargs=array())
    {
        if ($this->IconsPath=="")
        {
            $this->IconsPath=$this->FindIconsPath();
        }

        $entry=$this->Actions($action);
        if
            (
                !empty($action)
                &&
                !empty($entry)
                &&
                is_array($entry)
            )
        {
            if ($this->MyAction_Allowed($action,$item))
            {
                return
                    $this->MyActions_Entry_Gen
                    (
                        $action,
                        $item,
                        $noicons,
                        $class,
                        $rargs,
                        $noargs,
                        $icon,
                        $name,
                        $size,

                        $itemargs
                    );
            }
            elseif (isset($this->Actions[ $action ][ "AltAction" ]))
            {
                $rdata=$this->Actions[ $action ][ "AltAction" ];
                if (!$alt)
                {
                    return
                        $this->MyActions_Entry
                        (
                            $rdata,
                            $item,
                            $noicons,
                            $class,
                            array(),array(),TRUE
                        );
                }
            }
        }
        else
        {
            $this->AddMsg("Warning: Action $action undefined!");
        }

        return "";
    }


    //*
    //* Calls MyActions_Entry above, but beforehand, swaps beteeen odd/even icons.
    //*

    function MyActions_Entry_OddEven($even,$action,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array())
    {
        $this->Actions();

        $icon=$action;
        if (!empty($this->Actions[ $action ][ "Icon" ]))
        {
            $icon=$this->Actions[ $action ][ "Icon" ];
            if ($this->MyMod_Data_Image_Value_Is($icon))
            {
                if ($even)
                {
                    $icon=preg_replace('/light.png$/',"dark.png",$icon);
                }
                else
                {
                    $icon=preg_replace('/dark.png$/',"light.png",$icon);
                }
            }
            elseif (preg_match('/^(fa[srlb])/',$icon,$matches))
            {
                if ($even)
                {
                    if (!empty($this->Actions[ $action ][ "Icon_Even" ]))
                    {
                        $icon=$this->Actions[ $action ][ "Icon_Even" ];
                    }
                }
            }

            $icon=
                $this->MyActions_Entry
                (
                    $action,
                    $item,
                    $noicons,
                    $this->MyMod_EvenOdd_Class($even),
                    $rargs,
                    $noargs,
                    $alt=False,
                    $icon
                );
        }
        
        return $icon;
    }


    //*
    //* Returns Anchor associated with action $action..
    //*

    function MyActions_Entry_Anchor($action)
    {
        $anchor="";
        if (empty($this->Actions[ $action ][ "Confirm" ]))
        {
            $anchor=$this->Actions($action,"Anchor");
        }
        
        return $anchor;
    }
    
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry_Gen($action,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$icon="",$name="",$size="",$itemargs=array())
    {
        #if (empty($this->Actions[ $action ][ "Name" ])) { return ""; }

        return
            $this->Htmls_HRef
            (
                $this->MyActions_Entry_URL($action,$item,$rargs,$noargs,$itemargs),
                $this->MyActions_Entry_Name($action,$noicons,$item,$icon,$name,$size),
                $this->MyActions_Entry_Title($action,$item),
                $class,

                $this->MyActions_Entry_Args($action),
                $this->MyActions_Entry_Options($action)
            );
    }

    
    //*
    //* Returns Anchor associated with action $action..
    //*

    function MyActions_Entry_Args($action)
    {
        
       return
           array
           (
               "Target" => $this->Actions[ $action ][ "Target" ],
               "Anchor" => $this->MyActions_Entry_Anchor($action),
           );
    }
    
    //*
    //* Returns Anchor associated with action $action..
    //*

    function MyActions_Entry_Options($action)
    {
        return
            array
            (
                "ONCLICK" => $this->MyActions_Entry_OnClick($action)
            );
    }
    
    //*
    //* Returns Anchor associated with action $action.
    //*

    function MyActions_Entry_OnClick($action)
    {
        return
            "console.log('".$action."');";
    }
}

?>