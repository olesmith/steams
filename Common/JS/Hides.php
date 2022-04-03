<?php



trait JS_Hides
{
    ##! 
    ##! JS code hiding elements.
    ##!
        
    function JS_Hide_Elements_By_Classes($classes)
    {
        if (!is_array($classes))
        {
            $classes=array($classes);
        }
        
        return
            $this->JS_Hide_By_Classes.
            "(".
            $this->JS_Array($classes).
            ");\n";
    }
    
    ##! 
    ##! JS code hiding elements.
    ##!
        
    function JS_Hide_Elements_By_Class($class,$tagname="")
    {
        if (!is_array($class))
        {
            $class=array($class);
        }
        
        return
            $this->JS_Hide_By_Class.
            "(".
            $this->JS_Array($class).
            ",".
            $this->JS_Quote("").
            ",".
            $this->JS_Quote($tagname).
            ");\n";
    }

    ##! 
    ##! JS code hiding elements.
    ##!
        
    function JS_Hide_Elements_By_ID($ids)
    {
        if (!is_array($ids))
        {
            $ids=array($ids);
        }
        
        $ids=preg_grep('/\S/',$ids);
        
        return
            $this->JS_Hide_By_ID.
            "(".
                $this->JS_Array($ids,"","").
            ");";
    }
    
    ##! 
    ##! JS code hides one element.
    ##!
        
    function JS_Hide_Element_By_ID($id)
    {
        if (is_array($id))
        {
            $id=join("_",$id);
        }

        return
            $this->JS_Hide_Elements_By_ID
            (
                array($id)
            );
    }
}
?>