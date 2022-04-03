<?php


trait MyMod_Item_Group_Latex
{
    //*
    //* Create item Group tables latex version.
    //*

    function MyMod_Item_Groups_Tables_Latex($groupdefs,$item,$options)
    {
        $table=array();
        foreach ($groupdefs as $groupdef)
        {
            foreach ($groupdef as $group => $edit)
            {
                $res=
                    $this->MyMod_Group_Allowed
                    (
                        $this->ItemDataSGroups[ $group ],
                        $item
                    );

                

                if ($res)
                {
                    $gtable=$this->MyMod_Item_Group_Table($edit,$group,$item);
                    if (!is_array($gtable)) { $gtable=array($gtable); }
                    
                    array_merge($table,$gtable);
                }
            }
        }
        
        return
            $this->Latex_Table
            (
                "",
                $table,
                $options
            ).
            "";
    }
}

?>