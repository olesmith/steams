<?php

trait MyMod_Handle_Edit_SGroups
{
    var $MyMod_Handle_Edit_SGroups_Remaining=True;
    
    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Get()
    {
        return
            $this->MyHash_Order_Hashes_Keys
            (
                $this->ItemDataSGroups,
                "Order",
                "Visible"
            );
    }

    
    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Matrix_Get($item,$ngroupsperline=2)
    {
        $groups=$this->MyMod_Handle_Edit_SGroups_Get();
        $sgroups=array();
        $row=array();
        foreach ($groups as $group)
        {
            $access=$this->MyMod_Group_Allowed($this->ItemDataSGroups[ $group ],$item);
            if (!$access) { continue; }
            
            if (!empty($this->ItemDataSGroups[ $group ][ "Single" ]))
            {
                if (count($row)>0)
                {
                    array_push($sgroups,$row);
                    $row=array();
                }
                
                array_push($sgroups,array($group));
                continue;
            }

            array_push($row,$group);

            if (count($row)==$ngroupsperline)
            {
                array_push($sgroups,$row);
                $row=array();
            }
        }

        if (count($row)>0)
        {
            array_push($sgroups,$row);
        }

        return $sgroups;
    }

    
    //*
    //* Returns 1 if sgroup is editable.
    //*

    function MyMod_Handle_Edit_SGroup_Edit($edit,$group,$item)
    {
        $redit=0;
        if ($edit==1 && $this->MyMod_Item_SGroup_Editable($group,$item))
        {
            $redit=1;
        }

        return $redit;
    }
    
    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Tables($edit,$item)
    {
        $table=array();
        foreach ($this->MyMod_Handle_Edit_SGroups_Matrix_Get($item) as $grouprow)
        {
            $row=array();
            foreach ($grouprow as $group)
            {
                array_push
                (
                    $row,
                    $this->MyMod_Item_SGroup_Html_Row
                    (
                        $this->MyMod_Handle_Edit_SGroup_Edit($edit,$group,$item),
                        $item,
                        $group
                    )
                );
            }

            array_push($table,$row);
            if ($edit==1)
            {
                array_push($table,$this->Buttons());
            }
        }

        if
            (
                $this->Profile()=="Admin"
                &&
                count($datas=$this->MyMod_Handle_Edit_SGroups_Remaining_Data($edit,$item))>0
                &&
                $this->MyMod_Handle_Edit_SGroups_Remaining
            )
        {
            array_push
            (
                $table,
                array
                (
                    $this->H
                    (
                        3,
                        $this->MyLanguage_GetMessage("Remaining")
                    ),
                ),
                array
                (
                    $this->MyMod_Item_Table_Html
                    (
                        $edit,
                        $item,
                        $datas
                    )
                )
            );
        }
        
        return $table;
    }
    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Remaining_Data($edit,$item)
    {
        $datas=array();
        foreach ($this->MyMod_Handle_Edit_SGroups_Matrix_Get($item) as $grouprow)
        {
            foreach ($grouprow as $group)
            {
                foreach ($this->MyMod_Item_SGroup_Datas_Get($group,$item) as $data)
                {
                    $datas[ $data ]=True;
                }
            }
        }

        $rdatas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (preg_match('/^(ID|[ACM]Time)$/',$data)) { continue; }
            
            if
                (
                    empty($datas[ $data ])
                    &&
                    $this->MyMod_Data_Access($data,$item)>=1
                )
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }
}

?>