<?php



trait JS_Clip
{
    ##! 
    ##! Copy elements URL to clipboard.
    ##!  
    
    function JS_Clip_Board_Copy_URL($url)
    {
        if (is_array($url))
        {
            $url=$this->CGI_Hash2URI($url);
        }
        
        return
            $this->JS_Clip_Board_Copy_URL.
            "(".
            $this->JS_Quote($url).
            ");".
            "";
    }
}
?>