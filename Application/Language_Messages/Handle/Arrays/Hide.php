<?php

class Language_Messages_Handle_Arrays_Hide extends Language_Messages_Handle_Arrays_Table
{    
    //*
    //* Generates htmls table of language and key hide/show buttons.
    //*

    function Language_Messages_Handle_Array_Hide_Buttons($edit,$item)
    {
        return
            $this->Htmls_Table
            (
                "",
                array
                (
                    array_merge
                    (
                        $this->Language_Messages_Handle_Array_Hide_Languages_Buttons(),
                        $this->Language_Messages_Handle_Array_Hide_Keys_Buttons()
                    )
                )
            );
    }
    
    //*
    //* Determines whether we should hide or show $lang fields.
    //*

    function Language_Messages_Handle_Array_Hide_Language_Should($lang)
    {
        $cgikey="Hide_".$lang;        
        if (isset($_POST[ $cgikey ]))
        {
            if ($this->CGI_POSTint($cgikey)==1) { return True; }
            else                                { return False; }
        }
        
        return $lang!=$this->ApplicationObj()->Language;
    }
    
    //*
    //* Determines whether we should hide or show $key fields.
    //*

    function Language_Messages_Handle_Array_Hide_Data_Should($key)
    {
        $cgikey="Hide_".$key;        
        if (isset($_POST[ $cgikey ]))
        {
            if ($this->CGI_POSTint($cgikey)==1) { return True; }
            else                                { return False; }
        }

        return $key!="Name";
    }
    
    //*
    //* Generates language hide/show buttons row.
    //*

    function Language_Messages_Handle_Array_Hide_Languages_Buttons()
    {
        $buttons=array();
        foreach ($this->Language_Keys() as $lang)
        {
            $shouldhide=$this->Language_Messages_Handle_Array_Hide_Language_Should($lang);
            $value=0;
            if ($shouldhide) { $value=1; }
            
            array_push
            (
                $buttons,
                $this->Htmls_Hide_Button_ByClass
                (
                    $lang,
                    $lang,
                    $shouldhide
                ),
                $this->Htmls_Hidden
                (
                    "Hide_".$lang,
                    $value,
                    array
                    (
                        "ID" => "Hide_".$lang,
                    )
                )
            );
        }

        return $buttons;
    }
    
    //*
    //* Generates language hide/show buttons row.
    //*

    function Language_Messages_Handle_Array_Hide_Keys_Buttons()
    {
        $buttons=array();
        foreach ($this->KeyDatas as $key)
        {
            $shouldhide=$this->Language_Messages_Handle_Array_Hide_Data_Should($key);
            
            $value=0;
            if ($shouldhide) { $value=1; }
            
            array_push
            (
                $buttons,
                $this->Htmls_Hide_Button_ByClass
                (
                    $key."s",
                    $key,
                    $this->Language_Messages_Handle_Array_Hide_Data_Should($key)
                ),
                $this->Htmls_Hidden
                (
                    "Hide_".$key,
                    $value,
                    array
                    (
                        "ID" => "Hide_".$key,
                    )
                )
            );
        }

        return $buttons;
    }
}
?>