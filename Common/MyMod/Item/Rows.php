<?php

include_once("Rows/Links.php");
include_once("Rows/Modules.php");
include_once("Rows/SGroup.php");
include_once("Rows/Datas.php");
include_once("Rows/Rows.php");
include_once("Rows/Details.php");

trait MyMod_Item_Rows
{
    use
        MyMod_Item_Rows_Links,
        MyMod_Item_Rows_Modules,
        MyMod_Item_Rows_SGroup,
        MyMod_Item_Rows_Datas,
        MyMod_Item_Rows_Rows,
        MyMod_Item_Rows_Details;

    
    //*
    //* Creates row with item cells.
    //*

    function MyMod_Item_Rows($edit,$setup,$item)
    {
        $redit=$edit;
        $active=$this->CGI_GETint($setup[ "GET" ]);
        if ($active>0) { $redit=0; }

        $rows=
            array
            (
                $this->MyMod_Item_Rows_Row($redit,$setup,$item),
            );

        if ($active)
        {
            array_push
            (
                $rows,
                array
                (
                    "","",
                    $this->Htmls_Frame
                    (
                        $this->MyMod_Item_Rows_Details($edit,$setup,$item)
                    )
                )
            );
        }
        
        return $rows;
        
    }
    
    //*
    //* Creates row with item cells.
    //*

    function MyMod_Item_Rows_Row($edit,$setup,$item,$callmethod=True)
    {
        if ($callmethod && !empty($setup[ "Row_Method" ]))
        {
            $datas=$this->MyMod_Items_Rows_Datas($setup);

            $method=$setup[ "Row_Method" ];
            return
                $this->$method
                (
                    $edit,
                    $setup,
                    $datas,
                    $item
                );
        }
        $link="";
        if (!empty($setup[ "Modules" ]))
        {
            $link=$this->MyMod_Item_Rows_Link($setup,$item);
        }

        return
           array_merge
            (
                array
                (
                    $item[ "No" ],
                    $link
                ),
                array
                (
                    $this->MyMod_Item_Row
                    (
                        $edit,
                        $item,
                        $setup[ "Actions" ]
                    ),
                ),
                $this->MyMod_Item_Row
                (
                    $edit,
                    $item,
                    $this->MyMod_Items_Rows_Datas($setup)
                )
            );        
    }

    //*
    //* Creates row with item cells.
    //*

    function MyMod_Item_Rows_Titles($edit,$setup,$datas,$callmethod=True)
    {
        if ($callmethod && !empty($setup[ "Row_Method" ]))
        {
            $method=$setup[ "Row_Method" ];
            return
                $this->$method
                (
                    $edit,
                    $setup,
                    $datas
                );
        }
        
        return
            array_merge
            (
                array
                (
                    "No",
                    "--",
                ),
                $this->MyMod_Items_Table_Rows_Action_Titles($setup),
                $this->MyMod_Data_Titles($datas)
            ); 
    }
}

?>