<?php



trait JS_Disables
{
    ##! 
    ##! Disable input fileds by class.
    ##!
        
    function JS_Disable_Enable_Inputs_ByClass($disable_class,$enable_class,$disabled_color='grey')
    {
        if (is_array($disable_class)) { $disable_class=join(" ",$disable_class); }
        if (is_array($enable_class))  { $enable_class=join(" ",$enable_class); }
        
        return
            array
            (
                $this->JS_Toggle_Inputs_ByClass.
                "(".
                join
                (
                    ",",
                    $this->JS_Quotes
                    (
                        array
                        (
                            $disable_class,
                            $disabled_color
                        )
                    )
                ).
                ");",
                
                $this->JS_Enable_Inputs_ByClass.
                "(".
                join
                (
                    ",",
                    $this->JS_Quotes
                    (
                        array
                        (
                            $enable_class,
                            $disabled_color
                        )
                    )
                ).
                ");"
            );
    }

    ##! 
    ##! Enable input fileds by class.
    ##!
        
    function JS_Disable_Inputs_ByClass($class,$disabled_color='grey')
    {
        if (is_array($class)) { $class=join(" ",$class); }
        
        return
            $this->JS_Disable_Inputs_ByClass.
            "(".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array($class,$disabled_color)
                )
            ).
            ");".
            "";
    }
}
?>