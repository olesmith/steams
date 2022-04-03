<?php


trait MyMod_Item_Rows_Links
{
    //*
    //* Creates row with open/close item link.
    //*

    function MyMod_Item_Rows_Link($setup,$item)
    {        
        $cgikey=$setup[ "KEY" ];
        if (empty($cgikey)) { return ""; }

        return
            $this->MyMod_Interface_Icon_Link
            (
                $this->MyMod_Item_Rows_Link_Args($setup,$item),
                $this->MyMod_Item_Rows_Link_Icon($setup,$item),
                $this->MyLanguage_GetMessage("Details"),
                $class="odd",
                $options=array
                (
                    "ID" => $this->ModuleName."_".$item[ "ID" ],
                ),
                $iconoptions=array(),
                1
            );
    }

    //*
    //* 
    //*

    function MyMod_Item_Rows_Link_Icon($setup,$item)
    {
        $icon="plus";
        if ($this->MyMod_Item_Rows_Details_Should($setup,$item))
        {
            $icon="minus";
        }

        return "fas fa-".$icon;
    }

    //*
    //* 
    //*

    function MyMod_Item_Rows_Link_Args($setup,$item)
    {
        $cgikey=$setup[ "GET" ];

        $args=$this->CGI_URI2Hash();
        foreach ($setup[ "Unset" ] as $key)
        {
            unset($args[ $key ]);
        }

        #unset($args[ "Module" ]);
        if ($this->MyMod_Item_Rows_Details_Should($setup,$item))
        {
            unset($args[ $cgikey ]);
        }
        else
        {
            $args[ $cgikey ]=$item[ "ID" ];
        }

        $args[ "Anchor" ]=$this->ModuleName."_".$item[ "ID" ];
        
        return $args;
    }

    
}

?>