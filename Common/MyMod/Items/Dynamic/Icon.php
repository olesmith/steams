<?php


trait MyMod_Items_Dynamic_Icon
{   
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_Icon($def,$item=array())
    {
        $icon="";
        if (!empty($def[ "Icon_Method" ]))
        {
            $method=$def[ "Icon_Method"  ];

            $icon=$this->$method($item);
            //var_dump($icon);
            return $this->$method($item);
        }
        elseif (!empty($def[ "Icon" ]))
        {
            $icon=$def[ "Icon" ];
        }
        else
        {
            $module = $def[ "Module" ];
            $moduleobj=$module."Obj";
            
            $icon=
                $this->$moduleobj()->Actions
                (
                    $def[ "Action" ],
                    "Icon"
                );          
        }
        
        $icon=
            $this->MyMod_Interface_Icon_Retrieve($icon);

        return $icon;
    }
    
}

?>