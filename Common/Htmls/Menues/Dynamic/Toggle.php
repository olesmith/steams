<?php


trait Htmls_Menues_Dynamic_Toggle
{
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*

    function Htmls_Menues_Dynamic_Toggle($key,$is_hide_cell,$hide)
    {
        return
            $this->Htmls_Dynamic_Cell
            (
                $this->Htmls_Menues_Dynamic_Toggle_Def
                (
                    $key,
                    $is_hide_cell,
                    $hide
                )
            );
    }
    

    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Toggle_Def($key,$is_hide_cell,$hide)
    {
        $rkey="";
        if ($is_hide_cell)
        {
            $rkey="Hide";
            $onclick=
                $this->Htmls_Menues_Dynamic_Entry_JS_Hide($key);

        }
        else
        {
            $rkey="Show";
            $onclick=
                $this->Htmls_Menues_Dynamic_Entry_JS_Show($key);
        }

        
        
        return
            array_merge
            (
                $this->Htmls_Menues_Dynamic_Entry_Key($key),
                array
                (
                    "Hide_Cell" => $is_hide_cell,
                    "Color" =>
                    $this->Htmls_Menues_Dynamic_Toggle_Color
                    (
                        $key,$is_hide_cell
                    ),
                    
                    "Back_Color" =>
                    $this->Htmls_Menues_Dynamic_Entry_Value
                    (
                        $key,"Back_Color"
                    ),
                    
                    "Cell_ID" =>
                    $this->Htmls_Menues_Dynamic_Toggle_ShowHide
                    (
                        $key,$is_hide_cell
                    ),
                    
                    "Onclick" => $onclick,
                    
                    "Class" =>
                    $this->Htmls_Menues_Dynamic_Entry_Value
                    (
                        $key,"Class"
                    ),
                    
                    "Title" => $this->Htmls_Menues_Dynamic_Toggle_Title
                    (
                        $key,$is_hide_cell
                    )
                ),
                array
                (
                    "TYPE" => 'button',
                    "Hide" => $hide,
                )
            );
    }
    
    //*
    //*
    //*

    function Htmls_Menues_Dynamic_Toggle_Title($key,$is_hide_cell)
    {
        $title=
            $this->Htmls_Menues_Dynamic_Entry_Value($key,"Title");

        if (empty($title))
        {
            $title=
                $this->Htmls_Menues_Dynamic_Entry_Value($key,"Name");
        }

        if ($is_hide_cell)
        {
            $title=
                $this->MyLanguage_GetMessage("Hide").
                " ".
                $title;
        }
        else
        {
            $title=
                $this->MyLanguage_GetMessage("Show").
                " ".
                "".
                $title;
        }
        
        return $title;
    }
    
    //*
    //* Include common toggling JS along with specific $key stuff.
    //* If Onclick key is callable on $this, this method is called.
    //*
    //* Argument $is_hide_cell is passed to the method.
    //* This makes it possible to provide alternative JS
    //* for show/hide entries.
    //*

    function Htmls_Menues_Dynamic_Toggle_ONCLICK($key,$is_hide_cell)
    {
        //Common JS, making the toggles toggle.
        $onclick=
            array
            (
                $this->Htmls_Menues_Dynamic_JS_ShowHide
                (
                    $key,$is_hide_cell
                )
            );
        
        $value="";
        if ($is_hide_cell)
        {
            $value=
                $this->Htmls_Menues_Dynamic_Entry_Value
                (
                    $key,"Offclick"
                );
        }

        if (empty($value))
        {
            $value=
                $this->Htmls_Menues_Dynamic_Entry_Value
                (
                    $key,"Onclick"
                );
        }
        
        $method=False;

        if (is_string($value) && method_exists($this,$value))
        {
            $method=$value;
            $value=$this->$value($key,$is_hide_cell);
        }

        if (!empty($value))
        {
            
            if (!is_array($onclick))
            {
                $onclick=array($onclick);
            }
            if (!is_array($value))
            {
                $value=array($value);
            }
            
            $onclick=                
                array_merge($onclick,$value);
        }

        if ($method)
            {
                //var_dump($value,$onclick);
            }
        
        return $onclick;
        
    }

    //*
    //* Generates horisontal dynamic menu cell ID for $key.
    //*
    
    function Htmls_Menues_Dynamic_Toggle_ShowHide($key,$is_hide_cell)
    {
        $id="";
        if ($is_hide_cell)
        {
            $id.="_Hide";
        }
        else
        {
            $id.="_Show";
        }

        return $id;
    }
    
    //*
    //* 
    //*
    
    function Htmls_Menues_Dynamic_Toggle_Color_Key($is_hide_cell)
    {
        $col_key="Color";
        if ($is_hide_cell)
        {
            $col_key="Hide_Color";
        }

        return $col_key;
    }
    
    //*
    //* 
    //*
    
    function Htmls_Menues_Dynamic_Toggle_Color($key,$is_hide_cell)
    {
        return
            $this->Htmls_Menues_Dynamic_Entry_Value
            (
                $key,
                $this->Htmls_Menues_Dynamic_Toggle_Color_Key($is_hide_cell)
            );
    }
    
    //*
    //* 
    //*
    
    function Htmls_Menues_Dynamic_Toggle_Color_Reload($key)
    {
        $color=
            $this->Htmls_Menues_Dynamic_Entry_Value
            (
                $key,
                "Reload_Color"
            );

        if (empty($color))
        {
            $color=
                $this->Htmls_Menues_Dynamic_Toggle_Color($key,False);
        }

        return $color;
    }
    
    
}
?>