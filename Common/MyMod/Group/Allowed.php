<?php

trait MyMod_Group_Allowed
{
    //* Returns permitted data groups, based on $this->LoginTyoe or $this->Profile.
    //* Calls MyMod_Group_Allowed forach item in ItemDataGroups.
    //*
    
    function MyMod_Groups_Allowed_Get($plural=TRUE)
    {
        $groups=array();
        
        if ($plural) { $groups=$this->ItemDataGroups; }
        else         { $groups=$this->ItemDataSGroups; }

        $rgroups=array();
        foreach (array_keys($groups) as $group)
        {
            if ($this->MyMod_Group_Allowed($groups[ $group ]))
            {
                $rgroups[ $group ]=$groups[ $group ];
            }
        }

        return $rgroups;
    }
    
    //*
    //* Chekcs access to data group.
    //*

    function MyMod_Group_Allowed($groupdef,$item=array(),$values=array(1,2),$profile="",$logintype="")
    {
        $perms=array();
        if (empty($groupdef[ "__Name__" ]))
        {
            #var_dump("Warning! No Group def __Name__ key:",$groupdef);
            $perms=$groupdef;
            $groupdef[ "__Name__" ]='undef';
        }
        else
        {
            $perms=
                $this->MyMod_Group_Permissions_Get
                (
                    $groupdef[ "__Name__" ],
                    $groupdef[ "Singular" ]
                );
        }

        $res=False;
        if (!empty($perms))
        {
            $res=$this->MyMod_Access_HashAccess($perms,array(1,2));
            if ($res && !empty($groupdef[ "AccessMethod" ]))
            {
                $perms[ "AccessMethod" ]=$groupdef[ "AccessMethod" ];
                $res=
                    $this->MyHash_Access_Method_Apply
                    (
                        $groupdef[ "__Name__" ],
                        $perms,
                        $item
                    );
            }
        }

        return $res;
    }
}

?>