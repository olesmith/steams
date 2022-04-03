<?php

trait MyMod_Items_Dynamic_Paging_Entry
{
    //*
    //* Dynamic items page menu item.
    //*

    function MyMod_Items_Dynamic_Paging_Entry($page)
    {
        return
            array
            (
                "Tag" => "SPAN",
                "Hide" => False,
                
                "ID" => $this->MyMod_Items_Dynamic_Paging_Entry_Cell_ID($page),
                
                "Name" =>
                $this->MyMod_Items_Dynamic_Paging_Entry_Name($page),
                "Title" =>
                $this->MyMod_Items_Dynamic_Paging_Entry_Title($page),
                
                "Onclick" =>
                $this->MyMod_Items_Dynamic_Paging_Entry_JS($page),
                
                "Destination" =>
                $this->MyMod_Items_Dynamic_Paging_Destination_Cell_ID($page),
                
                "Class" => 'dynbutton',
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Entry_JS($page)
    {
        return
            array
            (
                $this->JS_Load_URL_2_Element
                (
                    $this->MyMod_Items_Dynamic_Paging_Entry_URL
                    (
                        $page
                    ),
                    $this->MyMod_Items_Dynamic_Paging_Destination_Cell_ID($page)
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Entry_URL($page)
    {
        $url=
            array_merge
            (
                $this->MyMod_Search_Hiddens_Hash(),
                $this->CGI_URI2Hash
                (
                    "",
                    array
                    (
                        "Page" => $page,
                        "NoPageMenu" => 1,
                        "NoSearch" => 1,
                    )
                ),
                array
                (
                    "Dest" => $this->MyMod_Items_Dynamic_Paging_Destination_Cell_ID
                    (
                        $page,$key="Dest"
                    )
                )
            );

        foreach (array("Menu","Search") as $key)
        {
            if (isset($url[ $key ]))
            {
                unset($url[ $key ]);
            }
        }


        return $url;
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Entry_Cell_ID($page)
    {
        return
            //$this->ModuleName."_Search_".$page;
            $this->CGI_GET("Dest")."_".$page;
        
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Entry_Name($page)
    {
        return $page;
        
    }
    
    //*
    //* Dynamic items page menu item.
    //*

    function MyMod_Items_Dynamic_Paging_Entry_Title($page)
    {
        $nitemspp=$this->MyMod_Search_CGI_Paging_NItems_PP_Value();
        $nitems=$nitemspp;
        
        if ($page==$this->MyMod_Paging_N)
        {
            $nitems=$this->NumberOfItems-($this->MyMod_Paging_N-1)*$nitemspp;
        }
        
        return
            join
            (
                "\n",
                array
                (
                    join
                    (
                        " ",
                        array
                        (
                            $this->MyLanguage_GetMessage("Page"),
                            $page,
                        )
                    ),

                    "(".
                    join
                    (
                        " ",
                        array
                        (
                            $nitems,
                            $this->MyMod_ItemsName(),
                            $this->MyLanguage_GetMessage("of"),
                            $this->NumberOfItems,
                        )
                    ).
                    ")",
                )
            );
        
    }

}

?>