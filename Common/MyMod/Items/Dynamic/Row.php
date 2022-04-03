<?php


trait MyMod_Items_Dynamic_Row
{
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Row_Actions_Menu($edit,$n,$item,$group)
    {
        //Store $item.
        $this->Item=$item;

        $this->Group=$group;
        $this->Defs=
            $this->ItemDataGroups($group,"Dynamic");
        
       
        $this->Htmls_Menues_Dynamic_Init
        (
            //$menu info
            array
            (
                "Name" => "",
                "Title" => "",
                "Color" => "blue",
                "Hide_Color" => "grey",
                "Back_Color" => "white",
                "Reload_Color" => "#efa572",
                "Toggle_Others" => True,
            ),

                
            //Entries
            $this->MyMod_Item_Dynamic_Entries($item,$group)

            /* //No Destinations nor Loads */
        );


        return
            $this->Htmls_Menues_Dynamic_Entries($extras=False);

    }
    
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Row($edit,$n,$item,$group)
    {
        if (is_array($group)) { $datas=$group; }
        else
        {
            $datas=
                $this->MyMod_Items_Group_Data($group);
        }

        if ($edit==1)
        {
            if (!$this->MyAction_Allowed("Edit",$item))
            {
                $edit=0;
            }
        }
        
        $row=
            $this->MyMod_Items_Table_Row
            (
                $edit,
                $this->MyMod_Item_Dynamic_Row_Number_Cell
                (
                    $edit,$n,$item,$group
                ),
                $item,
                $datas,
                $plural=True,
                $item[ "ID" ]."_"
            );
        
        $menu=
            $this->MyMod_Item_Dynamic_Row_Actions_Menu
            (
                $edit,$n,$item,$group
            );

        
        array_splice
        (
            $row,
            $this->MyMod_Item_Dynamic_Actions_Position($group),
            0,
            $menu
        );
            
        array_unshift
        (
            $row,
            $this->MyMod_Item_Dynamic_CheckBox($group,$item)
        );
        
        return
            array
            (
                "Row" => $row,
                "Options" =>  $this->MyMod_Item_Dynamic_Row_Options
                (
                    $edit,$n,$item,$group
                ),
            );
                    

    }
    
    //*
    //* Number cell, clickable if we have Focus on.
    //*

    function MyMod_Item_Dynamic_Row_Number_Cell($edit,$n,$item,$group)
    {
        $nn=$n;
        if ($this->MyMod_Paging_No>1)
        {
            $nn=($this->MyMod_Paging_No-1)*$this->NItemsPerPage+$n;
        }

        if
            (
                $n==$this->MyMod_Items_Dynamic_Table_Focus_Start               
            )
        {
            $nn=
                $this->Htmls_Span
                (
                    array
                    (
                        $this->MyMod_Interface_Icon("fas fa-hand-point-up"),
                        $nn,
                    ),
                    array
                    (
                        "ONCLICK" => $this->JS_Table_Display_Previous
                        (
                            $this->MyMod_Items_Dynamic_Table_Focus_Icons_Every,
                            "DROW",
                            "fas fa-hand-point-up fa-lg"
                        ),
                        "CLASS" => "ROWN",
                    )
                );
        }
            
        return $this->SPAN($nn,array("CLASS" => "ROWN"));
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Row_Options($edit,$n,$item,$group)
    {
        $options=array();
        
        $options_method=$this->ItemDataGroups($group,"Row_Options_Method");
        if (!empty($options_method))
        {
            $options=
                $this->$options_method($edit,$n,$item,$group);            
        }

        return
            array_merge
            (
                array
                (
                    "ONMOUSEOVER" => "Highlight_TR(this,'lightgray');",
                    "ONMOUSEOUT"  =>  "Highlight_TR(this);",
                    "STYLE" => $this->MyMod_Item_Dynamic_Row_Style
                    (
                        $edit,$n,$item,$group
                    ),
                    "CLASS" => "DROW N_".$n." ID_".$item[ "ID" ],
                ),
                $options
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Row_Style($edit,$n,$item,$group)
    {
        $display="table-row";
        $opacity=1;
        
        if
            (
                $this->MyMod_Items_Dynamic_Table_Focus_End
                >
                $this->MyMod_Items_Dynamic_Table_Focus_Start
                &&
                (
                    $n<$this->MyMod_Items_Dynamic_Table_Focus_Start
                    ||
                    $n>$this->MyMod_Items_Dynamic_Table_Focus_End
                )
            )
        {
            $display="none";
            $opacity=0.75;
        }
        
        $style=
            array
            (
                "opacity"  =>  $opacity,
                "display"  =>  $display,
            );

        $colors=$this->ItemDataGroups($group,"BG_Colors");
        if (!empty($colors))
        {
            $nn=($n% count($colors));
            $style[ "background-color" ]=$colors[ $nn ];
            
        }
        
        return $style;
    }
    
}

?>