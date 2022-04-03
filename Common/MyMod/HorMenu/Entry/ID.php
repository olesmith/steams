<?php

trait MyMod_HorMenu_Entry_ID
{
    //*
    //* Generates $action entry.
    //*

    function MyMod_HorMenu_Entry_ID($action,$id,$item)
    {
        $dest=$this->Actions($action,"Dest_Action");
        
        $ids=array($this->ModuleName,$action);
        if (!empty($id))
        {
            //array_push($ids,$id);
        }
        
        
        /* if ($hide) { array_push($ids,$this->JS_CSS_Hidden); } */
        /* else       { array_push($ids,$this->JS_CSS_Visible); } */
        
        return join("_",$ids);
    }

}

?>