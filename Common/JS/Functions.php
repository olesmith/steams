<?php



trait JS_Functions
{
    ##! 
    ##! Call Function.
    ##!
        
    function JS_Function_Call($function,$values=array(),$trailingcolon=";")
    {
        
        return
            array_merge
            (
                array
                (
                    $function,
                    "(",
                ),
                $this->JS_Indent
                (
                    $this->JS_Quotes($values),
                    ","
                ),
                array
                (
                    ")".$trailingcolon,
                )
            );
    }
    
    ##! 
    ##! Call Function.
    ##!
        
    function JS_Function_Call_As_String($function,$values=array())
    {
        return
            join
            (
                "",
                $this->JS_Function_Call($function,$values)
            );
    }
    
    ##! 
    ##! Define Function.
    ##!
        
    function JS_Function_Define($function,$arg_names,$body)
    {
        return
            array_merge
            (
                array
                (
                    "function ".$function.
                    "(".join(",",$arg_names).")",
                    "{",
                ),
                $this->JS_Indent
                (
                    $body
                ),
                array
                (
                    "}",
                )
            );
    }
    
    ##! 
    ##! Call Function.
    ##!
        
    function JS_Function_Define_And_Call($function_name,$arg_names,$body,$values=array())
    {
        return
            array_merge
            (
                $this->JS_Function_Define
                (
                    $function_name,
                    //Arguments
                    $arg_names,
                    //Body
                    $body
                ),

                array
                (
                    join
                    (
                        "",
                        $this->JS_Function_Call
                        (
                            $function_name,
                            $values
                        )
                    )
                )
            );
    }
    
    ##! 
    ##! Call Function.
    ##!
        
    function JS_Function_Define_And_Call_One($function_name,$arg_names,$function,$args,$values=array())
    {
        return
            array_merge
            (
                $this->JS_Function_Define
                (
                    $function_name,
                    //Arguments
                    $arg_names,
                    //Body
                    $this->JS_Function_Call
                    (
                        $function,
                        $args
                    )
                ),

                array
                (
                    join
                    (
                        "",
                        $this->JS_Function_Call
                        (
                            $function_name,
                            $values
                        )
                    )
                )
            );
    }
}
?>