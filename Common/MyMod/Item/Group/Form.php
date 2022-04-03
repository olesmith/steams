<?php


trait MyMod_Item_Group_Form
{
    //*
    //* Handles item Group tables form.
    //*

    function MyMod_Item_Group_Tables_Form($edit,$id,$updatekey,$groupdefs,$item,$mayupdate=TRUE,$plural=FALSE,$precgikey="",$buttons="")
    {
        if ($edit==1)
        {
            $edit=$this->MyMod_Item_SGroups_Edit_Should($groupdefs);
        }
        
        if ($edit==1 && $mayupdate && $this->CGI_POSTint($updatekey)==1)
        {
            $this->MyMod_Item_Groups_Table_Update
            (
                $updatekey,$groupdefs,$item,$plural,$precgikey
            );
        }

        return
            $this->Htmls_Form
            (
                $edit,
                $id,
                $action="",
                #Content
                array
                (
                    $this->MyMod_Item_Group_Tables_Html($edit,$groupdefs,$item,$buttons,$plural),
                    $this->MakeHidden($updatekey,1)
                )
            );
    }
    
    //*
    //* Handles item Group tables form.
    //*

    function MyMod_Item_Group_Table_Form($edit,$updatekey,$group,&$item,$mayupdate=TRUE,$plural=FALSE,$precgikey="",$buttons="",$title="",$prerows=array(),$postrows=array(),$precols=array(),$postcols=array())
    {
        $groupdef=$this->ItemDataSGroups($group);
        if (empty($buttons)) { $buttons=$this->Buttons(); }

        $this->Datas_Included=array();

        if ($edit==1)
        {
            $edit=$this->MyMod_Group_Allowed($groupdef);
        }

        if
            (
                $edit==1
                &&
                $mayupdate
                &&
                $this->CGI_POSTint($updatekey)==1
            )
        {
            $this->MyMod_Item_Group_Table_Update
            (
                $updatekey,
                $groupdef,
                $item,
                $plural,$precgikey
            );
        }


        return
            array
            (
                $this->Htmls_Form
                (
                    $edit,
                    join
                    (
                        "_",
                        array
                        (
                            $this->ModuleName,
                            $group,
                            $item[ "ID" ],
                        )
                    ),
                    $action="",
                    $contents=array
                    (
                        $this->MyMod_Item_Group_Table_HTML
                        (
                            $edit,
                            $group,
                            $item,
                            $plural,
                            $precgikey,
                            $options=array(),
                            $title,
                            $prerows,
                            $postrows,
                            $precols,
                            $postcols
                        )
                    ),
                    $args=array
                    (
                        "Buttons" => $buttons,
                        "Hiddens" => array
                        (
                            $updatekey => 1,
                        ),
                    )
                )
            );
    }

}

?>
