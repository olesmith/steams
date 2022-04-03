<?php


trait MyMod_Handle_Import_Cells
{
    //*
    //* Generates item status cell.
    //*

    function MyMod_Handle_Import_Item_Status_Cell($item)
    {
        return $item[ "Status_Message" ];
    }
    
    //*
    //* Generates select all $items checkbox cell.
    //*

    function MyMod_Handle_Import_Items_Add_Cell()
    {
        return
            $this->Html_Input_CheckBox_Field
            (
                "Register_All",
                1,
                FALSE,
                $disabled=FALSE,
                $options=array
                (
                    "ID" => "Register_All",
                    "ONCHANGE" => $this->JS_CheckBox_Group_Set_All
                    (
                        "Register_All",
                        "Add_Cell",
                        'initial'
                    )
                )
            );
    }
    
    //*
    //* Item checkbox cell cgi name.
    //*

    function MyMod_Handle_Import_Item_Add_Cell_CGI_Name($item)
    {
        return $item[ "No" ]."_Register";
    }
    
    //*
    //* Item checkbox cell cgi value.
    //*

    function MyMod_Handle_Import_Item_Add_Cell_CGI_Value($item)
    {
        return
            $this->CGI_POST
            (
                $this->MyMod_Handle_Import_Item_Add_Cell_CGI_Name($item)
            );
    }
    
    //*
    //* Item checkbox cell checked or not from cgi.
    //*

    function MyMod_Handle_Import_Item_Add_Cell_Selected($item)
    {
        $res=False;
        if ($this->MyMod_Handle_Import_Item_Add_Cell_CGI_Value($item)==1)
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* Generates item checkbox cell.
    //*

    function MyMod_Handle_Import_Item_Add_Cell(&$item)
    {
        if ($item[ "Status" ])
        {
            return
                $this->Html_Input_CheckBox_Field
                (
                    $this->MyMod_Handle_Import_Item_Add_Cell_CGI_Name($item),
                    1,
                    $this->MyMod_Handle_Import_Item_Add_Cell_Selected($item),
                    $disabled=FALSE,
                    $options=array
                    (
                        "TABINDEX" => 1,
                        "CLASS" => "Add_Cell",
                    )
                );
        }


        return "-";
    }
}
?>