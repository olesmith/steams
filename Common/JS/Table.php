<?php



trait JS_Table
{
    ##! 
    ##! 
    ##!
    
    function JS_Table_Display_Previous($n_rows,$class,$icon)
    {
        return
            $this->JS_Table_Display_Previous.
            "(this,".            
            join
            (
                ",",
                array
                (
                    intval($n_rows),
                    $this->JS_Quote($class),
                    $this->JS_Quote($icon)
                )                
            ).
            ");".
            "";
        
    }
    
}
?>