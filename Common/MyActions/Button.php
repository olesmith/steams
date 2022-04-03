<?php


trait MyActions_Button
{
    //*
    //* Creates Action Entry as clickable.
    //*

    function MyActions_Entry_Button($defs,$action,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$icon="",$name="",$size="",$itemargs=array())
    {

        return
            array
            (
                $this->Htmls_Tag
                (
                    $this->MyActions_Entry_Button_Tag($defs,$action,$item),
                    $this->MyActions_Entry_Button_Contents
                    (
                        $defs,
                        $action,$item,$icon,$name,$size,$noicons
                    ),

                    $this->MyActions_Entry_Button_Options
                    (
                        $defs,True,
                        $action,$item,$rargs,$noargs,$itemargs
                    )
                ),
                
                $this->Htmls_Tag
                (
                    $this->MyActions_Entry_Button_Tag($defs,$action,$item),
                    $this->MyActions_Entry_Button_Contents
                    (
                        $defs,
                        $action,$item,$icon,$name,$size,$noicons
                    ),

                    $this->MyActions_Entry_Button_Options
                    (
                        $defs,False,
                        $action,$item,$rargs,$noargs,$itemargs
                    )
                ),
            );
    }

        
    //*
    //* 
    //*

    function MyActions_Entry_Button_Tag($defs,$action,$item=array())
    {
        $tag="SPAN";
        if (!empty($defs[ "Tag" ])) { $tag=$defs[ "Tag" ]; }

        return $tag;
    }
    
    //*
    //* 
    //*

    function MyActions_Entry_Button_Contents($defs,$action,$item=array(),$icon="",$name="",$size="",$noicons=0)
    {
        return
            $this->MyActions_Entry_Name($action,$noicons,$item,$icon,$name,$size);
    }
    
    //* 
    //*
    //*

    function MyActions_Entry_Button_Options($defs,$on,$action,$item=array(),$rargs=array(),$noargs=array(),$itemargs=array())
    {
        return
            array
            (
                "ID" => $this->MyActions_Entry_Button_ID($defs,$on,$action),
                "TITLE" => $this->MyActions_Entry_Title($action,$item),
                "ONCLICK" => $this->MyActions_Entry_Button_Onclick
                (
                    $defs,$on,
                    $action,
                    $item,$rargs,$noargs,$itemargs
                ),

                "STYLE" => $this->MyActions_Entry_Button_Style
                (
                    $defs,$on,
                    $action,
                    $item,$rargs,$noargs,$itemargs
                ),
            );
    }
    
    //* 
    //* ID for show/hode buttons.
    //*

    function MyActions_Entry_Button_Destination($defs,$action)
    {
        return $defs[ "Destination" ];
    }
    
    //* 
    //* ID for show/hode buttons.
    //*

    function MyActions_Entry_Button_ID($defs,$on,$action)
    {
        $id="Hide";
        if ($on)
        {
            $id="Show";
        }

        return
            $defs[ "ID" ].
            "_".
            $id;
    }
    
    //* 
    //*
    //*

    function MyActions_Entry_Button_Onclick($defs,$on,$action,$item=array(),$rargs=array(),$noargs=array(),$itemargs=array())
    {
        $rargs[ "RAW" ]=1;
        $rargs[ "NoHorMenu" ]=1;
        $rargs[ "Dest" ]=
            $this->MyActions_Entry_Button_Destination
            (
                $defs,$action
            );
        
        $js=
            array
            (
                $this->JS_Load_URL_2_Element
                (
                    $this->MyActions_Entry_URL
                    (
                        $action,$item,$rargs,$noargs,$itemargs
                    ),
                    $this->MyActions_Entry_Button_Destination($defs,$action)
                )
            );

        if ($on)
        {
            $shows=
                array
                (
                    $this->MyActions_Entry_Button_Destination
                    (
                        $defs,$action
                    ),
                    $this->MyActions_Entry_Button_ID
                    (
                        $defs,False,$action
                    )
                );

            $hides=
                array
                (
                    $this->MyActions_Entry_Button_ID
                    (
                        $defs,True,$action
                    )
                );
        }
        else
        {
            $hides=
                array
                (
                    $this->MyActions_Entry_Button_Destination
                    (
                        $defs,$action
                    ),
                    $this->MyActions_Entry_Button_ID
                    (
                        $defs,False,$action
                    )
                );

            $shows=
                array
                (
                    $this->MyActions_Entry_Button_ID
                    (
                        $defs,True,$action
                    )
                );
        }

        return
            array
            (
                $this->JS_Load_URL_2_Element
                (
                    $this->MyActions_Entry_URL
                    (
                        $action,$item,$rargs,$noargs,$itemargs
                    ),
                    $this->MyActions_Entry_Button_Destination
                    (
                        $defs,$action
                    ),
                    ""//empty to keep reloading
                ),
                
                $this->JS_Show_Elements_By_ID($shows),
                
                $this->JS_Hide_Elements_By_ID($hides),
            );
            
    }
    
    //* 
    //*
    //*

    function MyActions_Entry_Button_Style($defs,$on,$action,$item=array(),$rargs=array(),$noargs=array(),$itemargs=array())
    {
        $style=array();
        
        if ($on)
        {
            $style[ "color" ]="blue";
        }
        else
        {
            $style[ "display" ]="none";
            $style[ "color" ]="grey";
        }
        
        return $style;
    }
    
}

?>