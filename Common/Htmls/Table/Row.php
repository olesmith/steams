<?php

trait Htmls_Table_Row
{
    //*
    //* Creates a TR row section in HTML table. May also
    //* be called with $tdtag as TH (as in table header).
    //*

    function Htmls_Table_Row($row,$options=array(),$tdoptions=array(),$tdtag="TD",$count=0)
    {
        if ($count==0) { $count=count($row); }

        $html=array();
        for ($n=0;$n<count($row);$n++)
        {
            if (isset($row[$n]))
            {
                $rtdoptions=$tdoptions;
                if
                    (
                        $n==count($row)-1
                        &&
                        $n<$count-1
                        &&
                        isset($row[$n])
                    )
                {
                    $rtdoptions[ "COLSPAN" ]=$count-$n;
                }

                if
                    (
                        is_array($row[$n])
                        &&
                        isset($row[$n][ "Cell" ])
                    )
                {
                    if (empty($rtdoptions[ "CLASS" ]))
                    {
                        $rtdoptions[ "CLASS" ]=array();
                    }
                    
                    if (!empty($row[$n][ "Class" ]))
                    {
                        $class=$row[$n][ "Class" ];
                        if (!is_array($class))
                        {
                            $class=array($class);
                        }
                        
                        $rtdoptions[ "CLASS" ]=
                            array_merge($class,$rtdoptions[ "CLASS" ]);
                        unset($row[$n][ "Class" ]);
                        
                    }
                    
                    if (!empty($row[$n][ "Style" ]))
                    {
                       $rtdoptions[ "STYLE" ]=$row[$n][ "Style" ];
                    }

                    if (!empty($row[$n][ "Id" ]))
                    {
                       $rtdoptions[ "ID" ]=$row[$n][ "Id" ];
                    }

                    if (!empty($row[$n][ "Options" ]))
                    {
                        $rtdoptions=
                            array_merge
                            (
                                $rtdoptions,
                                $row[$n][ "Options" ]
                            );
                    }
                    
                    $row[$n]=$row[$n][ "Cell" ];
                }

                array_push
                (
                    $html,
                    $this->Htmls_Table_Cell($row[$n],$rtdoptions,$tdtag)
                );
            }
        }

        return $this->Htmls_Tag("TR",$html,$options);
    }
    
    //*
    //* Counts max number of columns.
    //* 
    //*

    function Htmls_Table_NRows($titles,$rows)
    {
        //Find noof columns in table
        $count=0;
        if (is_array($titles) && count($titles)>0)
        { 
            $count=count($titles);
        }

        for ($n=0;$n<count($rows);$n++)
        {
            $rcount=0;
            if (!empty($rows[ $n ][ "Row" ]))
            {
                $rcount=count($rows[$n][ "Row" ]);
            }
            elseif (!empty($rows[$n]))
            {
                $rcount=count($rows[$n]);
            }
            
            if ($rcount>$count) { $count=$rcount; }
        }

        return $count;
    }
    
    //*
    //* Counts max number of columns.
    //* 
    //*

    function Htmls_Table_Row_With_Options($row,$options=array())
    {
        return
            array(array
            (
                "Row" => $row,
                "Options" => $options,
            ));
    }
    
    //*
    //* Creates a row Cell as hash: Cell =>, Options =>[,Style=>.
    //*

    function Htmls_Table_Row_Cell($cell,$options,$title="",$style=array())
    {
        if (!empty($title))
        {
            $options[ "TITLE" ]=$title;
        }
        if (!empty($style))
        {
            $options[ "STYLE" ]=$style;
        }

        return
            array
            (
                "Cell"    => $cell,
                "Options" => $options,
            );
    }
    
    //*
    //* Creates a row $cells.
    //*

    function Htmls_Table_Row_Cells($cells,$options,$titles="",$style=array())
    {
        if ($this->LatexMode()) { return $cells; }
        
        $title=$titles;
        foreach (array_keys($cells) as $id)
        {
            if (is_array($titles)) { $title=$titles[ $id ]; }
            
            $cells[ $id ]=
                $this->Htmls_Table_Row_Cell
                (
                    $cells[ $id ],
                    $options,$title,$style
                );            
        }

        return $cells;
    }
    
    //*
    //* 
    //*

    function Htmls_Table_Row_OddEven_Options($n)
    {
        $color="e6f2ff";
        if ( ($n%2)==1 ) { $color="ffeee6"; }
        
        return
            array
            (
                "ONMOUSEOVER" => "Highlight_TR(this,'lightgray');",
                "ONMOUSEOUT" =>  "Highlight_TR(this);",
                "STYLE"       => array
                (
                    'display' => 'table-row',
                    'background-color' => '#'.$color,
                    'CLASS' => 'DROW',
                ),
            );
    }
    
}

?>