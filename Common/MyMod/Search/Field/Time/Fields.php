<?php


trait MyMod_Search_Field_Time_Fields
{
    //*
    //* Creates time type search field cell with hidden field.
    //*

    function MyMod_Search_Field_Time_Field($cgi,$field,$data,$rdata,$rval)
    {
        return
            $this->Htmls_CheckBox
            (
                $this->MyMod_Search_Field_Time_Field_Key($field,$data,$rdata),
                1,
                $this->MyMod_Search_Field_Time_Field_Checked($field,$data,$rdata),
                $disabled=FALSE
            );
    }
    
    //*
    //* From to dates for search var.
    //*

    function MyMod_Search_Field_Time_Fields()
    {
        return array("From","To");
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Field_Key($field,$data,$rdata="")
    {
        return
            $this->ModuleName."_".$data."_Search_".$field;
        
        if (empty($rdata)) { $rdata=$data; }

        return $rdata."_".$field;
    }
    
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Field_Checked($field,$data,$rdata="")
    {
        $cgikey=
            $this->MyMod_Search_Field_Time_Field_Key($field,$data,$rdata);

        $cgivalue=False;
        if (!empty($_POST[ $cgikey ]))
        {
            $cgivalue=True;
        }

        return $cgivalue;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Fields_Checked($data,$rdata="")
    {
        $res=False;
        foreach ($this->MyMod_Search_Field_Time_Fields() as $field)
        {
            $rdata=$this->ModuleName."_".$data."_Search";

            if ($this->MyMod_Search_Field_Time_Field_Checked($field,$data,$rdata))
            {
                $res=True;
                break;
            }
        }
        
        return $res;
    }
    
    
}

?>