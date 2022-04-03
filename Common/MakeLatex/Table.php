<?php


trait MakeLatex_Table
{
    //*
    //* Generates Latex table.
    //*

    function Latex_Table($titlerows,$table,$options=array())
    {
        $nitemspp=$this->Latex_Table_NItemsPerPage($options);
        $count=$this->Latex_Table_NCols_Detect($titlerows,$table);

        //$specs=$this->Latex_Table_Specs($options,$count);
        $hline=$this->Latex_Table_HLine($options);

        $page=0;
        $ltables=array($page => "");
        for ($n=0;$n<count($table);$n++)
        {
            if (!is_array($table[$n])) { $table[$n]=array($table[$n]); }

            if ($n>0 && ($n % $nitemspp)==0)
            {
                $page++;
                $ltables[ $page ]="";
            }
            
            if (is_array($table[$n]))
            {
                $ltables[ $page ].=
                    $this->Latex_Table_Row($table[$n],$hline,$count).
                    "";
            }

        }

        $size=$this->Latex_Table_Options_Get($options,"Size","small");

        $pagehead=
            $this->Latex_Table_Options_Get($options,"PageHead").
            "\n\n".
            "\\begin{".$size."}\n".
            "\\begin{tabular}{".
            $this->Latex_Table_Specs($options,$count).
            "}\n".
            $this->Latex_Table_Titles($titlerows,$hline).
            "";
    
        $pageclear="\n\n\\clearpage\n\n";
        
        $pagetail=
            "\\end{tabular}\n\n".
            "\\end{".$size."}\n".
            $this->Latex_Table_Options_Get($options,"PageTail").
            "";

        $pages=array();
        foreach (array_keys($ltables) as $page)
        {
            array_push
            (
                $pages,
                $pagehead.
                $ltables[ $page ].
                $pagetail
            );
        }
        
        return join($pageclear,$pages);
    }

    //*
    //* Detects number of items per page.
    //*

    function Latex_Table_NItemsPerPage($options)
    {
        $nitemspp=50;
        if (isset($this->LatexData[ "NItemsPerPage" ]))
        {
            $nitemspp=$this->LatexData[ "NItemsPerPage" ];
        }

        if (!empty($options[ "NItemsPerPage" ]))
        {
            $nitemspp=$options[ "NItemsPerPage" ];
        }

        return $nitemspp;
    }
    
    //*
    //* Returns tabular specs.
    //*

    function Latex_Table_Specs($options,&$count)
    {
        $specs=array();
        
        $spec="l";
        if (!empty($options[ "Spec" ]))
        {
            $specs=array($options[ "Spec" ]);
        }
        
        if (!empty($options[ "Specs" ]))
        {
            $specs=$options[ "Specs" ];
        }


        if (empty($specs))
        {
            $specs=array("");
            for ($n=0;$n<$count;$n++)
            {
                array_push($specs,$spec);
            }
            array_push($specs,"");
        }

        if (is_array($specs))
        {
            $specs="|".join("|",$specs)."|";
        }

        return $specs;
    }
    
    //*
    //* Returns tabular specs.
    //*

    function Latex_Table_HLine($options)
    {
        $hline="   \\hline\n";
        if (isset($options[ "HLine" ]))
        {
            if ($options[ "HLine" ]==TRUE)
            {
                $hline="   \\hline\n";
            }
            elseif ($options[ "HLine" ]==FALSE)
            {
                $hline="";
            }
            else
            {
                $hline=$options[ "HLine" ];
            }
        }

        return $hline;
    }
    
    //*
    //* function Latex_Table_NCol_Detect, Parameter list: $row
    //*
    //* Detects number of cols in $row.
    //*

    function Latex_Table_NCol_Detect($row)
    {
        if (!empty($row[ "Row" ]))
        {
            $count=count($row[ "Row" ]);
        }
        else
        {
            $count=count($row);
        }

        return $count;
    }
    
    //*
    //* Detects number of cols in $table.
    //*

    function Latex_Table_NCols_Detect($titlerows,$table)
    {
        if (empty($titlerows)) { $titlerows=array(); }
        
        $count=0;
        foreach ($titlerows as $row)
        {
            $count=$this->Max($count,$this->Latex_Table_NCol_Detect($row));
        }
        
        foreach ($table as $row)
        {
            $count=$this->Max($count,$this->Latex_Table_NCol_Detect($row));
        }

        return $count;
    }
    
    //*
    //* function Latex_Table_Titles, Parameter list: $titles,$hline
    //*
    //* Generates Latex table title row(s).
    //*

    function Latex_Table_Titles($titlerows,$hline)
    {
        if (empty($titlerows)) { $titlerows=array(); }
        
        $latex=$hline;
        foreach ($titlerows as $titles)
        {
            if (isset($titles[ "Row" ]) && is_array($titles[ "Row" ]))
            {
                $titles=$titles[ "Row" ];
            }
            foreach ($titles as $id => $title)
            {
                if (!is_array($title))
                {
                    $titles[ $id ]=$this->B($title);
                }
            }
            
            $latex.=
                $this->Latex_Table_Row
                (
                   $titles,
                   $hline
                ).
                "";
        }

        return $latex;
    }

    
    //*
    //* Returns latex $option[ $key ] if set.
    //*

    function Latex_Table_Options_Get($options,$key,$value="")
    {
        if (isset($options[ $key ])) { $value=$options[ $key ]; }
        
        return $value;
    }
    
    //*
    //* Generates Latex table row.
    //*

    function Latex_Table_Row($row,$hline,$count=0)
    {
        if ($count==0) { $count=count($row); }

        if (!empty($row[ "Row" ])) { $row=$row[ "Row" ]; }

        $nospan=FALSE;
        foreach ($row as $n => $val)
        {
            if (is_array($row[$n]) && isset($row[$n][ "Text" ]))
            {
                //We need left | in spec, when we are first column
                $align="c";
                if (!empty($row[$n][ "Options" ][ "ALIGN" ]))
                {
                    $align=$row[$n][ "Options" ][ "ALIGN" ];
                }

                $spec=$align."|";
                if ($n==0) {$spec="|".$align."|"; }

                if (!empty($row[$n][ "Options" ][ "ROWSPAN" ]))
                {
                    $row[ $n ][ "Text" ]=
                        "\\multirow".
                        "{".
                        $row[$n][ "Options" ][ "ROWSPAN" ].
                        "}{*}".
                        "{".
                        $row[ $n ][ "Text" ].
                        "}";
                }

                if (!empty($row[$n][ "Options" ][ "COLSPAN" ]))
                {
                    $row[ $n ]=
                        "\\multicolumn{".
                        $row[$n][ "Options" ][ "COLSPAN" ].
                        "}{".$spec."}{".
                        $row[ $n ][ "Text" ].
                        "}";
                }
                else
                {
                    $row[ $n ]=$row[ $n ][ "Text" ];
                }

                $nospan=TRUE;
            }

            $rrw=$row[ $n ];
            if (is_array($row[ $n ]))
            {
                $rown=$row[ $n ];
                if (isset($row[ $n ][ "Cell" ]))
                {
                    $rown=$row[ $n ][ "Cell" ];
                }

                if (isset($rown[ "Text" ]))
                {
                    $rown=$rown[ "Text" ];
                }
                
                if (!empty($rown[ "Options" ][ "COLSPAN" ]))
                {
                    $align="c";
                    if (!empty($rown[ "Options" ][ "ALIGN" ]))
                    {
                        $align=$rown[ "Options" ][ "ALIGN" ];
                    }
                    
                    $rown=
                        "\\multicolumn{".
                        $rown[ "Options" ][ "COLSPAN" ].
                        "}{|".$align."|}";
                }

                $row[ $n ]=$rown;
            }
            
            if (is_array($row[ $n ]))
            {
                if (preg_grep('/Cell/',array_keys($row[ $n ])))
                {
                    $row[ $n ]=$row[ $n ][ "Cell" ];
                }
                else
                {
                    $row[ $n ]=join(" ",$row[ $n ]);
                }
            }

            if (preg_match('/\\\\multicolumn/',$row[ $n ])) { $nospan=TRUE; }
        }

        //Span columns with less cells than max of table
        $ncount=count($row);
        if (!$nospan && $ncount>0 && $ncount<$count)
        {
            $row[ $ncount-1 ]=
                "\\multicolumn{".
                ($count-$ncount+1).
                "}{|c|}{".
                $row[ $ncount-1 ].
                "}";
        }

        return
            "   ".
            join(" & ",$row).
            "\\\\\n".
            $hline;
    }

    
    //*
    //* Splits and generates Latex Long Tables: Vertical and horisontal áging.
    //*

    function Latex_Long_Tables($titles,$specs,$table,$cols_leading,$ncols,$nrows,$options=array())
    {
        foreach (array("Head","Tail",) as $key)
        {
            if (empty($options[ $key ]))
            {
                $options[ $key ]="%%%! ".$key." %%%";
            }
        }
        
        $titles=
            $this->Latex_Long_Row_Split
            (
                $cols_leading,
                $ncols,
                $titles
            );

        $specs=
            $this->Latex_Long_Row_Split
            (
                $cols_leading,
                $ncols,
                $specs
            );

        $head=$options[ "Head" ];
        if (isset($options[ "Head_First" ]))
        {
            $head=$options[ "Head_First" ];
        }
        
        $tail=$options[ "Tail" ];
        if (isset($options[ "Tail_First" ]))
        {
            $tail=$options[ "Tail_First" ];
        }
        
        $rtables=array();
        foreach
            (
                $this->Latex_Long_Tables_Split_Rows
                (
                    $cols_leading,$ncols,$nrows,
                    $table
                )
                as $table
            )
        {
            foreach (array_keys($titles) as $id)
            {
                $rtable=array($titles[ $id ]);
                foreach ($table as $row)
                {
                    array_push($rtable,$row[ $id ]);
                }

                array_push
                (
                    $rtables,
                    $head,
                    $this->Latex_Table
                    (
                        "",
                        $rtable,
                        array
                        (
                            "Specs" => $specs[ $id ],                        
                        )
                    ),
                    $tail,
                    "\n\n\\clearpage\n\n"
                );

                $head=$options[ "Head" ];
                $tail=$options[ "Tail" ];

            }
        }

        //Remove last clearpage
        array_pop($rtables);

        return $rtables;
    }

    //*
    //*
    //*

    function Latex_Long_Tables_Split_Rows($cols_leading,$ncols,$nrows,$table)
    {
        $tables=array();
        $rtable=array();
        foreach ($table as $row)
        {
            if (count($rtable)>=$nrows)
            {
                array_push($tables,$rtable);
                $rtable=array();
            }
            
            array_push
            (
                $rtable,
                $this->Latex_Long_Row_Split
                (
                    $cols_leading,
                    $ncols,
                    $row
                )
            );
        }

        if (count($rtable)>0)
        {
            array_push($tables,$rtable);
        }

        return $tables;
    }
    
    //*
    //*
    //*

    function Latex_Long_Row_Split($ncols_leading,$cols_perpage,$row)
    {
        
        $leading=array();
        for ($n=0;$n<$ncols_leading;$n++)
        {
            array_push
            (
                $leading,
                array_shift($row)
            );
        }

        $rows=array();
        while (count($row)>0)
        {
            $rrow=$leading;
            for ($n=0;$n<$cols_perpage;$n++)
            {
                if (count($row)==0) { break; }
                
                array_push
                (
                    $rrow,
                    array_shift($row)
                );
            }

            array_push($rows,$rrow);
        }

        return $rows;
    }
}
?>