<?php

class Language_Messages_MTimes extends Language_Messages_Access
{
    function Language_Message_MTime_Key($language="")
    {
        if (empty($language)) { return "MTime"; }

        return "MTime_".$language;
    }
    
    function Language_Message_MTime_Datas()
    {
        $data="MTime";
        $datas=array();
        foreach ($this->Language_Keys() as $language)
        {
            array_push
            (
                $datas,
                $this->Language_Message_MTime_Key($language)
            );
        }

        return $datas;
    }

    
    function PostUpdateActions($olditem,&$item,&$updatedatas)
    {
        foreach ($this->Language_Keys() as $language)
        {
            if (count(  preg_grep('/_'.$language.'/',$updatedatas)   )>0)
            {
                $mkey=$this->Language_Message_MTime_Key($language);
                $item[ $mkey ]=time();
                array_push($updatedatas,$mkey);
            }
        }
    }
}

?>