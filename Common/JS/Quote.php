<?php



trait JS_Quote
{
    ##! 
    ##! Quote argument.
    ##!
        
    function JS_Quote($arg,$quoter="'")
    {
        return $quoter.$arg.$quoter;
    }
    
    ##! 
    ##! Quote arguments.
    ##!
        
    function JS_Quotes($values,$quoter="'")
    {
        foreach (array_keys($values) as $id)
        {
            if (is_array($values[ $id ]))
            {
                $values[ $id ]=$this->JS_Array($values[ $id ],$quoter);
            }
            else
            {
                $values[ $id ]=$this->JS_Quote($values[ $id ],$quoter);
            }
        }

        return $values;
    }
}
?>