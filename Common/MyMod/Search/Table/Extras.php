<?php


trait MyMod_Search_Table_Extras
{  
    //*
    //* Returns search table extra rows
    //*

    function MyMod_Search_Table_Extra_Rows()
    {
        $table=array();
        if (!empty($this->MyMod_Search_Extra_Method))
        {
            $method=$this->MyMod_Search_Extra_Method;
            $table=$this->$method();
        }

        return $table;
    }
    
    //*
    //* Returns search table extra vars rows
    //*

    function MyMod_Search_Table_Extra_Vars_Rows($extravars)
    {
        $table=array();
        foreach ($extravars as $id => $extravar)
        {
            $val=$this->CGI_POST($extravar[ "Name" ]);
            if ($val=="" && isset($extravar[ "Default" ])) { $val=$extravar[ "Default" ]; }

            $width=10;
            if (isset($extravar[ "Width" ])) { $width=$extravar[ "Width" ]; }

            if (empty($extravar[ "Hidden" ]))
            {
                array_push
                (
                   $table,
                   array
                   (
                       $this->Htmls_DIV
                       (
                           $extravar[ "Title" ].
                           ":",
                           array
                           (
                               "CLASS" => 'searchtitle',
                           )
                       ),
                      
                       $this->MakeInput($extravar[ "Name" ],$val,$width)
                   )
                );
            }
            else
            {               
                array_push
                (
                   $table,
                   array
                   (
                       $this->MakeHidden($extravar[ "Name" ],$val)
                   )
                );
            }
        }

        return $table;
    }
}

?>