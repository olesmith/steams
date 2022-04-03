<?php


trait MyMod_Search_CGI_Cookies
{
    //*
    //* function MyMod_Search_CGI_Vars_2_Cookies, Parameter list:
    //*
    //* Add search vars to list of cookies.
    //*

    function MyMod_Search_CGI_Vars_2_Cookies()
    {
        return;
        $cookies=
            preg_grep
            (
                '/^ModuleName$/',
                $this->ApplicationObj->CookieVars,
                PREG_GREP_INVERT
            );
        $cookievals=$this->ApplicationObj->CookieValues;
        
        $res=False;
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Search_CGI_Var_Cookie_Update_Should($data))
            {
                $cres=$this->MyMod_Search_CGI_Var_Cookie_Update($data);
                
                $res=$res && $cres;
            }
        }

        array_push
        (
           $cookies,
           $this->ModuleName."_GroupName",
           $this->ModuleName."_SGroupName",
           $this->ModuleName."_Sort",
           $this->ModuleName."_Reverse",
           $this->ModuleName."_Page",
           $this->ModuleName."_NItemsPerPage",
           $this->ModuleName."_Go_Edit",
           //28/04/2015$this->ModuleName."_IncludeAll",
           "NoHeads"
        );

        foreach ($this->GlobalGCVars as $key => $def)
        {
            array_push($cookies,$key);
        }

        $this->ApplicationObj->CookieVars=$cookies;
        $this->CookieVars=$cookies;
        
        $this->ApplicationObj->CookieValues=$cookievals;
        $this->CookieValues=$cookievals;
    }
    
    //*
    //* Should we update search var cookie $data?
    //*

    function MyMod_Search_CGI_Var_Cookie_Update_Should($data)
    {
       $res=
           True
           /* || */
           /* $this->ItemData[ $data ][ "Sql" ]=="ENUM" */
           /* || */
           /* !empty($this->ItemData[ $data ][ "SqlClass" ]) */
           /* || */
           /* !empty($this->ItemData[ $data ][ "IsDate" ]) */;
    }
    
    //*
    //* Update search var cookie $data.
    //*

    function MyMod_Search_CGI_Var_Cookie_Update($data)
    {
        $res=False;
        if ($this->MyMod_Search_CGI_Cookie_Update_Should($data))
        {
            $key=$this->MyMod_Search_CGI_Name($data);
                
            array_push($cookies,$key);
            $cookievals[ $key ]=$this->MyMod_Search_CGI_Value($data);
                
            /* if (!empty($this->ItemData[ $data ][ "SqlTextSearch" ])) */
            /* { */
            /*     $key=$this->MyMod_Search_CGI_Text_Name($data); */
                    
            /*     array_push($cookies,$key); */
            /*     $cookievals[ $key ]=$this->MyMod_Search_CGI_Value($key); */
            /* } */

            $res=True;
        }
        
        return $res;
    }
}

?>