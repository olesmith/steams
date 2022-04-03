<?php

include_once("Edit/SGroups.php");
include_once("Edit/Html.php");
include_once("Edit/Form.php");
include_once("Edit/Table.php");
include_once("Edit/Info.php");

trait MyMod_Handle_Edit
{
    use
        MyMod_Handle_Edit_SGroups,
        MyMod_Handle_Edit_Html,
        MyMod_Handle_Edit_Form,
        MyMod_Handle_Edit_Table,
        MyMod_Handle_Edit_Info;

    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        $this->Htmls_Echo
        (
            $this->MyMod_Handle_Edit_Basic()
        );

        return;
    }
    
    //*
    //* Handles basic Edit - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Edit_Basic($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }

        return
            $this->MyMod_Handle_Edit_Html
            (
                $item,
                array
                (
                    $this->MyMod_ItemName(":"),
                    $this->MyMod_Item_Name_Get($item),
                )
            );
    }

    //*
    //* Handles basic Edit - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Edit_Html($item,$title)
    {
        $group=
            $this->MyMod_Data_Group_Name
            (
                $this->MyMod_Handle_Show_SGroup_CGI(),
                True
            );
        
        $html=array();
        if (empty($this->CGI_GET("NoGroupMenu")))
        {
            $html=
                array_merge
                (
                    $html,
                    array
                    (
                        $this->Htmls_H
                        (
                            3,
                            $title
                        ),
                        $this->MyMod_Groups_Menu
                        (
                            $this->MyMod_Handle_Show_SGroup_CGI(),
                            $item,
                            $this->CGI_GET("Dest"),
                            $singular=True
                        )
                    )
                );
        }
        elseif (!empty($group))
        {
            $html=
                array_merge
                (
                    $html,
                    $this->MyMod_Handle_Edit_SGroup_Html($item)
                );
        }

        return $html;        
    }

    
    //*
    //* Handles basic Edit - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Edit_SGroup_Html($item,$group="")
    {
        if (empty($group)) { $group=$this->MyMod_Handle_Show_SGroup_CGI(); }
        
        $edit=0;
        if ($this->MyAction_Allowed("Edit",$item)) { $edit=1; }

        return
            $this->MyMod_Handle_Edit_Form
            (
                //Detect Group name from CGI
                $this->MyMod_Data_Group_Name
                (
                    $group,
                    True
                ),
                $item,
                $edit,
                $noupdate=FALSE,
                $this->MyMod_Item_Group_Table_Datas
                (
                    $group
                ),
                $echo=False,
                $extrarows=array(),$formurl=NULL,
                $this->Htmls_Buttons
                (
                    $this->MyLanguage_GetMessage("SendButton").
                    " ".
                    $this->MyMod_ItemName()
                )
            );
    }
}

?>