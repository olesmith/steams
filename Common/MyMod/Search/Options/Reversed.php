<?php


trait MyMod_Search_Options_Reversed
{    
    //*
    //* 
    //*

    function MyMod_Search_Options_Reversed_Cells($omitvars)
    {
        if (!$this->MyMod_Search_Options_Sort_Should($omitvars))
        {
            return array();
        }
        
        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyLanguage_GetMessage
                  (
                      $this->MyMod_Search_Options_Sort_Reversed_Key
                  ).":",
                  array
                  (
                      "CLASS" => 'searchtitle',
                      "TITLE" => $this->MyLanguage_GetMessage
                      (
                          $this->MyMod_Search_Options_Sort_Reversed_Key,
                          "Title"
                      )
                  )
              ),
              $this->MyMod_Search_Options_Reversed_CheckBox(),
           );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Reversed_CheckBox()
    {
        return
            $this->Htmls_CheckBox
            (
                $this->MyMod_Search_Options_Reversed_CGI_Field(),
                $value=1,
                $this->MyMod_Search_Options_Reversed_CGI_Value()
            );
    }
    
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Reversed_CGI_Field()
    {
        return
            $this->ModuleName.
            "_".
            $this->MyMod_Search_Options_Sort_Reversed_Key;
    }
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Reversed_CGI_Value()
    {
        $value=$this->Reverse; ;
        
        $key=$this->MyMod_Search_Options_Reversed_CGI_Field();

        if (!empty($_POST[ $key ]) )
        {
            $value=True;
        }
        
        $key=$this->MyMod_Search_Options_Sort_Reversed_Key;
        if (!empty($_GET[ $key ]) )
        {
            $value=True;
        }
        
        return $value;
    }
    
    
}
?>