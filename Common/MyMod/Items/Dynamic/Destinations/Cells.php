<?php

trait MyMod_Items_Dynamic_Destinations_Cells
{
    //*
    //* Empty cells until Dynamic position, then destination cell.
    //*

    function MyMod_Item_Dynamic_Destination_Item_Cells($item,$group)
    {
        $cells=
            array
            (
                $this->MyMod_Item_Dynamic_Destination_Leading_Cell($item),
            );

        $rcells=array();
        foreach ($this->MyMod_Item_Dynamic_Actions($group) as $action)
        {
            $raction=
                $this->MyMod_Item_Dynamic_Action_Allowed
                (
                    $group,
                    $this->Defs[ $action ],
                    $item
                );

            $cell=array();
            if (!empty($raction))
            {
                array_push
                (
                    $rcells,
                    $this->MyMod_Item_Dynamic_Destination_Item_Cell
                    (
                        $item,$group,$action
                    )
                );
            }
        }

        array_push
        (
            $cells,
            array
            (
                "Cell" => $rcells,
                array
                (
                    "COLSPAN" => $this->MyMod_Item_Dynamic_Table_N
                    (
                        $group,$item
                    ),
                )
            )
        );
        
        return $cells;
    }

    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Destination_Leading_Cell($item)
    {
        return
            $this->Htmls_Multi_Cell
            (
                 $this->Htmls_DIV
                 (
                     $this->MyMod_Item_Name_Get($item),
                     array(),
                     array
                     (
                         'overflow-wrap' =>  'break-word'
                     )
                 ),
                 $this->MyMod_Items_Dynamic_Table_NLeading
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Destination_Item_Cell($item,$group,$action)
    {
        return
            $this->Htmls_DIV
            (
                array
                (
                    "",
                ),
                array
                (
                    "ID" => $this->MyMod_Item_Dynamic_Destination_Cell_ID
                    (
                        $item,$group,$action
                    ),
                 )
            );
    }
}

?>