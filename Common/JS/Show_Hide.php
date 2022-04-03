<?php



trait JS_Show_Hide
{
    ##! 
    ##! Show and hide elemements by class
    ##!
        
    function JS_Show_Hide_Elements_By_Classes($pres,$shows,$hides,$display="initial")
    {
        return
            join
            (
                "",
                $this->JS_Function_Call
                (
                    $this->JS_Show_Hide_By_Classes,
                    array
                    (
                        $pres,
                        $shows,$hides,$display
                    )
                )
            );
    }
}
?>