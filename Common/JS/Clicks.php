<?php



trait JS_Clicks
{ 
    ##! 
    ##! JS code clicking elements.
    ##!
        
    function JS_Click_Elements_By_Class($class)
    {
        if (is_array($class))
        {
            $class=join(" ",$class);
        }
        
        return
            $this->JS_Click_Elements_By_Class.
            "(".
            $this->JS_Quote($class).
            ");\n";
    }
    ##! 
    ##!
    ##!
        
    function JS_Click_Element_By_ID($id,$trailingcolon=";")
    {
        return
            $this->JS_Function_Call
            (
                $this->JS_Click_Element_By_ID,
                array
                (
                    $id
                ),
                $trailingcolon
            );
    }
    ##! 
    ##! 
    ##!
        
    function JS_Click_Elements_By_ID($ids)
    {
        return
            $this->JS_Function_Call
            (
                $this->JS_Click_Elements_By_ID,
                array
                (
                    $ids
                )
            );
    }
    
    ##! 
    ##! 
    ##!
        
    function JS_Click_Parent_Element_By_Class($id,$clss)
    {
        return
            $this->JS_Function_Call
            (
                $this->JS_Click_Parent_Element_By_Class,
                array
                (
                    $id,
                    $clss
                )
            );
    }
    
    ##! 
    ##! 
    ##!
        
    function JS_Click_Elements_By_Checked_IDs($ids,$checkeds)
    {
        return
            $this->JS_Function_Call
            (
                $this->JS_Click_Elements_By_Checked_IDs,
                array
                (
                    $ids,$checkeds
                )
            );
    }
}
?>