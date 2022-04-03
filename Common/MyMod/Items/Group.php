<?php


trait MyMod_Items_Group
{
    //*
    //* Creates list of data in $group. Default Basic.
    //*

    function MyMod_Items_Group_Data($group="")
    {
        if (empty($group)) { $group=$this->MyMod_Group_Default; }

        return $this->MyMod_Data_Group_Datas_Get($group,FALSE);
    }
    
    //*
    //* Creates group table with $items
    //*

    function MyMod_Items_Group_Titles($group="")
    {
        return
            $this->MyMod_Data_Titles
            (
                $this->MyMod_Items_Group_Data($group)
            );
    }

    //*
    //* Creates group table with $items
    //*

    function MyMod_Items_Group_Table($edit,$items,$group="",$options=array())
    {
        return
            $this->MyMod_Items_Table
            (
                $edit,
                $items,
                $this->MyMod_Items_Group_Data($group),
                $options
            );
    }

    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Group_Table_Html($edit,$items,$title="",$group="",$options=array())
    {
        if (empty($group)) { $group=$this->MyMod_Group_Default; }
        
        if (empty($options[ "TABLE_Options" ]))
        {
            $options[ "TABLE_Options" ]=array();
        }
        
        if (empty($title))
        {
            $title=
                $this->LanguagesObj()->Language_Group_Title_Get($this,$group,False);
        }

        if (empty($group)) { $group=$this->MyMod_Group_Default; }

        $this->ItemData();
        $this->ItemDataGroups();
        $this->Actions();

        if (!empty($title) && !is_array($title))
        {
            $title=$this->H(3,$title);
        }
        
        return
            array
            (
                $title,
                $this->Htmls_Table
                (
                    $this->MyMod_Items_Group_Titles($group),
                    $this->MyMod_Items_Group_Table($edit,$items,$group,$options),
                    $options[ "TABLE_Options"  ]
                )
            );
    }
}

?>