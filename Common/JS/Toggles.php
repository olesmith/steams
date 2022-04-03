<?php



trait JS_Toggles
{    
    ##! 
    ##! JS code toggling elements.
    ##!
        
    function JS_Toggle_Element_By_ID($ids,$display='initial')
    {
        if (!is_array($ids))
        {
            $ids=array($ids);
        }
        
        $ids=preg_grep('/\S/',$ids);
        
        return
            $this->JS_Toggle_Element_By_ID.
            "(".
                $this->JS_Array($ids).
            ",".
            $this->JS_Quote($display).
            ");";
    }
    
    ##! 
    ##! JS code toggling elements.
    ##!
        
    function JS_Toggle_Elements_By_Class($class,$display='initial',$tagname="")
    {
        if (is_array($class))
        {
            $class=join(" ",$class);
        }
        
        return
            $this->JS_Toggle_Elements_By_Class.
            "(".
            join
            (
                ",",
                array
                (
                    $this->JS_Quote($class),
                    $this->JS_Quote($display),
                    $this->JS_Quote($tagname)
                )
            ).
            ");\n";
    }
    
    ##! 
    ##! Toggle input fileds by class.
    ##!
        
    function JS_Toggle_Inputs_ByClass($class,$disabled_color='grey')
    {
        if (is_array($class)) { $class=join(" ",$class); }
        
        return
            $this->JS_Toggle_Inputs_ByClass.
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
    ##! Toggle element colors.
    ##!  
    
    function JS_Toggle_Colors($color1,$color2)
    {        
        return
            $this->JS_Toggle_Colors.
            "(".            
            "this".
            ",".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $color1,$color2
                    )
                )                
            ).
            ");".
            "";
    }
}
?>