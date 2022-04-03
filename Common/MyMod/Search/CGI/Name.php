<?php


trait MyMod_Search_CGI_Name
{
    //*
    //* function MyMod_Search_CGI_Zero_Name, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data undef, for SQLs.
    //*

    function MyMod_Search_CGI_Zero_Name($data)
    {
        return
            $this->Application.$this->ModuleName."_".$data."_Zero";
    }

    //*
    //* function MyMod_Search_CGI_Zero_Name, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data undef, for SQLs.
    //*

    function MyMod_Search_CGI_Def_Name($data)
    {
        return
            $this->Application.$this->ModuleName."_".$data."_Def";
    }

    
    //*
    //* function MyMod_Search_CGI_Name, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Name($data)
    {
        return
            $this->Application.$this->ModuleName."_".$data."_Search";
    }
}

?>