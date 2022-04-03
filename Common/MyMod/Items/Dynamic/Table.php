<?php


trait MyMod_Items_Dynamic_Table
{
    var $MyMod_Items_Dynamic_Table_NLeading=2;
    var $MyMod_Items_Dynamic_Table_Focus_Icons_Every=0;
    var $MyMod_Items_Dynamic_Table_Focus_Start=0;
    var $MyMod_Items_Dynamic_Table_Focus_End=0;
    
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Table($edit,$items,$group,$byid=False)
    {
        $this->MyMod_Items_Dynamic_Table_Focus_Set($edit,$items,$group);
        if (empty($this->ItemDataGroups[ $group ][ "BG_Colors" ]))
        {
            $this->ItemDataGroups[ $group ][ "BG_Colors" ]=array("#e6f2ff","#ffeee6");
        }

        if (!empty($this->ItemDataGroups[ $group ][ "Sort_Method" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "Sort_Method" ];
            $items=$this->$method($items);
                
        }

        $include_id=$this->CGI_GET("Include_ID");
        if (!empty($include_id))
        {
            $include=False;
            foreach ($items as $item)
            {
                if ($include_id==$item[ "ID" ])
                {
                    $include=True;
                }
            }

            if ($include)
            {
                $item=
                    $this->Sql_Select_Hash
                    (
                        array("ID" => $include_id)
                    );

                if (!empty($item))
                {
                    array_unshift($items,$item);
                }
            }
        }
        
        $table=array();
        $n=0;
        foreach ($items as $item)
        {
            $res=
                $this->MyAction_Allowed("Show",$item);

            if (!$res) { continue; }
            
            $n++;            

            $rows=
                $this->MyMod_Item_Dynamic_Rows
                (
                    $edit,
                    $n,
                    $item,
                    $group
                );
            
            if (!$byid)
            {
                $table=
                    array_merge($table,$rows);
            }
            else
            {
                $table[ $item[ "ID" ] ]=$rows;
            }
        }

        if
            (
                !$byid
                &&
                !empty($this->ItemDataGroups[ $group ][ "SumVars" ])
            )
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyMod_Item_Dynamic_Sums_Rows($items,$group)
                );
        }

        
        return $table;
    }
        
    //*
    //* Returns Def (setup) hash associated wity $group/$action.
    //*

    function MyMod_Items_Dynamic_Action_Def($group,$action)
    {
        $actions=$this->ItemDataGroups($group,"Dynamic");

        
        return $actions[ $action ];
    }
    
    //*
    //* Number of cells in dynamic row.
    //*

    function MyMod_Item_Dynamic_Table_N($group,$item=array())
    {
        $actions=$this->MyMod_Item_Dynamic_Actions($group,$item);
        
        return
            count($this->MyMod_Items_Group_Data($group))
            +
            count(array_keys($actions))
            -
            $this->MyMod_Items_Dynamic_Table_NLeading;
    }
    
    //*
    //* Sets focus: initially all elements.
    //*

    function MyMod_Items_Dynamic_Table_Focus_Set($edit,$items,$group)
    {
        $this->MyMod_Items_Dynamic_Table_Focus_Start=0;
        $this->MyMod_Items_Dynamic_Table_Focus_End=0;

        $focus_method=$this->ItemDataGroups($group,"Focus_Set_Method");
        if (!empty($focus_method))
        {
            $this->$focus_method($edit,$items,$group);
        }
    }
}

?>