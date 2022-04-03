<?php

trait MyMod_Items_Dynamic_ID
{


    //*
    //* All  IDs
    //*

    function MyMod_Item_Dynamic_Title_Menu_Row_ID($group)
    {
        return
            $this->MyMod_Item_Dynamic_Entry_ID
            (
                array(),
                $group,
                "Action_Row"
            );
    }
    
    //*
    //* Entry ID
    //*

    function MyMod_Item_Dynamic_Entry_ID($item,$group,$action)
    {
        $did=
            $this->MyMod_Item_Dynamic_Destination_Get_ID
            (
                $action,
                $item
            );

        return $did;
        
        $comps=array($this->ModuleName,$group,$action);
        
        if (!empty($item[ "ID" ]))
        {
            array_push($comps,$item[ "ID" ]);
        }
        
        $cgis=$this->ItemDataGroups($group,"CGIs");
        if (is_array($cgis))
        {
            foreach ($cgis as $cgi)
            {
                $id=$this->CGI_GET($cgi);
                if (!empty($id)) { array_push($comps,$id); }
            }
        }

        var_dump(join("_",$comps).": $did");
        return join("_",$comps);
            
    }
    
    //*
    //* One $group menu $action entry.
    //*

    function MyMod_Item_Dynamic_Title_Entry_Action_ID($group,$def,$action)
    {
        return
            $this->MyMod_Item_Dynamic_Entry_ID
            (
                array(),
                $group,
                $action
            );
    }
    
    
   //*
    //* ID for the destination ROW (TR)
    //*

    function MyMod_Item_Dynamic_Destination_Row_ID($item=array())
    {        
        return
            $this->MyMod_Item_Dynamic_Destination_Get_ID
            (
                "Dest_Row",
                $item
            );
    }
    
    //*
    //* ID for the destination $base type;
    //*

    function MyMod_Item_Dynamic_Destination_Get_ID($base,$item=array())
    {
        $dest=$this->ModuleName;
        if (!empty($_GET[ "Dest" ]))
        {
            $dest=$_GET[ "Dest" ];
        }
        $comps=
            array
            (
                $dest,
            );
        
        if ($base)
        {
            array_push($comps,$base);
        }
        
        if (!empty($item[ "ID" ]))
        {
            array_push($comps,$item[ "ID" ]);
        }

        //var_dump($_GET[ "Dest" ],join("_",$comps));
        return join("_",$comps);
    }
    
    //*
    //* Destination ID
    //*

    function MyMod_Item_Dynamic_Destination_Cell_ID($item,$group,$action)
    {
        return
            $this->MyMod_Item_Dynamic_Destination_Get_ID
            (
                "Dest",
                $item
            ).
            "_".
            $action.
            "_".
            $group.
            "";
    }
}

?>