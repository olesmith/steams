<?php

trait Htmls_Form_Args
{
    //*
    //* function Htmls_Form_Args, Parameter list:
    //*
    //* Form Action URI args as hash.
    //*

    function Htmls_Form_Args($action,$args)
    {
        $cgi_args=$this->CGI_Query2Hash();
        
        $cgi_args=$this->CGI_Query2Hash($action,$cgi_args);
        if (!empty($action))
        {
            $cgi_args[ "Action" ]=$action;
        }
        
        $cgi_args=$this->CGI_Hidden2Hash($cgi_args);

        if (!empty($args[ "CGI_Args" ]))
        {
            $cgi_args=array_merge($cgi_args,$args[ "CGI_Args" ]);
        }
        $query=$this->CGI_Hash2Query($cgi_args);

        $this->CGI_CommonArgs_Add($cgi_args);

        if (preg_match('/(.*)\?(.*)/',$action,$matches))
        {
            $aargs=$matches[2];
            $cgi_args=$this->CGI_Query2Hash($aargs,$cgi_args);
        }

        //CGI vars to explicitly suppress
        foreach ($this->Htmls_Form_Suppress_CGI($args) as $cgivar)
        {
            unset($cgi_args[ $cgivar ]);
        }
        
        if (method_exists($this,"MyMod_Search_Vars"))
        {
            //Supress search var value as forms GET args
            foreach ($this->MyMod_Search_Vars() as $data)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                unset($cgi_args[ $rdata  ]);
            }
        }

        if (method_exists($this,"MyMod_Groups_CGI_Key"))
        {
            unset($cgi_args[ $this->MyMod_Groups_CGI_Key() ]);
        }

        if (!empty($args[ "CGI_Args" ]))
        {
            $cgi_args=array_merge($cgi_args,$args[ "CGI_Args" ]);
        }
        
        if (!empty($args[ "No_OnSubmit" ]))
        {
            foreach (array("RAW","Dest","Menu","HorMenu","NoHorMenu","NoSearch") as $key)
            {
                if (isset($cgi_args[ $key ])) { unset($cgi_args[ $key ]); }
                
            }
        }

        return $cgi_args;
    }
}

?>