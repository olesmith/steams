<?php



trait JS_Array
{
    ##! 
    ##! 
    ##!
        
    function JS_Array($values,$sep="",$space="")
    {
        $js=array();
        $values=$this->JS_Quotes($values);

        return
            "[".
            $space.
            join
            (
                ",".$space,
                $values
            ).
            $space.
            "]";
    }
}
?>