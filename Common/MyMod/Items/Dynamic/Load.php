<?php

trait MyMod_Items_Dynamic_Load
{
    //*
    //* Method to call on each item, in order to check and include
    //* automatic loading on $items.
    //* If defined, call on each $item.
    //*

    function MyMod_Items_Dynamic_Loads_JS($edit,$items,$group)
    {
        //automatic loading on $items.
        $load_method=$this->ItemDataGroups($group,"Load_Method");

        $js=array();
        if (!empty($load_method) || !empty($this->CGI_GETint("Include_ID")))
        {
            array_push
            (
                $js,
                $this->MyMod_Items_Dynamic_Loads
                (
                    $load_method,$edit,$items,$group
                )
            );
        }

        return $js;
    }
    
    //*
    //* Generate list of loads.
    //*

    function MyMod_Items_Dynamic_Loads($load_method,$edit,$items,$group,$action=False,$load=True)
    {
        $js=array();
        foreach ($items as $item)
        {
            $js=
                array_merge
                (
                    $js,
                    $this->MyMod_Items_Dynamic_Load
                    (
                        $load_method,$edit,$item,$items,$group,$action,$load
                    )
                );
        }

        return $js;
    }
    
    //*
    //* Generate specific load.
    //*

    function MyMod_Items_Dynamic_Load($load_method,$edit,$item,$items,$group,$action=False,$load=True)
    {
        $js=array();

        $load_action=
            $this->ItemDataGroups($group,"Load_Action");
        
        $load_method=
            $this->ItemDataGroups($group,"Load_Method");
        
        $load=False;
        if
            (
                !empty($load_method)
                &&
                !empty($load_action)
            )
        {
            $load=False;
            if (is_bool($load_method)) { $load=$load_method; }
            else                       { $load=$this->$load_method($item,$items); }
        }
        elseif (!empty($this->CGI_GETint("Include_ID")))
        {
            $id=$this->CGI_GETint("Include_ID");
            if ($id==$item[ "ID" ])
            {
                $load=True;
            }
        }

        if ($load)
        {
            if (empty($load_action))
            {
                $actions=
                    array_keys
                    (
                        $this->ItemDataGroups($group,"Dynamic")
                    );
        
                $load_action=array_shift($actions);
            }

            array_push
            (
                $js,
                $this->JS_Click_Element_By_ID
                (
                    $this->MyMod_Item_Dynamic_Entry_Element_ID
                    (
                        $group,$load_action,
                        $is_hide_cell=False,
                        $item
                    )
                )
            );
        }
        
        return $js;
    }
}

?>