<?php

class Language_Messages_Types_Rows extends Language_Messages_MTimes
{
    var $Language_Messages_N=0;
    
    //*
    //* function Language_Message_Type_Rows, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Rows($type,$hash)
    {
        return
            array
            (
                $this->Language_Message_Type_Row($type,$hash)
            );
    }
    
    //*
    //* function Language_Message_Type_Row, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row($type,$hash)
    {
        $nhashes=
            $this->Sql_Select_NHashes
            (
                array("Message_Type" => $type)
            );
        $this->Language_Messages_N+=$nhashes;
        
        return array
        (
            $type,
            $this->B($hash[ $this->ApplicationObj()->Language ]),
            $this->Language_Message_Type_CheckBox($type,$hash),
            $nhashes
        );
    }
    
    //*
    //* function Language_Message_Type_Row_Titles, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row_Titles()
    {
        return array("No","Type","Include","Count");
    }
    //*
    //* function Language_Message_Type_Row_Titles, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row_Totals()
    {
        return
            array
            (
                "-","-",
                $this->B($this->ApplicationObj()->Sigma),
                $this->B($this->Language_Messages_N),
            );
    }
    
    //*
    //* function Language_Message_Type_Row_All, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row_All()
    {
        return
            array
            (
                "",
                $this->B("All:"),
                $this->Htmls_CheckBox("All",1,False),
                ""
            );
    }
    //*
    //* function Language_Message_Type_Row_File, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row_File()
    {
        return
            array
            (
                "",
                $this->B("Import from File (PHP):"),
                $this->Htmls_Input
                (
                    "FILE",
                    "File",
                    ""
                ),
                ""
            );
    }
    
    
    //*
    //* function Language_Message_Type_CheckBox, Parameter list: 
    //*
    //* 

    function Language_Message_Type_CheckBox($type,$hash)
    {
        $checkbox="-";
        if (!empty($hash[ "Method" ]))
        {
            $value=$this->CGI_POSTint($type);
            $checked=False;
            if ($value==1) { $checked=True; }
            $checkbox=
                $this->Htmls_CheckBox($type,1,$checked);
        }

        return $checkbox;
    }
    
    //*
    //* function Language_Message_Type_Row_CheckBoxes, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Row_CheckBoxes()
    {
        return
            array
            (
                "Add:",
                $this->Htmls_CheckBox("Insert",1,True),
               "Update:",
                $this->Htmls_CheckBox("Update",1,False),
            );
    }
    
}
?>