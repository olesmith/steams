<?php



trait JS_Elements
{
    ##! 
    ##! 
    ##!  
    
    function JS_Element_Percentage_Set($dest_element,$value_element,$total_element)
    {
        return
            $this->JS_Element_Percentage_Set.
            "(".            
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $dest_element,$value_element,$total_element
                    )
                )                
            ).
            ");".
            "";
    }
}
?>