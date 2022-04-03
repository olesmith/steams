<?php



trait JS_Sends
{
    ##! 
    ##! Load element call.
    ##!
        
    function JS_Send_Form_URL($url)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }

        

        return
            $this->JS_Send_Form_URL.
            "(".         
            "this,".
            $this->JS_Quote($url).
            ")".
            "";
    }
}
?>