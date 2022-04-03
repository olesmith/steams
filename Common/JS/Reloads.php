<?php



trait JS_Reloads
{
    ##! 
    ##! Reload element call. Must clear URL groups as well.
    ##!
        
    function JS_Reload_URL_2_Element($url,$dest_id,$url_group,$debug=0)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }

        

        return
            $this->JS_Reload_URL_2_Element.
            "(\n   ".
            join
            (
                ",\n   ",
                $this->JS_Quotes
                (
                    array
                    (
                        $dest_id,$url_group,$url,$debug
                    )
                )
            ).
            "\n);".
            "";
    }
}
?>