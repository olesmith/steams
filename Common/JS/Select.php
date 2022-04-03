<?php



trait JS_Select
{
    ##! 
    ##! Calls Select_Send
    ##!
        
    function JS_Select_Send($url,$dist_id)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }
        
        return
            $this->JS_Select_Send.
            "(".
            "this,".
            $this->JS_Quote($url).
            ",".
            $this->JS_Quote($dist_id).
            "\n);".
            "";
    }
}
?>