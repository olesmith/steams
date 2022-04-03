<?php

trait MyMod_Item_SGroups
{
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroups_Form($edit,$item,$groupsmatrix,$tableoptions=array(),$cgiupdatevar="Update",$noupdate=FALSE)
    {
        if ($this->CGI_POSTint($cgiupdatevar)==1 && $edit==1 && !$noupdate)
        {
            $item=
                $this->MyMod_Item_SGroups_Update
                (
                    $edit,
                    $item,
                    $groupsmatrix,
                    $cgiupdatevar,
                    $noupdate
                );
        }

        return
            $this->Htmls_DIV
            (
                $this->Htmls_Form
                (
                    $edit,
                    $this->ModuleName."_Edit",
                    $this->MyActions_Detect(),
                    $this-> MyMod_Item_SGroups_Tables
                    (
                        $edit,
                        $item,
                        $groupsmatrix,$tableoptions
                    ),
                    $args=array
                    (
                        "Suppress" => $this->MyMod_Handle_Edit_Form_Suppress(),
                        "Hiddens" => $this->MyMod_Handle_Edit_Form_Hiddens
                        (
                            $item,
                            $cgiupdatevar
                        ),
                        "Buttons" => $this->Buttons
                        (
                            $this->MyLanguage_GetMessage("SendButton").
                            " ".
                            $this->MyMod_ItemName()
                        )
                    ),
                    $options=array()
                ),
                #DIV options
                array("ALIGN" => 'center')
            );        
    }
    
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroups_Tables($edit,$item,$groupsmatrix,$options=array())
    {
        $table=array();
        foreach ($groupsmatrix as $groupsline)
        {
            $row=array();
            if (!is_array($groupsline)) { $groupsline=array($groupsline); }

            foreach ($groupsline as $group)
            {
                array_push
                (
                    $row,
                    $this->Htmls_Table
                    (
                        "",
                        $this->MyMod_Item_SGroup_Table($edit,$item,$group),
                        $options,array(),array(),
                        False,False
                    )

                    //$this->MyMod_Item_SGroup_Html($edit,$item,$group)
                );  
            }

            array_push($table,$row);
        }

        return $table;
    }
    
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroups_Row($edit,$item,$sgroups,$options=array())
    {
        $table=array();

        foreach ($sgroups as $sgroup)
        {
            $table=
                array_map
                (
                    null, //callback
                    $table,
                    $this->Htmls_Table
                    (
                        "",
                        $this->MyMod_Item_SGroup_Table($edit,$item,$sgroup),
                        $options,array(),array(),
                        False,False
                    )
                );
        }

        return
            $this->Htmls_Table
            (
                "",
                $table
            );
    }
    
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroups_Update($edit,$item,$groupsmatrix,$cgiupdatevar,$noupdate)
    {
        if ($this->CGI_POSTint($cgiupdatevar)==1 && $edit==1 && !$noupdate)
        {
            $item=$this->MyMod_Item_Test($item);
            $item=$this->MyMod_Item_Update_CGI($item);
        }

        return $item;
    }
}

?>