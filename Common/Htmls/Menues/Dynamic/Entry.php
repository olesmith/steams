<?php

trait Htmls_Menues_Dynamic_Entry
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry($key,$is_last,$extras)
    {
        return
            $this->Htmls_Menues_Dynamic_Toggles($key,$is_last,$extras);
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_Keys()
    {
        return array_keys($this->_Entries_);
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_Key($key,$rkey="")
    {
        if (isset($rkey))
        {
            if (isset($this->_Entries_[ $key ][ $rkey ]))
            {   
                return $this->_Entries_[ $key ][ $rkey ];
            }
            
        }
        
        return $this->_Entries_[ $key ];
    }
   //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_ID($key,$post_key)
    {
        if (isset($this->_Entries_[ $key ][ "ID" ]))
        {
            $id=$this->_Entries_[ $key ][ "ID" ];
            if (is_array($id))
            {
                array_push($id,$post_key);
                $id=join("_",$id);
            }
            else
            {
                $id.="_".$post_key;
            }
            
            return $id;
        }
    }
        
    //*
    //*
    //*

    function Htmls_Menues_Dynamic_Entry_Toggle($key)
    {
        return
            $this->Htmls_Menues_Dynamic_Entry_Value
            (
                $key,"Toggle_Others"
            );
    }
    
    //*
    //* ID of destination cell, as set by _Entries_[ $key ].
    //*

    function Htmls_Menues_Dynamic_Entry_Destination_ID($key)
    {
        return
            $this->Htmls_Menues_Dynamic_Entry_Value
            (
                $key,"Destination"
            );
    }
    //*
    //*
    //*

    function Htmls_Menues_Dynamic_Entry_IDs($key,$post_key)
    {
        $id="Cell_ID";
        $id="ID";
        return
            $this->Htmls_Menues_Dynamic_Entry_Value($key,$id).
            "_".
            $post_key;
    }
    
    
    //*
    //*
    //*

    function Htmls_Menues_Dynamic_Entry_Other_IDs($key,$post_key)
    {        
        $ids=array();
        foreach ($this->Htmls_Menues_Dynamic_Entry_Keys() as $rkey)
        {
            if ($key!=$rkey)
            {
                array_push
                (
                    $ids,
                    $this->Htmls_Menues_Dynamic_Entry_ID
                    (
                        $rkey,$post_key
                    )
                );
            }
        }

        return $ids;
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_Value($key,$rkey)
    {
        if (isset($this->_Entries_[ $key ][ $rkey ]))
        {
            return $this->_Entries_[ $key ][ $rkey ];
        }

        return $this->Htmls_Menues_Dynamic_Menu($rkey);
    }
        
        
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_JS_Show($key)
    {
        return
            $this->Htmls_Menues_Dynamic_Toggle_ONCLICK($key,False);
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Entry_JS_Hide($key)
    {
        return
            $this->Htmls_Menues_Dynamic_Toggle_ONCLICK($key,True);
    }
}
    
?>