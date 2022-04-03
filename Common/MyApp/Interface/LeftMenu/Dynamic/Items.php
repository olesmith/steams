<?php


trait MyApp_Interface_LeftMenu_Dynamic_Items
{
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Items_Menu($base,$obj,$menumethod,$items,$activeid,$href,$name,$title,$class="leftmenulinks",$add="+",$sub="-")
    {
        $list=array();
        foreach ($items as $id => $item)
        {
            array_push
            (
                $list,
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Entry
                (
                    $base,$obj,$menumethod,$item,$activeid,$name,$title,
                    $href,
                    $class
                )
            );
        }

        
        if (!empty($activeid))
        {
            $item=
                $this->MyApp_Interface_LeftMenu_Dynamic_Items_Active_Get
                (
                    $items,$activeid
                );

            array_push
            (
                $list,
                $this->Htmls_Script
                (
                    array
                    (
                        $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_ONCLICK
                        (
                            $base,$obj,
                            $item,
                            True,
                            $href
                        ),
                        $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load
                        (
                            $base,$obj,
                            $item,$href
                        ),
                    )
                )
            );
        }
       

        return $list;
    }
    
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Items_Active_Get($items,$activeid)
    {
        return
            $this->MyHash_HashHashes_Find_First
            (
                $items,
                array("ID" => $activeid)
            );
        /* $item=array(); */
        /* foreach ($items as $ritem) */
        /* { */
        /*     if ($ritem[ "ID" ]=$activeid) */
        /*     { */
        /*         $item=$ritem; */
        /*         break; */
        /*     } */
        /* } */

        /* return $item; */
    }
 }

?>