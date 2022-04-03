<?php



trait MyMod_Item_Children
{
    //*
    //* Creates item data cell.
    //*

    function MyMod_Item_Children_Has($moduleobjs,$where,$tables=array())
    {
        if (!is_array($moduleobjs)) { $moduleobjs=array($moduleobjs); }

        $res=FALSE;
        foreach ($moduleobjs as $moduleobj)
        {
            $table="";
            if (!empty($tables[ $moduleobj ]))
            {
                $table=$tables[ $moduleobj ];
            }
            
            $n=$this->$moduleobj()->Sql_Select_NEntries($where,$table);
            if ($n>0)
            {
                $res=TRUE;
                break;
            }
        }

        return $res;
    }    
}

?>