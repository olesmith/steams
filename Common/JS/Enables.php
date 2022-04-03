<?php



trait JS_Enables
{
    ##! 
    ##! Enable input fileds by class.
    ##!
        
    function JS_Enable_Inputs_ByClass($class,$disabled_color='grey')
    {
        if (is_array($class)) { $class=join(" ",$class); }
        
        return
            $this->JS_Enable_Inputs_ByClass.
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

    ##! 
    ##! Load Select field based on other.
    ##!
        
    function JS_Inputs_ByClasses_Enable_Disable($class,$classes,$disabled_color='grey')
    {
        return
            $this->JS_Inputs_ByClasses_Enable_Disable.
            "(".
            join
            (
                ",",
                array
                (
                    $this->JS_Quote
                    (
                        $class
                    ),
                    $this->JS_Array
                    (
                        $classes
                    ),
                    
                    $this->JS_Quote
                    (
                        $disabled_color
                    ),
                )
            ).
            ");".
            "";        
    }
}
?>