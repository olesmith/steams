<?php

trait MyMod_Group_Menu_Destination
{
    //*
    //* ID (unique) of destination cell.
    //*

    function MyMod_Groups_Menu_Destination($item,$cellid,$group,$singular=True)
    {
        return
            array
            (
                "Tag" => "DIV",
                "ID"       => $this->MyMod_Groups_Menu_Destination_ID
                (
                    $item,$group,$singular=True
                ),
                "Name"     =>  $this->MyMod_Data_Group_Name($group,True),
                "Contents" =>  $this->MyMod_Groups_Menu_Destination_Contents
                (
                    $item,$group,True
                ),
                       
                    
                "Display" => 'initial',
                "Hide"     => False,
            );
    }
    
    //*
    //* ID (unique) of destination cell.
    //*

    function MyMod_Groups_Menu_Destination_Contents($item,$group,$singular=True)
    {
        $destination=array();        
        if ($this->MyMod_Groups_Menu_Group_Active($group,$singular))
        {
            $action=
                $this->MyMod_Groups_Menu_Entry_Action($item,$group);

            if ($action!="Show" && $this->MyAction_Allowed("Edit"))
            {
                $destination=
                    $this->MyMod_Handle_Edit_SGroup_Html($item);
            }
            else
            {
                $destination=
                    $this->MyMod_Item_SGroup_Html
                    (
                        0,
                        $item,
                        $group
                    );
            }
        }
        
        return $destination;
    }
    
    //*
    //* ID (unique) of destination cell.
    //*

    function MyMod_Groups_Menu_Destination_ID($item,$group,$singular=True)
    {
        return
            join
            (
                "_",
                array
                (
                    $this->CGI_GET("Dest"),
                    $group,
                    "Dest"
                )
            );
    }
}

?>