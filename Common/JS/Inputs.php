<?php



trait JS_Inputs
{
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic($max,$sumclasses=array(),$inc=-1)
    {
        $rsumclasses="false";
        if (!empty($sumclasses))
        {
            if (!is_array($sumclasses))
            {
                $sumclasses=array($sumclasses);
            }
            
            $rsumclasses=$this->JS_Array($sumclasses);
        }
        
        return
            $this->JS_Input_Cyclic.
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".
            $rsumclasses.
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic_Increasing($max,$inc=1)
    {
         
        return
            $this->JS_Input_Cyclic."_Increasing".
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
    
    ##! 
    ##! Load Select field based on other.
    ##!  
    
    function JS_Input_Cyclic_KeyBoard($max,$sumclasses=array(),$inc=-1)
    {        
        $rsumclasses="false";
        if (!empty($sumclasses))
        {
            if (!is_array($sumclasses))
            {
                $sumclasses=array($sumclasses);
            }
            
            $rsumclasses=$this->JS_Array($sumclasses);
        }
        
        return
            $this->JS_Input_Cyclic_KeyBoard.
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".
            $rsumclasses.
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
   
    ##! 
    ##! 
    ##!  
    
    function JS_Inputs_Sum_Row($clss,$dest_class,$totals_id="",$percent_class="")
    {
        return
            $this->JS_Inputs_Sum_Row.
            "(".            
            "this".
            ",".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $clss,$dest_class,
                        $totals_id,
                        $percent_class
                    )
                )                
            ).
            ");".
            "";
    }
}
?>