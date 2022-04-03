<?php

trait MyMod_Item_Rows_SGroup
{
    //*
    //* Returns SGroup of $setup[ "SData" ].
    //*

    function MyMod_Item_Rows_SGroup($edit,$setup,$item)
    {
        $datas=$this->MyMod_Item_Rows_Datas($setup);
        if (empty($setup[ "SData" ])) { return array(); }
        
        return
            array
            (
                $this->MyMod_Item_Table_Html
                (
                    $edit,$item,
                    $this->MyMod_Item_Rows_Datas($setup),
                    $plural=FALSE,$includename=True,
                    $includecompulsorymsg=FALSE,
                    $options=
                    array
                    (
                        "WIDTH" => '100%',
                    )
                )
            );
    }
   
    //*
    //* Returns SGroups of $setup[ "SGroups" ].
    //*

    function MyMod_Item_Rows_SGroups($edit,$setup,$item)
    {
        $this->MyMod_Handle_Edit_SGroups_Remaining=False;

        if (empty($setup[ "SGroups" ])) { return array(); }
        
        return
            array
            (
                $this->MyMod_Item_SGroups_Form
                (
                    $edit,
                    $item,
                    $setup[ "SGroups" ],
                    array
                    (
                        "WIDTH" => '75%',
                    )
                )
            );
    }
   
    //*
    //* Returns SGroups of $setup[ "SGroups" ].
    //*

    function MyMod_Item_Rows_EditForm($edit,$setup,$item)
    {
        $this->MyMod_Handle_Edit_SGroups_Remaining=False;
        
        if (empty($setup[ "EditForm" ])) { return array(); }
        return
            array
            (
                $this->MyMod_Handle_Edit_Form
                (
                    "",
                    $item,$edit=1,
                    $noupdate=FALSE,$datas=array(),$echo=False
                ),
            );
    }
   
}

?>