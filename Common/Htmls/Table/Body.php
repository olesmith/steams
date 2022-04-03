<?php

trait Htmls_Table_Body
{
    //*
    //* Generates a HTML table TBODY section.
    //*

    function Htmls_Table_Body($titles,$rows,$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=False,$hover=False)
    {
        $table=array();
        
        //Find noof columns in table
        $count=$this->Htmls_Table_NRows($titles,$rows);

        
        $even=True;
        foreach ($rows as $row)
        {
            if (!is_array($row)) { $row=array($row); }

            $rtroptions=$troptions;
            $tag="TD";
            if (!empty($row[ "TitleRow" ])) { $tag="TH"; }

            if (!empty($row[ "Style" ]))
            {
                $rtroptions[ "STYLE" ]=$row[ "Style" ];
            }
            
            if (!empty($row[ "Class" ]))
            {
                $this->Html_CSS_Set($row[ "Class" ],$rtroptions); 
            }
            elseif ($evenodd && count($row)>1)
            {
                $this->Html_CSS_Reset($rtroptions); 
                if ($even)
                {
                    $this->Html_CSS_Add($evenclass,$rtroptions); 
                }
                else
                {
                    $this->Html_CSS_Add($oddclass,$rtroptions);
                }
            }

            if (!empty($row[ "Options" ]))
            {
                $rtroptions=
                    array_merge
                    (
                        $rtroptions,
                        $row[ "Options" ]
                    );
            }
            
            if (!empty($row[ "Row" ]))
            {
                $row=$row[ "Row" ];
            }

            array_push
            (
                $table,
                $this->Htmls_Table_Row
                (
                    $row,
                    $rtroptions,
                    $tdoptions,
                    $tag,
                    $count
                )
            );

            if ($even) { $even=False; }
            else       { $even=True; }
        }
        
        return
            $this->Htmls_Tag
            (
                "TBODY",
                $table,
                $options
            );
    }
}

?>