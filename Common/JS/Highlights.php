<?php



trait JS_HighLights
{
    ##! 
    ##! 
    ##!  
    
    function JS_Highlight_ByClass($classes,$color=False)
    {
        if (is_array($classes))
        {
            $classes=join(" ",$classes);
        }

        
        if ($color)
        {
            $color=$this->JS_Quote($color);
        }
        else
        {
            $color="false";
        }
        return
            $this->JS_Highlight_ByClass.
            "(this,".            
            join
            (
                ",",
                array
                (
                    $this->JS_Quote($classes),
                    $color
                )                
            ).
            ");".
            "";
    }
}
?>