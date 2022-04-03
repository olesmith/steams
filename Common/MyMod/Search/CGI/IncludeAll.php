<?php


trait MyMod_Search_CGI_IncludeAll
{
    //*
    //* Name of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Key()
    {
        return $this->ModuleName."_IncludeAll";
    }
    
    //*
    //* Default of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Default()
    {
        $default=1;
        if ($this->IncludeAllDefault) { $default=2; }

        if (!$this->MyMod_Search_CGI_Pressed() && $this->IncludeAll) { $default=2; }
        
        return $default;
    }
    
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Value()
    {
        $val=$this->CGI_GETOrPOSTint
        (
            $this->MyMod_Search_CGI_Include_All_Key()
        );
        
        if (empty($val))
        {
            $val=$this->MyMod_Search_CGI_Include_All_Default();
        }

        return $val;
    }
     
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Hidden_Field()
    {
        return
           $this->MakeHidden
           (
              $this->MyMod_Search_CGI_Include_All_Key(),
              $this->MyMod_Search_CGI_Include_All_Value()
           );
    }
     
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Radio_Field()
    {
        if ($this->MyMod_Search_CGI_Vars_Defined_Has())
        {
            return
                $this->B
                (
                    $this->MyLanguage_GetMessage("IncludeAll_Inactive_Message").
                    "."
                );
        }

        return
            $this->Htmls_Radios //($name,$values,$titles,$selected=-1)
            (
               $this->ModuleName."_IncludeAll",
               array(1,2),
               $this->MyLanguage_GetMessages("NoYes"),
               $this->MyMod_Search_CGI_Include_All_Value()
            );
    }
}

?>