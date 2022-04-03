<?php

include_once("Dynamic/Entry.php");
include_once("Dynamic/Entries.php");

include_once("Dynamic/Destination.php");
include_once("Dynamic/Destinations.php");

trait MyApp_Interface_LeftMenu_Dynamic
{
    use
        MyApp_Interface_LeftMenu_Dynamic_Entry,
        MyApp_Interface_LeftMenu_Dynamic_Entries,
        MyApp_Interface_LeftMenu_Dynamic_Destination,
        MyApp_Interface_LeftMenu_Dynamic_Destinations;

    var
        $MyApp_Interface_LeftMenu_Dynamic_Add="+",
        $MyApp_Interface_LeftMenu_Dynamic_Sub="-";
    
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Menu($base,$obj,$items,$activeid,$action,$href,$cgivar,$name,$title,$class="leftmenulinks",$load_destinations=False)
    {
        //var_dump($menumethod);
        $this->Htmls_Menues_Dynamic_Init
        (
            //$menu info
            array
            (
                "Items_Per_Line" => 6,
                "Name" => "",
                "Title" => "",
                "Color" => "blue",
                "Hide_Color" => "grey",
                "Reload_Color" => "blue",
                "Toggle_Others" => True,
                "Display_Show" => 'inline-block',
            ),


             //Entries
            $this->MyApp_Interface_LeftMenu_Dynamic_Entries
            (
                $base,$obj,$items,
                $action,
                $href,$cgivar,$name,$title,$class
            ),

            
            /* //Destinations */                
            $this->MyApp_Interface_LeftMenu_Dynamic_Destinations
            (
                $base,$obj,$items,
                $class,$load_destinations
            )//,
            
            /* //Loads */
            /* $this->MyMod_Groups_Menu_Loads($group,$item,$cellid,$singular) */
        );

        $entries=
            $this->Htmls_Menues_Dynamic_Entries($extras=False);
        
        $destinations=
            $this->Htmls_Menues_Dynamic_Destinations();

        $html=array();
        foreach ($items as $id => $item) 
        {
            array_push
            (
                $html,
                array
                (
                    $entries[ $id ],
                    $destinations[ $id ],
                )
            );
        }

        array_push
        (
            $html,
            $this->MyApp_Interface_LeftMenu_Dynamic_Loads
            (
                $base,$obj,$items,
                $activeid
            )
        );
        
        return $html;
    }
        
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Loads($base,$obj,$items,$activeid)
    {
        $html=array();
        if (!empty($activeid))
        {
            $html=
                $this->JS_Click_Element_By_ID
                (
                    join
                    (
                        "_",
                        array
                        (
                            $this->MyApp_Interface_LeftMenu_Dynamic_Entry_ID
                            (
                                $base,$obj,
                                $this->MyApp_Interface_LeftMenu_Dynamic_Entry_Active_Get
                                (
                                    $items,$activeid
                                )
                            ),
                            "Show"
                        )
                    )
                );
        }

        return $this->Htmls_SCRIPT($html);
    }
 }

?>