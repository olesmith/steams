<?php


trait MyMod_Items_Dynamic_Actions
{
    //*
    //* Returns list of dynamic actions.
    //*

    function MyMod_Item_Dynamic_Actions($group,$item=array())
    {
        $actions=array();
        foreach
            (
                $this->ItemDataGroups($group,"Dynamic")
                as $action => $def
            )
        {
            $raction=
                $this->MyMod_Item_Dynamic_Action_Allowed
                (
                    $group,$def,$item
                );            

            if (!empty($raction))
            {
                $actions[ $action ]=True;
            }
        }

        return array_keys($actions);
    }
    
    //*
    //* Finds suitable position, in where to put $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Actions_Position($group)
    {
        if (!empty($this->ItemDataGroups($group,"Actions_Position")))
        {
            return $this->ItemDataGroups($group,"Actions_Position");
        }
                
        $pos=0;
        foreach ($this->MyMod_Items_Group_Data($group) as $data)
        {
            if
                (
                    empty($this->ItemData[ $data ])
                    &&
                    empty($this->CellMethods[ $data ])
                )
            {
                $pos++;
            }
            else { break; }
        }

        return $pos;
    }
    //*
    //* Returns number of items in list of dynamic actions.
    //*

    function MyMod_Item_Dynamic_Actions_N($group,$item=array())
    {
        return
            count
            (
                $this->MyMod_Item_Dynamic_Actions($group,$item)
            );
            
    }
    
    //*
    //* Returns empty, if $action not permitted.
    //*

    function MyMod_Item_Dynamic_Action_Title($group,$def,$item=array())
    {
        $action = $def[ "Action" ];
        
        $module = $def[ "Module" ];
        $moduleobj=$module."Obj";
        

        return
            $this->$moduleobj()->MyActions_Entry_Title($action,$item);

    }
    
    //*
    //* Returns empty, if $action not permitted.
    //*

    function MyMod_Item_Dynamic_Action_Allowed($group,$def,$item=array())
    {
        $action = $def[ "Action" ];
        
        $module = $def[ "Module" ];
        $moduleobj=$module."Obj";

        $res=True;
        if (!empty($def[ "AccessMethod" ]))
        {
            $this->$moduleobj()->Actions();
            
            $this->$moduleobj()->Actions
                [ $action ][ "AccessMethod" ]=
                $def[ "AccessMethod" ];
        }
        $res=
            $this->$moduleobj()->MyAction_Allowed($action,$item);

        //Return empty, if not allowed by $module $action
        if (!$res)
        {         
            $actionhash=
                $this->$moduleobj()->Actions($action);

            if (!empty($actionhash[ "AltAction" ]))
            {
                $action=$actionhash[ "AltAction" ];
                
                $res=
                    $this->$moduleobj()->MyAction_Allowed
                    (
                        $action,$item
                    );        
            }
        }

        if (!$res) { $action=""; }

        //var_dump("$moduleobj: $action",$res);
       

        return $action;
    }
   
}

?>