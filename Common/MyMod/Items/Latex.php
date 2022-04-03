<?php


trait MyMod_Items_Latex
{
    //*
    //* Latexfiles all items read ($items, or as usual: $this-<ItemHashes if empty).
    //* First reads latex doc no from CGI, then $latexinfo from $this->LatexData.
    //* Next, reads Head, Glue and Tail based on $latexinfo.
    //* Looping over items, we fabricate the text string:
    //*
    //*  Head.
    //*  Glue filtered over first item.
    //*  Glue filtered over second item.
    //* ...
    //*  Glue filtered over last item.
    //*  Tail
    //*
    //*  If defined $accessmethod ($this->Actions[ "Print" ][ "AccessMethod" ]), this method
    //*  is called on item, in order to check if inclusion of each item is allowed or not.
    //* Checks $latexinfo[ "ItemsPerPage" ] in order to change page, inserting:
    //* Head.
    //* \newpage
    //* Tail.
    //*

    function MyMod_Items_Latex($items=array(),$latexdocno=-1)
    {
        //Test access methods and deny if not satified!!! Used individually for each item, should be used overall too.
        $accessmethod=$this->Actions[ "Print" ][ "AccessMethod" ];

        if (count($items)==0) { $items=$this->ItemHashes; }
        
        if ($latexdocno==-1) { $latexdocno=$this->CGI2LatexDocNo(); }

        $latexdef=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];


        
        if (!empty($latexdef[ "Latex_Handler" ]))
        {
            $handler=$latexdef[ "Latex_Handler" ];
            return
                $this->$handler
                (
                    $latexdef,
                    $latexdocno,
                    $items
                );
        }
            

        $items=$this->MyMod_Items_Latex_Split($items);
        
        if ($latexdocno==-1) { $latexdocno=$this->CGI2LatexDocNo(); }

        $latexdef=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];

        $glue="#Name\n\n";
        if (!empty($latexdef[ "Glue" ]))
        {
            $glue=$this->GetLatexSkel($latexdef[ "Glue" ],TRUE);
        }

        $head="";
        if (!empty($latexdef[ "PageHead" ]))
        {
            $head=$this->GetLatexSkel($latexdef[ "PageHead" ],TRUE);
        }

        $tail="";
        if (!empty($latexdef[ "PageTail" ]))
        {
            $tail=$this->GetLatexSkel($latexdef[ "PageTail" ],TRUE);
        }

        $latex=$head;
        $nitems=0;
        $count=0;

        $nitemspp=
            $this->MyMod_Latex_ItemsPerPage($latexdocno);
        

        $item=array(); //sued to filter at the end.
        foreach ($items as $id => $item)
        {
            $rlatex="";
            if (isset($item[ "LatexPre" ]))
            {
                $rlatex.=$item[ "LatexPre" ];
            }
            
            $rlatex.=$glue;
            
            if (empty($item[ "ID" ]))
            {
                $latex.=preg_replace('/#[A-Za-z_0-9]+/',"",$glue);
                continue;
            }
                
            //See if we need to check access on individual objects
            if ($accessmethod!="")
            {
                if (method_exists($this,$accessmethod))
                {
                    if (!$this->$accessmethod($item))
                    {
                        continue;
                    }
                }
            }


            
            if (method_exists($this,"MyMod_Item_Latex_Init"))
            {
                $this->MyMod_Item_Latex_Init($item);
            }

            $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE);

            $item=$this->MyMod_Item_Latex_Trim($item);

            $nitems++;
            $item[ "No" ]=sprintf("%03d",$nitems);

            $latex.=
                $this->FilterObject
                (
                    $this->FilterHash($rlatex,$item)
                );
            
            $count++;
            if
                (
                    !empty($nitemspp)
                    &&
                    $count==$nitemspp
                    &&
                    $nitems<count($items)
               )
            {
                $latex.=
                    $tail.
                    "\n\n\\clearpage\n\n".
                    $head;

                $count=0;
            }
        }

        if ($nitems==0) { $latex="Empty List..."; }

        $latex.=$tail;

        $this->LastItem=$item;
        //Use last item to filter
        $latex=
            $this->FilterObject
            (
                $this->FilterHash($latex,$item)
            );
        
        return $latex;
    }
    
    //*
    //* Creates latex table with $datas in the columns, one for each item in $item.
    //* If $datas is the empty list, retrieves $datas from actual data group.
    //* Join the data in the table, and call LatexTable to generate the actual table.
    //* Finally call RunLatexPrint in order to save in temp file and run pdflatex.
    //*

    function MyMod_Items_Latex_Table($latex_only=FALSE,$items=array(),$datas=array(),$titles=array(),$force_landscape=False)
    {
        if (empty($items))     { $items=$this->ItemHashes; }
        $this->ApplicationObj()->SetLatexMode();


        $group="";
        if (empty($datas))
        {
            $group=$this->MyMod_Data_Group_Actual_Get();
            $datas=$this->MyMod_Data_Group_Datas_Get($group);
            if (is_array($this->ItemDataGroups[ $group ][ "TitleData"]))
            {
                $titles=$this->ItemDataGroups[ $group ][ "TitleData"];
                $datas=$this->ItemDataGroups[ $group ][ "Data"];
            }
            else
            {
                $titles=$this->MyMod_Data_Titles($datas,1);
            }
        }

        if (
              is_array($this->ItemDataGroups[ $group ])
              &&
              isset($this->ItemDataGroups[ $group ][ "LatexData" ])
           )
        {
            foreach ($this->ItemDataGroups[ $group ][ "LatexData" ] as $key => $value)
            {
                $this->LatexData[ $key ]=$value;
            }
        }

        $rdatas=array();
        $rtitles=array();
        $nskip=0;
        $tablespecs=array();
        for ($n=0;$n<count($titles);$n++)
        {
            $data=$datas[$n];
            if
                (
                    !isset($this->Actions[ $data ])
                    &&
                    $datas[$n]!="No"
                )
            {
                array_push($rdatas,$data);
                array_push($rtitles,$titles[$n]);
            }
            else
            {
                $nskip++;
            }

            if
                (
                    isset($this->ItemData[ $data ])
                    &&
                    !empty($this->ItemData[ $data ][ "LatexWidth" ])
                )
            {
                array_push
                (
                    $tablespecs,
                    "p{".$this->ItemData[ $data ][ "LatexWidth" ]."}"
                );
            }
            elseif
                (
                    isset($this->ItemData[ $data ])
                    ||
                    method_exists($this,$data)
                )
            {
                array_push($tablespecs,"l");                
            }
        }
        array_unshift($tablespecs,"l");

        $firstnewlines=preg_grep('/newline\((\d+)\)(\((\S+)\))?/',$datas);
        $firstnewline=array_shift($firstnewlines);

        $nempties=0;
        $counterfield="";
        if (preg_match('/newline\((\d+)\)(\((\S+)\))?/',$firstnewline,$match))
        {
            $nempties=$match[1];
            $counterfield=$match[2];
            $counterfield=preg_replace('/[\(\)]/',"",$counterfield);
        }

        $nempties-=$nskip;

        $datamatrix=array($rdatas);
        $datarow=array();
        $rrdatas=array();
        for ($n=count($titles);$n<count($datas);$n++)
        {
            if (preg_match('/newline\((\d+)\)(\((\S+)\))?/',$datas[$n]))
            {
                if (count($rrdatas)>0)
                {
                    $rrrdatas=$rrdatas;
                    array_push($datamatrix,$rrrdatas);
                    $rrdatas=array();
                }
            }
            else
            {
                array_push($rrdatas,$datas[$n]);
            }
        }

        if (count($rrdatas)>0)
        {
            array_push($datamatrix,$rrdatas);
        }

        $tbl=array();
        $nn=1;
        foreach ($items as $item)
        {
            $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE);
            $item=$this->MyMod_Item_Latex_Trim($item);

            $counter=500;
            if ($counterfield!="" && isset($item[ $counterfield ])) { $counter=$item[ $counterfield ]; }

            $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]);
            $nn=sprintf("%03d",$nn);

            $rows=array();

            $count=1;
            $number=1;
            $row=array($nn);
            foreach ($datamatrix as $datarow)
            {
                if ($count<=$counter)
                {
                    foreach ($datarow as $data)
                    {
                        if (method_exists($this,$data))
                        {
                            $value=$this->$data(0,$item,$data);
                            array_push($row,$value);
                        }
                        else
                        {
                            if (!isset($item[ $data ])) { continue; }

                            $value=$item[ $data ];
                            if (!preg_match('/\S/',$value)) { $value=""; }
                            array_push($row,$value);
                        }
                    }

                    $rrow=$row;
                    array_push($rows,$rrow);

                    $row=array();
                    for ($n=0;$n<$nempties;$n++) { array_push($row,""); }

                    $count++;
                }
            }

            foreach ($rows as $rrow) { array_push($tbl,$rrow); }

            if (preg_grep('/\S/',$row))
            {
                array_push($tbl,$row);
            }


            $nn++;
        }

        $this->LatexData[ "PageTitle" ]=
            "\\begin{Large}\\textbf{\n".
            "Relatório de ".
            $this->MyMod_ItemsName().
            "\n}\\end{Large}\n\n".
            "\\vspace{0.25cm}";


        $tablespecs="|".join("|",$tablespecs)."|";

        $headmethod="Latex_Head";

        if
            (
                !empty($this->LatexData[ "PluralLatexDocs" ])
                &&
                $this->LatexData[ "PluralLatexDocs" ][ "Landscape" ]
            )
        {
            $headmethod="Latex_Head_Land";
            $this->LatexData[ "PluralLatexDocs" ][ "NItemsPerPage" ]=
                $this->LatexData[ "PluralLatexDocs" ][ "NItemsPerPage_Land" ];
            
            $this->LatexData[ "NItemsPerPage" ]=
                $this->LatexData[ "PluralLatexDocs" ][ "NItemsPerPage_Land" ];
        }
        elseif ($force_landscape)
        {
            $headmethod="Latex_Head_Land";
            $this->LatexData=
                array
                (
                    "NItemsPerPage" => 30,
                );
        }
        

        array_unshift($rtitles,'N$^o$');
        $latex=
            $this->$headmethod().
            "\\begin{center}\\begin{small}\n".
            $this->LatexTable($rtitles,$tbl,$tablespecs).
            "\\end{small}\\end{center}\n".
            $this->Latex_Tail();

        $latex=$this->Latex_Trim($latex);
        
        $texfile=
            $this->ApplicationObj()->MyApp_Title().
            $this->ModuleName.".".
            $this->MTime2FName().
            ".tex";

        if ($latex_only)
        {
            $this->MyMod_Doc_Header_Send("tex",$texfile);
            print $latex;
        }
        else
        {
            return $this->Latex_PDF($texfile,$latex);
        }
    }
    
    //*
    //* Latex items in $items, if empty in $this->ItemHashes;.
    //*

    function MyMod_Items_Latex_Table_Print($items=array())
    {
        $this->LatexData[ "PageTitle" ]="";
        $this->LatexData[ "NItemsPerPage" ]=50;

        if (count($items)==0) { $items=$this->ItemHashes; }
        //$this->ApplicationObj->LogMessage("ItemLatexTablesPrint",count($items)." items");
        $latex="";
        foreach ($items as $id => $item)
        {
            $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item);

            $tbl=$this->MyMod_Item_Latex_Table($item);

            $latex.=
                "\\begin{center}\n".
                "\\begin{Large}\n".
                $this->ItemName." ".$item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item).
                "\n\\end{Large}\n\\vspace{0.25cm}\n\n".
                $this->LatexTable("",$tbl).
                "\\end{center}\n\n".
                "\n\n\\newpage\n\n";
        }

        $latex=
            $this->Latex_Head().
            $latex.
            $this->Latex_Tail();

        $texfile=
            $this->ApplicationObj->HtmlSetupHash[ "WindowTitle" ].
            $this->ModuleName.".".
            $this->MTime2FName().
            ".tex";
        $latex=$this->Latex_Trim($latex);
        return $this->Latex_PDF($texfile,$latex);
    }
    
    //*
    //* Splits items into sections, subsections and so on.
    //*

    function MyMod_Items_Latex_Split($items=array())
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $latexdocno=$this->CGI2LatexDocNo();
        $latexdef=
            $this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];

        if (!empty($latexdef[ "SectionVar" ]))
        {
            $sectionvar=$latexdef[ "SectionVar" ];
            $sections=$this->SplitItemsOnData($sectionvar,$items);
            $ritems=array();
            foreach ($sections as $varvalue => $sectionitems)
            {
                $sitem=$sectionitems[ 0 ];
                $sitem=$this->MyMod_Data_Fields_Enums_ApplyAll($sitem);
                
                $sectionitems[ 0 ][ "LatexPre" ]=
                    $this->FilterHash($latexdef[ "SectionTitle" ],$sitem,TRUE);//TRUE for Latex values
                
                foreach ($sectionitems as $id => $item)
                {
                    array_push($ritems,$item);
                }
            }

            return $ritems;
        }

        return $items;
    }

}

?>