<?php



trait JS_Loads
{
    ##! 
    ##! Load once JS call.
    ##!
        
    function JS_Load_Once($url,$dest_id,$display='initial')
    {
        //return "URL";
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }
        
        return
            join
            (
                "",
                $this->JS_Function_Call
                (
                    $this->JS_Load_Once,
                    array
                    (
                        $url,$dest_id,$display
                    )
                )
            );
    }
    
    ##! 
    ##! Load element call.
    ##!
        
    function JS_Load_URL_2_Element($url,$dest_id,$url_group="",$debug=0)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }
        
        return
            "\n".
            $this->JS_Load_URL_2_Element.
            "\n(\n   ".
            join
            (
                ",\n   ",
                $this->JS_Quotes
                (
                    array
                    (
                        $dest_id,$url_group,$url,$this->ModuleName,$debug
                    )
                )
            ).
            "\n)".
            ";";
    }
    
    ##! 
    ##! Load element call.
    ##!Send_Form_URL
        
    function JS_Load_URL_2_Window($url)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }

        

        return
            $this->JS_Load_URL_2_Window.
            "(".
            $this->JS_Quote($url).
            ")".
            "";
    }
     
    ##! 
    ##! Load Select field based on other.
    ##!
        
    function JS_Load_Select($url,$destination_id,$cginame,$source_id,$debug=False)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }

        

        return
            $this->JS_Load_Select.
            "(".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $url,$destination_id,$cginame,$source_id,$debug
                    )
                )
            ).
            ")".
            "";
    }
}
?>