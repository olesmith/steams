<?php


trait MyMod_Search_Options_Sorts
{
    //*
    //* 
    //*

    function MyMod_Search_Options_Sort_Cells($omitvars)
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
                      $this->MyMod_Search_Options_Sort_Key
                  ).":",
                  array("CLASS" => 'searchtitle')
              ),
              $this->MyMod_Search_Options_Sort_Selects(),
           );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Sorts_Get()
    {
        $this->MyMod_Sort_Detect();
        $sorts=$this->Sort;

        if (empty($sorts)) { $sorts=$this->Sorts; }
        
        if (!is_array($sorts)) { $sorts=array($sorts); }

        return $sorts;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Sort_Selects()
    {
        $values=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (empty($this->ItemData[ $data ][ "No_Sort" ]))
            {
                array_push($values,$data);
            }
        }

        sort($values);

        $titles=$this->MyMod_Data_Titles($values,True);

        $sorts=$this->MyMod_Search_Options_Sorts_Get();
        $selects=array();
        for ($n=0;$n<$this->MyMod_Search_Options_Sort_N;$n++)
        {
            array_push
            (
                $selects,
                $this->MyMod_Search_Options_Sort_Select($n,$sorts,$values,$titles)
            );
        }
        
        return array($selects);
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Sort_Select($n,$sorts,$values,$titles)
    {
        $sort="ID";
        if (!empty($sorts[$n])) { $sort=$sorts[$n]; }
        
        return
            $this->Htmls_Select
            (
                $this->MyMod_Search_Options_Sort_CGI_Field($n),
                $values,
                $titles,
                $sort,
                array
                (
                    "Options" => array
                    (
                        "CLASS" => 'search_field',
                    ),
                    "Option_Options" => array
                    (
                        "CLASS" => 'search_options',
                    )

                )
            );
    }
    
    //*
    //* Name of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Sort_CGI_Field($n)
    {
        return
            $this->ModuleName."_".$this->MyMod_Search_Options_Sort_Key."_".$n;
    }
    
    //*
    //* Value of sort cgi filed no $n.
    //*

    function MyMod_Search_Options_Sort_CGI_Value($n)
    {
        $value=$this->CGI_POST(   $this->MyMod_Search_Options_Sort_CGI_Field($n)   );

        if (empty($value) && !empty($this->Sort[ $n ]))
        {
            $value=$this->Sort[ $n ];
        }
        
        return $value;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Sort_Should($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("Sort",$omitvars))
        {
            return False;
        }

        return True;
    }
}
?>