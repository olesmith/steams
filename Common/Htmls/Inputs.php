<?php

trait Htmls_Inputs
{
    var $Bulma_Size='is-small';// is-fullwidth';
    var $Input_Classes_Common=array('myinput');
    
    //*
    //* HTML hidden input field.
    //*

    function Htmls_Input($type,$name,$value,$options=array())
    {
        return
            $this->Htmls_Tag_Start
            (
                "INPUT",
                "",
                $this->Htmls_Input_Options
                (
                    $type,$name,$value,$options
                )
            );
    }

    //*
    //* 
    //*

    function Htmls_Input_Options($type,$name,$value,$options=array())
    {
       $this->Htmls_Option_Class_List
        (
            $options,
            $this->Input_Classes_Common
        );

        if (!preg_match('/^hidden$/i',$type))
        {
            $options=
                $this->Htmls_Input_ONCHANGE
                (
                    $type,$name,$value,$options
                );
        }

        $options=
            array_merge
            (
                $options,
                array
                (
                    "TYPE" => strtolower($type),
                    "NAME" => $name,
                    "VALUE" => $value,
                )
            );

        return $options;
    }
    
    //*
    //* 
    //*

    function Htmls_Input_ONCHANGE($type,$name,$value,$options=array())
    {
        if (!empty($options[ "ID" ]) || !empty($options[ "CLASS" ]))
        {
            if (empty($options[ "ONCHANGE" ])) { $options[ "ONCHANGE" ]=array(); }
            
            array_push
            (
                $options[ "ONCHANGE" ],
                "Mark_Form_On_Input_Change();///yyy"
            );
        }

        return $options;
    }

    
    //*
    //* HTMLs hidden input field.
    //*

    function Htmls_Hidden($name,$value,$options=array())
    {
        return $this->Htmls_Input("hidden",$name,$value,$options);
    }

    //*
    //* HTMLs hiddens input fields.
    //*

    function Htmls_Hiddens($hiddens,$options=array())
    {
        $html=array();
        foreach ($hiddens as $name => $value)
        {
            array_push
            (
                $html,
                $this->Htmls_idden($name,$value,$options)
            );
        }
        
        return $html;
    }
    
    //*
    //* HTML text type input field.
    //*

    function Htmls_Input_Text($name,$value="",$options=array(),$type='text')
    {
        if (empty($value)) { $value=$this->CGI_POST($name); }
        
        return
            $this->Htmls_Input
            (
                $type,
                $name,
                $value,
                $options
            );
    }

    
    //*
    //* HTML text type input field.
    //*

    function Htmls_Input_Password($name,$value="",$options=array(),$type='password')
    {
        if (empty($value)) { $value=$this->CGI_POST($name); }

        $options[ "AUTOCOMPLETE" ]="off";
        
        return
            $this->Htmls_Input
            (
                $type,
                $name,
                $value,
                $options
            );
            $this->Html_Tag
            (
                "INPUT",$name,$value,
                $options
            );
    }

    //*
    //*
    //*

    function Htmls_Input_Text_Area($name,$rows,$cols,$value,$options=array(),$wrap="physical")
    {
        if (!empty($options[ "ID" ]))
        {
            $options[ "ONCHANGE" ]=
                "Mark_Form_On_Input_Change();//77";
        }
        
        if (empty($rows))
        {
            $rows=1;
            if (!is_array($value))
            {
                $value=preg_split('/\n/',$value);
            }
        
            $rows=count($value);
        }

        $options=
            array_merge
            (
                $options,
                array
                (
                    "NAME"  => $name,
                    "COLS"  => $cols,
                    "ROWS"  => $rows,
                    "WRAP"  => $wrap,
                    //"CLASS" => 'textarea is-fullwidth',
                )
            );
    
        if (is_array($value))
        {
            for ($n=0;$n<count($value);$n++)
            {
                chop($value[$n]);
            }

            $value=join("\n",$value[$n]);
        }


        //No newline with values, tag directly
        return
            "<TEXTAREA".
            $this->Htmls_Options_String($options).
            ">".
            $value.
            "</TEXTAREA>";
        
           $this->Html_Tag
           (
               "TEXTAREA",
               $value,
               $options
           );

        return $html;
    }
}

?>