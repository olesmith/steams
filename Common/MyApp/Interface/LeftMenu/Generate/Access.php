<?php


trait MyApp_Interface_LeftMenu_Generate_Access
{
    //*
    //* Access to LeftMenus (titles). Consult Message permissions.
    //*

    function MyApp_Interface_LeftMenu_Generate_Access_Has($submenuname,$submenu)
    {
        $perms=
            $this->LanguagesObj()->Permissions_Get
            (
                $this->LanguagesObj()->Language_LeftMenu_Type,
                preg_replace('/^\d+_/',"",$submenuname),
                $submenu
            );
        
        if (empty($perms))
        {
            var_dump("SubMenu Permissions not found:",$submenu,$perms);
        }

        $res=False;
        if (!empty($perms))
        {
            $res=$this->MyMod_Access_HashAccess($perms,array(1,2));
            if ($res && !empty($submenu[ "AccessMethod" ]))
            {
                $perms[ "AccessMethod" ]=$submenu[ "AccessMethod" ];
                $res=
                    $this->MyHash_Access_Method_Apply
                    (
                        $submenuname,
                        $perms,
                        array()
                    );
            }
        }
        return $this->MyMod_Access_HashAccess($perms,1);
    }
    
    //*
    //* Access to menu items. Consult Message permissions.
    //*

    function MyApp_Interface_LeftMenu_Generate_Access_Item_Has($submenuname,$submenuitem)
    {
        if (!is_array($submenuitem)) { return False; }
        
        $perms=
            $this->LanguagesObj()->Permissions_Get
            (
                $this->LanguagesObj()->Language_MenuItem_Type,
                preg_replace('/^\d+_/',"",$submenuname),
                $submenuitem
            );

        if (empty($perms))
        {
            var_dump("MenuItem Permissions not found:",$submenuname,$perms);
        }
         
        $res=False;
        if (!empty($perms))
        {
            $res=$this->MyMod_Access_HashAccess($perms,array(1,2));
            if ($res && !empty($submenuitem[ "AccessMethod" ]))
            {
                $perms[ "AccessMethod" ]=$submenuitem[ "AccessMethod" ];
                $res=
                    $this->MyHash_Access_Method_Apply
                    (
                        $submenuname,
                        $perms,
                        array()
                    );
            }
        }
        
        return $res;
    }
    
}

?>