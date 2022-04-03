<?php



trait JS_Shows
{
    ##! 
    ##! JS code shows elements.
    ##!
        
    function JS_Show_Elements_By_Class($class,$display="initial",$tagname="")
    {
        if (!is_array($class))
        {
            $class=array($class);
        }
        
        return
            $this->JS_Show_By_Class.
            "(".
            $this->JS_Array($class).
            ",".
            $this->JS_Quote($display).
            ",".
            $this->JS_Quote("").
            ",".
            $this->JS_Quote($tagname).
            ");\n";
    }
    
    ##! 
    ##! JS code shows elements.
    ##!
        
    function JS_Show_Elements_By_Classes($classes,$display="initial")
    {
        if (!is_array($classes))
        {
            $classes=array($classes);
        }
        
        return
            $this->JS_Show_By_Classes.
            "(".
            $this->JS_Array($classes).
            ",".
            $this->JS_Quote($display).
            ");\n";
    }
    
    ##! 
    ##! JS code shows elements.
    ##!
        
    function JS_Show_Elements_By_ID($ids,$display="initial",$color="")
    {
        if (!is_array($ids))
        {
            $ids=array($ids);
        }

        $ids=preg_grep('/\S/',$ids);
        
        return
            $this->JS_Show_By_ID.
            "(".
            $this->JS_Array($ids,"","").
            ",".
            $this->JS_Quote($display).
            ",".
            $this->JS_Quote($color).
            ");";
    }
    
    ##! 
    ##! JS code shows elements.
    ##!
        
    function JS_Show_Element_By_ID($id,$display="initial",$color="")
    {
        if (is_array($id))
        {
            $id=join("_",$id);
        }

        return
            $this->JS_Show_Elements_By_ID
            (
                array($id),
                $display,$color
            );
    }
}
?>