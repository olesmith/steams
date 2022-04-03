<?php



trait JS_Indent
{
    ##! 
    ##! Prepend
    ##!
        
    function JS_Indent($values,$post="",$pre="   ")
    {
        $ids=array_keys($values);
        for ($n=0;$n<count($ids);$n++)
        {
            $values[ $ids[$n] ]=$pre.$values[ $ids[$n]  ];
            if ($n<count($ids)-1)
            {
                $values[ $ids[$n] ]=$values[ $ids[$n]  ].$post;
            }
        }

        return $values;
    }
    
}
?>