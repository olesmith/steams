<?php


trait MyMod_Item_Rows_Modules
{
    //*
    //*
    //*

    function MyMod_Item_Rows_Module_CGI_Key()
    {
        return "Module";
    }
    
    //*
    //*
    //*

    function MyMod_Item_Rows_Module_CGI_Value($setup)
    {
        $value=$this->CGI_GET( $this->MyMod_Item_Rows_Module_CGI_Key() );
        if (empty($value) && !empty($setup[ "Modules" ][0]))
        {
            $value=$setup[ "Modules" ][0];
        }

        return $value;
    }
    
    //*
    //*
    //*

    function MyMod_Item_Rows_Modules_Menu($edit,$setup,$item)
    {
        if (count($setup[ "Modules" ])<=1) { return array(); }

        $args=$this->CGI_URI2Hash();
        $args[ $setup[ "GET" ] ]=$item[ "ID" ];

        $cgikey=$this->MyMod_Item_Rows_Module_CGI_Key();
        $cgivalue=$this->MyMod_Item_Rows_Module_CGI_Value($setup);
        
        $menu=array();
        foreach ($setup[ "Modules" ] as $module)
        {
            $args[ $cgikey ]=$module;
            array_push
            (
                $menu,
                $this->MyMod_Item_Rows_Module_Menu_Item
                (
                    $edit,
                    $setup,
                    $item,
                    $module
                )
            );
        }

        return
            array
            (
                $this->Htmls_Menu_Horisontal($menu)
            );
    }
    
    //*
    //*
    //*

    function MyMod_Item_Rows_Module_Menu_Item($edit,$setup,$item,$module)
    {
        $args=$this->CGI_URI2Hash();
        $args[ $setup[ "GET" ] ]=$item[ "ID" ];

        $cgikey=$this->MyMod_Item_Rows_Module_CGI_Key();
        $cgivalue=$this->MyMod_Item_Rows_Module_CGI_Value($setup);
        
        $args[ $cgikey ]=$module;

        $moduleobj=$this->ApplicationObj()->MyApp_Module_GetObject($module);
        
        $href=$moduleobj->MyMod_ItemsName();
        if ($cgivalue!=$module)
        {
            $href=
                $this->Htmls_Href
                (
                    "?".$this->CGI_Hash2URI($args),
                    $module,
                    $href,
                    $class="odd",
                    $rargs=array(),
                    $options=array()
                );
        }

        return $href;
    }
    //*
    //*
    //*

    function MyMod_Item_Rows_Module_Setup($module)
    {
        return $this->ApplicationObj()->MyApp_Handle_Tables_Modules[ $module ];
    }
    
    //*
    //*
    //*

    function MyMod_Item_Rows_Module_Rows($edit,$setup,$item)
    {
         $module=$this->MyMod_Item_Rows_Module_CGI_Value($setup);
        
         if (empty($module)) { return array(); }

         $moduleobj=$this->ApplicationObj()->MyApp_Module_GetObject($module);
         $rsetup=$this->MyMod_Item_Rows_Module_Setup($module);

         $where=array();
         if (!empty($rsetup[ "KEY" ]))
         {
             $key=$rsetup[ "KEY" ];
             $cgikey=$setup[ "GET" ];

             $where=
                 array
                 (
                     $cgikey  => $item[ $key ],
                 );
         }

         return
             $moduleobj->MyMod_Items_Rows_Form
             (
                 $edit,
                 $rsetup,
                 $where
             );
    }
}

?>