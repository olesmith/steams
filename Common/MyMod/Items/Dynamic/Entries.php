<?php


trait MyMod_Items_Dynamic_Entries
{
    //*
    //* Generate the $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Entries($item,$group)
    {
        $entries=array();
        foreach ($this->MyMod_Item_Dynamic_Actions($group) as $action)
        {
            $def=$this->Defs[ $action ];
            
            $raction=
                $this->MyMod_Item_Dynamic_Action_Allowed
                (
                    $group,
                    $def,
                    $item
                );
            
            //Make sure that entries receives possible alt action (Edit -> Show)
            $def[ "Action" ]=$raction;
            //$this->Defs[ $action ][ "Action" ]=$raction;


            if (!empty($raction))
            {
                $entries[ $action ]=
                    $this->MyMod_Item_Dynamic_Entry
                    (
                        $item,$group,
                        $action,
                        $def
                    );
            }
            else
            {
                $entries[ $action ]=
                    $this->MyMod_Item_Dynamic_Entry_Empty
                    (
                        $item,$group,$action
                    );
            }
        }

        return $entries;
    }

}

?>