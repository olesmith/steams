<?php


trait DB_Web_Services_Curl
{
    
    //*
    //* Generates query.
    //* 
    //* 

    function DB_Web_Services_Curl_Url($where=array(),$limit=-1,$page=1)
    {
        $url=
            join
            (
                "/",
                $this->DB_Web_Services_Curl_Urls()
            );

        if ($this->DB_Web_Services_Paging())
        {
            if ($limit>=0)
            {
                $where=
                    $this->DB_Web_Services_Where_Assoc_List
                    (
                        $where,
                        $limit,
                        $page
                    );
            }
        }
                
        if (is_array($where))
        {
            $where=http_build_query($where);
        }

        if (!empty($where))
        {
            $url.=
                "?".
                $where;
        }
        
        return $url;
     }
    
    //*
    //* List of URL path components.
    //* 
    //* 

    function DB_Web_Services_Curl_Urls()
    {
        $urls=
            array
            (
                $this->DBHash("Host"),
                $this->DBHash("Path"),
                $this->DBHash("Pre"),
                $this->DBHash("Version"),
            );

        $post=$this->DBHash("Post");
        if (!empty($post)) {array_push($urls,$post); }

        return $urls;
    }

    
    //*
    //* 
    //* 

    function DB_Web_Services_Query_Curl($query,$options)
    {
        $result=$this->Curl_Do
        (
            $query,$options
        );
        
        if (empty($result))
        {
            echo "Result empty";
            var_dump($this->DB_Web_Services_Curl_Url($query));
            return array();
        }

        $this->Last_Content=$result;
        
        $json=json_decode($result,TRUE);
        if (!is_array($json))
        {            
            echo
                "Result not JSON, result:\n".
                $result.
                "\n".
                $this->DB_Web_Services_Curl_Url($query).
                "\n";
            
            return array();
        }

        array_push($this->JSONs,$json);
        
        if (!empty($json[ "status" ]))
        {
             echo
                 "Invalid result:\n".
                 $result.
                 "\n".
                 $this->DB_Web_Services_Curl_Url($query).
                 "\n";

             //var_dump($this->DB_Web_Services_Curl_Url($query));
             //var_dump($json);
             //exit();
             return array();           
        }
        
        return $json;
    }

    
}

?>