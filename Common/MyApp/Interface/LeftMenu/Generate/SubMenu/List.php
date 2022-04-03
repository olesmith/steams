<?php


trait MyApp_Interface_LeftMenu_Generate_SubMenu_List
{
    //*
    //* Generates (returns) the Left menu list.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_List($submenu,$item=array(),$postlist=array(),$call_method=True,$debug=False)
    {
        $list=array();
        if ($call_method && isset($submenu[ "Method" ]))
        {
            $method=$submenu[ "Method" ];

            $list=
                $this->$method
                (
                    $submenu,
                    $item,
                    $postlist
                );

            if (!is_array($list)) { $list=array($list); }
        }
        else
        {
            $menuids=array_keys($submenu);
            sort($menuids);

            
            foreach ($menuids as $menuid)
            {                
                if
                    (
                        $this->MyApp_Interface_LeftMenu_Generate_Access_Item_Has
                        (
                            $menuid,
                            $submenu[ $menuid ]
                        )
                    )
                { 
                    array_push
                    (
                        $list,
                        $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item
                        (
                            $menuid,
                            $submenu[ $menuid ],
                            $item
                        )
                    );
                }
            }
        }

        if (empty($list)) { return array(); }


        return
           $this->Htmls_List
            (
                array_merge($list,$postlist),
                array
                (
                    "CLASS" => 'menu-list',
                ),
                array
                (
                    "CLASS" => '',
                )
            );
    }
}

?>