<?php


trait MyMod_Items_Dynamic_Titles
{
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Title_Rows($group,$items,$title="")
    {
        $debug=False;
        $display="";
        if (!$debug) { $display="none"; }
        
        return
            array
            (
                array
                (
                    "Row" => $this->MyMod_Item_Dynamic_Title_Menu_Row
                    (
                        $group,$items,$title
                    ),
                    "Options" => array
                    (
                        "ID" => $this->MyMod_Item_Dynamic_Title_Menu_Row_ID($group),
                        "STYLE" => array
                        (
                            "display" => 'none',
                        )
                    )
                ),
                $this->MyMod_Item_Dynamic_Titles($group),
            );
            
    }
    
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Titles_Cells($group,$checkbox=True)
    {
        $titles=$this->MyMod_Items_Group_Titles($group);
       
        $actions=array();
        for ($n=0;$n<$this->MyMod_Item_Dynamic_Title_Menu_N($group);$n++)
        {
            array_push($actions,"");
            
        }
        
        array_splice
        (
            $titles,
            $this->MyMod_Item_Dynamic_Actions_Position($group),
            0,
            $actions
        );

        $display="initial";
        /* if (count($items)<2) */
        /* { */
        /*     $display="none"; */
        /* } */

        if ($checkbox)
        {
            array_unshift
            (
                $titles,
                $this->MyMod_Item_Dynamic_CheckBox
                (
                    $group,
                    array("ID" => 0),
                    array(),//options
                    array
                    (
                        "display" => $display,
                    )
                )
            );
        }

        return $titles;
    }
    
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Titles($group)
    {
        return
            $this->Htmls_Table_Head_Row
            (
                $this->MyMod_Item_Dynamic_Titles_Cells($group)
            );
    }


    //*
    //* Create cells with links to load all actions.
    //*

    function MyMod_Item_Dynamic_Title_Menu_Row($group,$items,$title="")
    {
        if  ( !empty($this->ItemDataSGroups[ $group ][ "No_Title_Action" ])  )
        {
            return array();
        }
        
        $titles=array();
        
        array_push
        (
            $titles,
            ""
        );
        
        for ($n=0;$n<$this->MyMod_Item_Dynamic_Actions_Position($group);$n++)
        {
            array_push($titles,"");
        }

        $titles=
            array_merge
            (
                $titles,
                $this->MyMod_Item_Dynamic_Title_Menu($group,$items)
            );

        
        return $titles;
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Title_Menu_N($group)
    {
        if ($this->LatexMode()) { return 0; }
        
        return count($this->MyMod_Item_Dynamic_Actions($group));
    }
    
    //*
    //* Create cells with links to load all actions.
    //*

    function MyMod_Item_Dynamic_Title_Menu($group,$items)
    {
        
        $this->Htmls_Menues_Dynamic_Init
        (
            //$menu info
            array
            (
                "Name" => "",
                "Title" => "",
                "Color" => "slateblue",
                "Hide_Color" => "grey",
                "Back_Color" => "#DDDDDD",
                "Reload_Color" => "#efa572",
                "Toggle_Others" => True,
            ),

                
            //Entries
            $this->MyMod_Item_Dynamic_Title_Entries($group,$items)

            /* //No Destinations nor Loads */
        );

        return
            $this->Htmls_Menues_Dynamic_Entries($extras=False);

        //var_dump($entries);
    }
    
    //*
    //* The $group menu entries: links for opening all $action.
    //*

    function MyMod_Item_Dynamic_Title_Entries($group,$items)
    {
        $entries=array();
        foreach ($this->MyMod_Item_Dynamic_Actions($group) as $action)
        {            
            $entries[ $action ]=
                $this->MyMod_Item_Dynamic_Title_Entry
                (
                    $group,
                    $this->Defs[ $action ],
                    $action,
                    $items
                );
        }

        return $entries;
    }
    
    //*
    //* One $group menu $action entry.
    //*

    function MyMod_Item_Dynamic_Title_Entry($group,$def,$action,$items)
    {
        if (!empty($def[ "Not_All" ])) { return array(); }
        $ids=
            $this->MyMod_Item_Dynamic_Entries_Element_IDs
            (
                $this->Group,
                $action,True
            );


        if (empty($ids)) { return array(); }
        
        
        $icon=
            $this->MyMod_Item_Dynamic_Entry_Icon($def);

        return
            array
            (
                "Tag" => "BUTTON",
                "Hide" => False,
                
                "ID" => $this->MyMod_Item_Dynamic_Title_Entry_Action_ID
                (
                    $group,$def,$action
                ),
                //"Name" =>  ,
                "Title" =>
                $this->MyLanguage_GetMessage("All").
                " ".
                $this->MyMod_Item_Dynamic_Action_Title($group,$def),
                
                "Icon" =>  $icon,
                       
                "Onclick" => "MyMod_Item_Dynamic_Title_Entry_JS",
            );
    }
    
   
    //*
    //* Make JS entry for clicking all icons associated with  $action.
    //*
             
    function MyMod_Item_Dynamic_Title_Entry_JS($action,$is_hide_cell)
    {
        if ($is_hide_cell)
        {
            //return array();
        }
        
        return
            array
            (
                $this->JS_Click_Elements_By_Checked_IDs
                (
                    $this->MyMod_Item_Dynamic_Entries_Element_IDs
                    (
                        $this->Group,
                        $action,$is_hide_cell
                    ),
                    $this->MyMod_Item_Dynamic_CheckBox_IDs
                    (
                        $this->Group,
                        $action,$is_hide_cell
                    )
                )
            );
    }    
}

?>