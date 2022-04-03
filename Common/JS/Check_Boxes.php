<?php



trait JS_Check_Boxes
{
    ##! 
    ##! Load Select field based on other.
    ##!
        
    function JS_CheckBox_Group_Toggle_All($class,$display='initial')
    {
        return
            $this->JS_CheckBox_Group_Toggle_All.
            "(".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $class,$display
                    )
                )
            ).
            ")".
            "";
    }

    
    ##! 
    ##! 
    ##!
        
    function JS_CheckBox_Group_Set_All($check_id,$class,$display='initial')
    {
        return
            $this->JS_CheckBox_Group_Set_All.
            "(".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $check_id,$class,$display
                    )
                )
            ).
            ")".
            "";
    }
}
?>