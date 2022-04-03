<?php


trait MyMod_Search_Options_Export
{
    var $Export_Types=
        array
        (
            "HTML"  => "HTML",                   //0
            "CSV"   => "Comma Separated Values", //1
            "LaTeX" => "LaTeX Code",             //2
            "PDF"   => "Imprimível (PDF)",       //3
            "JSON"  => "JSON Format",            //4
            "PHP"   => "PHP Code",               //5
            "SQL"   => "SQL Code",               //6
        );
    //*
    //* 
    //*

    function MyMod_Search_Options_Export_Cells($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("Export",$omitvars))
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
                      $this->MyMod_Search_Options_Export_Key
                  ).":",
                  array
                  (
                      "CLASS" => 'searchtitle',
                      "TITLE" => $this->MyLanguage_GetMessage
                      (
                          $this->MyMod_Search_Options_Export_Key,
                          "Title"
                      )
                  )
              ),
              $this->MyMod_Search_Options_Export_Select(),
              $this->Htmls_DIV
              (
                  $this->MyLanguage_GetMessage
                  (
                      $this->MyMod_Search_Options_Export_Orientation_Key
                  ).":",
                  array
                  (
                      "CLASS" => 'searchtitle',
                      "TITLE" => $this->MyLanguage_GetMessage
                      (
                          $this->MyMod_Search_Options_Export_Orientation_Key,
                          "Title"
                      )
                  )
              ),
              $this->MyMod_Search_Options_Export_Orientation_Select(),
           );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Export_Select()
    {
        $values=array();
        $names=array();
        $titles=array();
        $value=0;
        foreach ($this->Export_Types as $name => $title)
        {
            $value++;
            array_push($values,$value);
            array_push($names,$name);
            array_push($titles,$title);            
        }

        return
            $this->Htmls_Select
            (
                $this->MyMod_Search_Options_Export_CGI_Field(),
                $values,
                $names,
                $this->MyMod_Search_Options_Export_CGI_Value()+1,
                array
                (
                    "Options" => array
                    (
                        "CLASS" => 'search_field',
                    ),
                    "Option_Options" => array
                    (
                        "CLASS" => 'search_options',
                    ),
                    "Titles" => $titles,
                )
            );
    }
    
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Export_CGI_Field()
    {
        return
            $this->ModuleName.
            "_".
            $this->MyMod_Search_Options_Export_Key;
    }
    
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Export_CGI_Value()
    {
        $key=$this->MyMod_Search_Options_Export_CGI_Field();

        $value=1;
        if (!empty($_POST[ $key ]) )
        {
            $value=$_POST[ $key ];
        }
        
        $key=$this->MyMod_Search_Options_Export_Key;
        if (!empty($_GET[ $key ]) )
        {
            $value=$_GET[ $key ];
        }
        
        return $value-1;
    }

    
    //*
    //* 
    //*

    function MyMod_Search_Options_Export_Orientation_Select()
    {
        return
            $this->Htmls_Select
            (
                $this->MyMod_Search_Options_Export_Orientation_CGI_Field(),
                array(1,2),
                $this->MyLanguage_GetMessages("Orientations"),
                $this->MyMod_Search_Options_Export_Orientation_CGI_Value(),
                array
                (
                    "Options" => array
                    (
                        "CLASS" => 'search_field',
                        "TITLE" => "If Apply",
                    ),
                    "Option_Options" => array
                    (
                        "CLASS" => 'search_options',
                    ),
                )
            );
    }
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Export_Orientation_CGI_Field()
    {
        return
            $this->ModuleName.
            "_".
            $this->MyMod_Search_Options_Export_Orientation_Key;
    }
    
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Export_Orientation_CGI_Value()
    {
        $key=$this->MyMod_Search_Options_Export_Orientation_CGI_Field();

        $value=1;
        if (!empty($_POST[ $key ]) )
        {
            $value=$_POST[ $key ];
        }
        
        $key=$this->MyMod_Search_Options_Export_Orientation_Key;
        if (!empty($_GET[ $key ]) )
        {
            $value=$_GET[ $key ];
        }
        
        return $value;
    }
}
?>