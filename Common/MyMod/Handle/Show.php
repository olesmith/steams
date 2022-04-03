<?php

trait MyMod_Handle_Show
{
    //*
    //* function MyMod_Handle_Show, Parameter list: 
    //*
    //* Handles module object Show.
    //*

    function MyMod_Handle_Show($title="")
    {
        if ($this->CGI_GETOrPOSTint("LatexDoc")>0)
        {
            $this->MyMod_Handle_Print();
        }

        if (empty($title))
        {
            $title=
                $this->GetRealNameKey($this->Actions[ "Show" ]).
                " ".
                $this->MyMod_ItemName();
        }

        if (count($this->ItemHash)>0)
        {
            return
                $this->MyMod_Handle_Show_Basic
                (
                    0,
                    $title,
                    $this->ItemHash
                );
        }
        else
        {
            $this->Warn
            (
                $this->ItemName." not found!",
                $this->ModuleName,
                $this->ItemHash
            );
        }
    }
    
    //*
    //* Handles basic Show - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Show_Basic($edit,$title="",$item=array(),$echo=True)
    {
        if (empty($item)) { $item=$this->ItemHash; }
        

        $html=
            $this->MyMod_Handle_Show_Html
            (
                $edit,$item
            );

        {
            $this->Htmls_Echo
            (
                $html
            );

            $html=array();
        }

        return $html;
        
    }



    //*
    //* Generates: Or the grpouips menu or the group table.
    //*

    function MyMod_Handle_Show_Html($edit,$item,$singular=True)
    {
        $group=
            $this->MyMod_Handle_Show_SGroup_CGI();
        
        if (empty($title))
        {
            $title=$this->MyMod_Item_Name_Get($item);
        }

        $html=array();
        if (empty($this->CGI_GET("NoGroupMenu")))
        {
            $html=
                $this->MyMod_Groups_Menu
                (
                    $group,
                    $item,
                    $this->CGI_GET("Dest"),
                    $singular=True
                );
        }


        elseif //active group
            (
                $this->MyMod_Groups_Menu_Group_Active
                (
                    $group,$singular
                )
            )
        {
            $html=
                array_merge
                (
                    $html,
                    $this->MyMod_Item_SGroup_Html
                    (
                        $edit,
                        $item,
                        $group
                    )
                );
        }

        return
            $this->Htmls_Frame
            (
                array
                (
                    $this->Htmls_H
                    (
                        3,
                        $title
                    ),
                    $html,
                )
            );
    }





    //*
    //* Handles basic Show - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Show_SGroup_Default()
    {
        foreach (array("Basic","Common") as $group)
        {
            if (!empty($this->ItemDataSGroups($group)))
            {
                return $group;
            }
        }

        return $this->MyMod_SGroup_Default;
    }
    
    //*
    //* Handles basic Show - one SGroup, in CGI GroupName.
    //*

    function MyMod_Handle_Show_SGroup_CGI()
    {
        $group=$this->CGI_GET("GroupName");
        if (empty($group))
        {
            $group=$this->MyMod_Handle_Show_SGroup_Default();
        }
       

        return $group;
    }
}

?>