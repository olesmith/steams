<?php

trait Htmls_Form_Options_OnSubmit
{
    //*
    //* function Htmls_Form_Options_Method, Parameter list:
    //*
    //* Detects form method option from args. Default is post.
    //*

    function Htmls_Form_Options_OnSubmit($id,$args,$action,$item)
    {
        $options=array();
        if
            (
                !empty($args[ "No_OnSubmit" ])
                ||
                (
                    !$this->MyMod_RAW_Is()
                    &&
                    empty($args[ "RAW" ])
                )
            )
        {
            return $options;
        }
        
        $update_elements=empty($args[ "JS_Static" ]);

        $options[ "ONSUBMIT" ]=
            "\n".
            "return Update_URL_2_Element".
            "\n(\n   '".
            join
            (
                "',\n   '",
                array
                (
                    $this->Htmls_Form_Action
                    (
                        $id,$action,$args,$item,$options
                    ),
                    $this->Htmls_Form_Options_Dest_Cell_ID
                    (
                        $id,$args,$action,$item
                    ),
                    $this->Htmls_Form_Options_ID
                    (
                        $id,$action,$args,$item,$options
                    ),
                    $this->Htmls_Form_Options_Clear_Group
                    (
                        $id,$args,$action,$item
                    ),
                    $update_elements
                )
            ).
            "'\n".
            ");";
      
             
        return $options;            
    }

    
    //*
    //* 
    //*

    function Htmls_Form_Options_Clear_Group($id,$args,$action,$item)
    {
        $clear_group="";
        if (!empty($args[ "Clear_Group" ]))
        {
            $clear_group=$args[ "Clear_Group" ];
        }

        return $clear_group;
    }
    
    //*
    //* Detects form method option from args. Default is post.
    //*

    function Htmls_Form_Options_Dest_Cell_ID($id,$args,$action,$item)
    {
        $dest_cell=
            $this->CGI_GET("Dest");

        if (!empty($args[ "Dest" ]))
        {
            $dest_cell=$args[ "Dest" ];
        }

        return $dest_cell;
    }
}

?>