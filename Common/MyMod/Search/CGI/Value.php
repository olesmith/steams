<?php


trait MyMod_Search_CGI_Value
{
    //*
    //* Returns the value of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Zero_Value($data)
    {
        $key=$this->MyMod_Search_CGI_Zero_Name($data);

        $value=False;
        if (isset($_POST[ $key ]))
        {
            $value=$this->CGI_POSTint($key);
            if ($value!=1) { $value=False; }
            else           { $value=True; }
        }

        return $value;
    }
    
    //*
    //* Returns the value of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Def_Value($data)
    {
        $key=$this->MyMod_Search_CGI_Def_Name($data);

        $value=False;
        if (isset($_POST[ $key ]))
        {
            $value=$this->CGI_POSTint($key);
            if ($value!=1) { $value=False; }
            else           { $value=True; }
        }

        return $value;
    }
    
    //*
    //* Returns the value of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Value($data,$rdata="")
    {
        $this->ItemData();
        
        if (empty($rdata))
        {
            $rdata=$this->MyMod_Search_CGI_Name($data);
        }
        
        if ($this->MyMod_Data_Field_Is_Time($data))
        {
            return $this->MyMod_Search_Field_Time_CGI_Interval($data,$rdata);
        }


        
        $value="";
        if (!empty($this->ItemData[ $data ][ "GETSearchVarName" ]))
        {
            $cgi_key=$this->ItemData[ $data ][ "GETSearchVarName" ];
            if (isset($_GET[ $cgi_key ]))
            {
                $value=
                    $this->CGI_GET($cgi_key);
            }
        }

        if (isset($_POST[ $rdata ]))
        {
            $value=$this->CGI_POST($rdata);
        }
        elseif (isset($_GET[ $rdata ]))
        {
            $value=$this->CGI_GET($rdata);
        }
        elseif (isset($_COOKIE[ $rdata ]))
        {
            $value=$this->CGI_COOKIE($rdata);
        }
 

        if (
              !empty($this->ItemData[ $data ][ "SearchCheckBox" ])
              &&
              $this->CheckHashKeyValue($this->ItemData[ $data ],"SearchCheckBox",1)
           )
        {
            //From GET
            $getvalue=$this->CGI_GET($rdata);
            if (!empty($getvalue)) { return array($getvalue); }

            $cgikeys=array();
            for ($i=0;$i<count($this->ItemData[ $data ][ "Values" ]);$i++)
            {
                array_push($cgikeys,$rdata."_".($i+1));
            }

            $values=array();
            foreach ($cgikeys as $no => $cgikey)
            {
                $rcgikey="";
                if (preg_match('/(\d)+$/',$cgikey,$matches))
                {
                    $rcgikey=$matches[1];
                }

                if ($rcgikey!="" && $this->CGI_POST($cgikey)==$rcgikey)
                {
                    array_push($values,$rcgikey);
                }
            }

            if (empty($values) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
            {
                $values=array($this->ItemData[ $data ][ "SearchDefault" ]);
            }

            return $values;
        }
        elseif (
                  !empty($this->ItemData[ $data ])
                  &&
                  $this->CheckHashKeyValue($this->ItemData[ $data ],"IsDate",TRUE)
               )
        {
            if (empty($value) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
            {
                //take default
                //$value=$this->ItemData[ $data ][ "SearchDefault" ];
            }
            else
            {
                $value=$this->HtmlDateInputValue($data,TRUE,FALSE);
            }

            return $value;
        }

        if (
              empty($value)
              &&
              empty($this->ItemData[ $data ][ "SearchCheckBox" ])
              &&
              preg_match('/^0?$/',$value)
              &&
              $this->CheckHashKeySet($this->ItemData[ $data ],"SearchDefault")
              &&
              !empty($this->ItemData[ $data ][ "SearchDefault" ])
           )
        {
            $value=$this->ItemData[ $data ][ "SearchDefault" ];
        }

        if (preg_match('/_/',$value))
        {
            $value=preg_replace('/_/'," ",$value);
        }

        return $value;
    }
}

?>