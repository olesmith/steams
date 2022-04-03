<?php

trait MyMod_Items_Dynamic_IDs
{
    //*
    //* Destination IDs
    //*

    function MyMod_Item_Dynamic_Destination_Cell_IDs($item,$group,$curr_action)
    {
        $ids=array();
        foreach ($this->MyMod_Item_Dynamic_Actions($group) as $action)
        {
            if ($action==$curr_action) { continue; }
            
            $raction=
                $this->MyMod_Item_Dynamic_Action_Allowed
                (
                    $group,
                    $this->Defs[ $action ],
                    $item
                );

            if ($raction==$curr_action) { continue; }
            if (!empty($raction))
            {
                array_push
                (
                    $ids,
                    $this->MyMod_Item_Dynamic_Destination_Cell_ID
                    (
                        $item,$group,$action
                    )
                );
            }
        }

        return $ids;        
    }

    var $Items=array();
    
    //*
    //* MyMod_Item_Dynamic_Entries_Element_IDs
    //*

    function MyMod_Item_Dynamic_Entries_Element_IDs($group,$action,$is_hide_cell)
    {
        $element_ids=array();
        foreach ($this->Items as $item)
        {
            if
                (
                    $this->MyMod_Item_Dynamic_Action_Allowed
                    (
                        $group,
                        $this->Defs[ $action ],
                        $item
                    )
                )
            {
                if
                    (
                        $element_id=
                        $this->MyMod_Item_Dynamic_Entry_Element_ID
                        (
                            $group,$action,$is_hide_cell,$item
                        )
                    )
                {
                    array_push($element_ids,$element_id);
                }
            }
        }

        return $element_ids;
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_CheckBox_IDs($group,$action,$is_hide_cell)
    {
        $element_ids=array();
        foreach ($this->Items as $item)
        {
            if
                (
                    $this->MyMod_Item_Dynamic_Action_Allowed
                    (
                        $group,
                        $this->Defs[ $action ],
                        $item
                    )
                )
            {
                if
                    (
                        $element_id=
                        $this->MyMod_Item_Dynamic_CheckBox_ID
                        (
                            $group,$item
                        )
                    )
                {
                    array_push($element_ids,$element_id);
                }
            }
        }

        return $element_ids;
    }
    
}

?>