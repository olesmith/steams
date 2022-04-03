<?php


global $ClassList;
array_push($ClassList,"Latex");

class Latex extends CSV
{
    var $LatexData;
    var $RunLatexThrice=FALSE;
    var $LatexDataMessages="Latex.php";

    var $LatexTableNewline="\\\\";

    //*
    //* Set the Latex Head, Skel and Tail attributes.
    //*

    function InitLatex($data)
    {
        $this->LatexData=$data;
    }
    
    //*
    //* Bolds text, as latex or html
    //*
    function Bold($text,$html=TRUE)
    {
        if ($html && !$this->LatexMode())
        {
           $text="<B>".$text."</B>";
        }
        else
        {
           $text="\\textbf{".$text."}";
        }
        
        return $text;
    }

    //*
    //* Italics text, as latex or html
    //*
    function Italic($text,$html=TRUE)
    {
        if ($html && !$this->LatexMode())
        {
           $text="<I>".$text."</I>";
        }
        else
        {
           $text="\\textit{".$text."}";
        }

        return $text;        
    }

    //*
    //* Colors text, as latex or html
    //*
    function Color($text,$color,$html=TRUE)
    {
        if ($html && !$this->LatexMode)
        {
            $text="<FONT COLOR='".strtoupper($color)."'>".$text."</FONT>";
        }
        else
        {
           $text="\\textcolor{".$color."}{".$text."}";
        }

        return $text;        
    }

    //*
    //*Newline, as latex or html
    //*
    function NewLine($html=TRUE)
    {
        $text="\n\n";
        if ($html && !$this->LatexMode())
        {
           $text="<BR>";
        }
        
        return $text;
    }

    function LatexSkelPath()
    {
        if (!empty($this->LatexData[ "SkelPath" ]))
        {
            $path=$this->LatexData[ "SkelPath" ];
        }
        else
        {
            $path=
                $this->ApplicationObj()->MyApp_Setup_Path().
                "/Latex";
        }

        return $this->FilterExtraPathVars($path);
    }

    //*
    //* function GetLatexSkel , Parameter list:
    //*
    //* Returns contents of latex skel file name including SkelPath
    //* 

    function GetLatexSkel($latexdoc,$comment=FALSE)
    {
        $latex="";

        $latexdocs=$latexdoc;
        if (!is_array($latexdocs)) { $latexdocs=array($latexdocs); }

        $path=$this->LatexSkelPath();
        $path=preg_replace('/#Setup/',$this->ApplicationObj->SetupPath,$path);
        $path=preg_replace('/#Module/',$this->ModuleName,$path);

        foreach ($latexdocs as $latexdoc)
        {
            $latexdoc=preg_replace('/#Setup/',$this->ApplicationObj->SetupPath,$latexdoc);
            $latexdoc=preg_replace('/#Module/',$this->ModuleName,$latexdoc);
            
            if (!file_exists($latexdoc))
            {
                $latexdoc=join("/",array($path,$latexdoc));
            }
            
            if (is_file($latexdoc))
            {
                if ($comment)
                {
                    $latex.=
                        "%%%%%%%! Skel File: $latexdoc\n";
                }

                $latex.=
                    join("",$this->MyReadFile($latexdoc));
            }
            else
            {
                $latex.="%%%%%%%!! Not found: ".$latexdoc;
            }
        }

        return $latex;
    }

    //*
    //* function LatexTmpPath, Parameter list:
    //*
    //* Return path to temporary directory, for storing latex files generated.
    //* 

    function LatexTmpPath()
    {
        $path="/tmp";
        if (!empty($this->LatexData[ "TmpPath" ]))
        {
            $path=$this->LatexData[ "TmpPath" ];
        }
        
        if ($path=="/tmp")
        {
            $path="/tmp/Latex";

            $this->CreateDir($path);
        }
        
        if (!file_exists($path))
        {
            var_dump($path,"does not exist");
            exit();
        }
        
        return $path;
    }


    //*
    //* function CGI2LatexDocNo , Parameter list:
    //*
    //* Retrieves LatexDoc (no) from CGI environment.
    //* 

    function CGI2LatexDocNo()
    {
        $latexdoc=$this->GetGETOrPOST("LatexDoc");
        if ($latexdoc=="" || $latexdoc<=0) { $latexdoc=1; }

        return $latexdoc-1;
    }



//*
//* function GetSingularLatexDoc , Parameter list:
//*
//* Returns the latex doc (singular), acording to cgi var "LatexDoc".
//* 
//*

function GetSingularLatexDoc()
{
    $latexdocno=$this->CGI2LatexDocNo();
    $latexdoc=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "Glue" ];

    return $this->GetLatexSkel($latexdoc);
}







//*
//* function LatexList , Parameter list: $list,$ul
//*
//* Prints a Latex list (enumerate) with elements in $list
//* 
//*

function LatexList($list,$ul="enumerate")
{
  $tex="\\begin{".$ul."}\n";
  for ($n=0;$n<count($list);$n++)
  {
    $tex.="   \\item ".$list[$n]."\n";
  }
  $tex.="\\end{".$ul."}\n";

  return $tex;
}


//*
//* function LatexMakeRow , Parameter list: $row,$count=0
//*
//* Creates a row section in Latex table. May also
//* be called with $tdtag as TH (as in table header).
//* 
//*

function LatexMakeRow($row,$count=0)
{
    $tdoptions="";
    if ($count==0) { $count=count($row); }

    if (!empty($row[ "Row" ])) { $row=$row[ "Row" ]; }

    $nospan=FALSE;
    foreach ($row as $n => $val)
    {
        if (is_array($row[$n]))
        {
            if (isset($row[$n][ "Text" ]))
            {
                if (is_array($row[$n][ "Text" ]))
                {
                    $row[$n][ "Text" ]=$this->Htmls_Text($row[$n][ "Text" ]);
                }
                
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
            else
            {
                $row[$n]=$this->Htmls_Text($row[$n]);
            }
        }

        if (preg_match('/\\\\multicolumn/',$row[ $n ])) { $nospan=TRUE; }
    }

    //Span columns with less cells than max of table
    $ncount=count($row);
    if (!$nospan && $ncount>0 && $ncount<$count)
    {
        $row[ $ncount-1 ]="\\multicolumn{".($count-$ncount+1)."}{|c|}{".$row[ $ncount-1 ]."}";
    }

    $tex="   ".join(" & ",$row).$this->LatexTableNewline."\n";

    return $tex;
}

//*
//* function LatexHeadRow, Parameter list: $row,$count=0
//*
//* Creates Table Header row - calls LatexMakeRow above.
//* 
//*

function LatexHeadRow($row,$count=0)
{
    if (is_array($row[0]))
    {
        //Multiple header rows.
        $tex="";
        foreach ($row as $rrow)
        {
            $tex.=$this->LatexHeadRow($rrow,$count);
        }

        return $tex;
    }
    
    if ($count==0) { $count=count($row); }
    
    for ($n=0;$n<count($row);$n++)
    {
        if (is_array($row[$n])) { var_dump($row[$n]); exit();}
        
        $row[$n]="\\textbf{".$row[$n]."}";
    }
    
    $tex=$this->LatexMakeRow($row,$count);

  return $tex;
}

//*
//* function LatexTableRow, Parameter list: $row,$count=0
//*
//* Creates a Table row - calls HTMLMakeRow above.
//* 
//*

function LatexTableRow($row,$count=0)
{
  if ($count==0) { $count=count($row); }
  $tex=$this->LatexMakeRow($row,$count);

  return $tex;
}

//*
//* function LatexTable, Parameter list: $titles,$rows,$tablespec=0,$footnumbers=FALSE,$hlines=TRUE,$speclen=0,$greyrows=FALSE,$size="small"
//*
//* Creates a LatexTable.
//* 
//*

function LatexTable($titles,$rows,$tablespec=0,$footnumbers=FALSE,$hlines=TRUE,$speclen=0,$greyrows=FALSE,$size="small",$tablehead="",$tablefoot="",$spec='l')
{
    $rspeclen=$speclen;
    $pagetitle="";
    if (isset($this->LatexData[ "PageTitle" ])) { $pagetitle=$this->LatexData[ "PageTitle" ]; }

    $nitemspp=50;
    if (isset($this->LatexData[ "NItemsPerPage" ])) { $nitemspp=$this->LatexData[ "NItemsPerPage" ]; }
    if ($nitemspp=="" || $nitemspp==0)
    {
        $nitemspp=50;
    }

    //Find noof columns in table
    $count=0;
    if (is_array($titles) && count($titles)>0)
    {  
        if (is_array($titles[0]))
        {
            $count=count($titles[0]);
        }
        else
        {
            $count=count($titles);
        }
    }
    else
    {
        //table without title row
        $count=0;
        foreach ($rows as $id => $row)
        {
            $count=$this->Max($count,count($row));
        }
    } 

    if (!empty($speclen)) { $count=$speclen; }

    if (is_array($spec))
    {
        $specs=$spec;
    }
    else
    {
        $specs=array();
        for ($n=0;$n<$count;$n++)
        {
            $specs[$n]=$spec;
        }
    }

    if ($tablespec!="") { $specs=$tablespec; }
    else
    {
        $speclen=count($specs);
        $specs="|".join("|",$specs)."|";
    }

    for ($n=0;$n<count($rows);$n++)
    {
        $rcount=count($rows[$n]);
        if ($rcount>$count) { $count=$rcount; }
    }

    $hline="";
    if ($hlines) {$hline="\\hline\n"; }

    $greyrow=$this->ApplicationObj->LatexWhiteRows();
    $whiterow="";
    if ($greyrows)
    {
        $greyrow=$this->ApplicationObj->LatexGreyRows();
        $whiterow=$this->ApplicationObj->LatexWhiteRows();
    }

    $tablehead.=
        "\\begin{".$size."}\n".
        $greyrow.
        "\\begin{tabular}{".$specs."}\n";

    $tablefoot.=
        "\\end{tabular}\n".
        $whiterow.
        "\\end{".$size."}";



    $headrow="";
    if ($hlines) { $headrow=$hline; }

    if (is_array($titles) && count($titles)>0)
    {
        $headrow=
            "\\hline\n".
            $this->LatexHeadRow($titles,$count).
            "\\hline\n\n".
            "";
    }

    $npages=intval(count($rows)/$nitemspp);
    if (count($rows)-$nitemspp*$npages!=0) { $npages++; }

    //Now generate table
    $tex=
        $pagetitle.
        $tablehead.
        $headrow.
        "";

    $nn=1;
    $pageno=1;
    if ($footnumbers)
    {
        $tex.="\\cfoot{".$pageno." de ".$npages."}\n";
    }

    for ($n=0;$n<count($rows);$n++)
    {
        if (!is_array($rows[$n])) { $rows[$n]=array($rows[$n]); }

        if (is_array($rows[$n]))
        {
            $rline=$hline;
            if (!empty($hlines[ $n ])) { $rline=$hlines[ $n ]; }

            $tex.=$this->LatexTableRow($rows[$n],$count).$rline;
        }

        if ($nn==$nitemspp)// || !is_array($rows[$n]))
        {

            $tex.=
                $tablefoot;

            $pageno++;
            if ( ($n+1)<count($rows))
            {
                $tex.="\n\\clearpage\n\n";

                if ($footnumbers)
                {
                    $tex.="\\cfoot{".$pageno." de ".$npages."}\n";
                }

                $tex.=
                    $pagetitle.
                    $tablehead.
                    $headrow;
            }

            $nn=0;
        }
        
        $nn++;

    }

    if ($nn>1)
    {
        $tex.=$tablefoot;
    }

    return $tex;
}

    //*
    //* Runs Latex, saving $latex to $path."/".$texfilename.
    //*

    function RunLatex($texfilename,$latex,$runbibtex=FALSE)
    {
        return $this->Latex_Run($texfilename,$latex,$runbibtex);
    }
    



    //*
    //* ScanFirstCommand
    //*
    //* Scans array $latex for first appearance of \command[optionals]{compulsories}.
    //* Adds to array the following keys:
    //*
    //* LeadingSkip: Everything before \documentclass
    //* Optional: Optional arguments to \documentclass[...]?
    //* Compulsory: Compulsory arguments to \documentclass[...]?{...}
    //* Document: Everything after \documentclass[...]?{...}
    //*

    function ScanDocclass($latex=array(),$info=array())
    {
        $regex='(.*)\\\\documentclass(\[.*\])?(\{.*\})(.*)';

        $before=array();
        $after=array();
        $optional="";
        $compulsory="";

        $n=0;
        $done=FALSE;
        for (;$n<count($latex) && !$done;$n++)
        {
            if (preg_match('/'.$regex.'/',$latex[$n],$matches))
            {
                array_push($before,$matches[1]);
                $optional=$matches[2];
                $compulsory=$matches[3];
                array_push($after,$matches[4]);

                $done=TRUE;
            }
            else
            {
                array_push($before,$latex[$n]);
            }
        }

        for (;$n<count($latex);$n++)
        {
            array_push($after,$latex[$n]);
        }

        $info[ "LeadingSkip" ]=$before;
        $info[ "Document" ]=$after;
        $info[ "Compulsory" ]=$compulsory;
        $info[ "Optional" ]=$optional;

        return $info;
    }

    //*
    //* Scans preamble for used packages.
    //*

    function ScanPreamblePackages($latex=array(),$info=array())
    {
        $regex='\\\\usepackage(\[[^\[\]]*\])?\{([^\{\}]+)\}';

        $packagehash=array();
        for ($n=0;$n<count($latex);$n++)
        {
            if (preg_match('/'.$regex.'/',$latex[$n],$matches))
            {
                $package=$matches[2];
                $optional=$matches[1];

                $optional=preg_replace('/^\[/',"",$optional);
                $optional=preg_replace('/\]$/',"",$optional);

                $packages=preg_split('/\s*,\s*/',$package);

                foreach ($packages as $id => $package)
                {
                    $packagehash[ $package ]=array
                    (
                     "Package" => $package,
                     "Optional" => $optional,
                    );
                }
           }
        }

        $info[ "Packages" ]=$packagehash;

        return $info;
    }

    //*
    //* ScanTexEnvironment
    //*
    //* Scans array $latex for \begin, end $environment.
    //* Starting/terminating regexp are resp.:
    //*
    //* '(.*)\\\\begin\{'.$environment.'\}(.*)'
    //* '(.*)\\\\end\{'.$environment.'\}(.*)'
    //*
    //* Returns array with keys:
    //*
    //* $environment."_Start": everything that preceeds leading regexp
    //* $environment."_Content": everything between \begin{} and \end{}
    //* $environment."_End": enverything that succeeeds terminating regexp
    //* $environment."_Args": Optional args, eg: \begin{env}[optionalargs]
    //* 
    //*

    function ScanTexEnvironment($environment,$latex=array(),$info=array())
    {
        $beginregex='(.*)\\\\begin\{'.$environment.'\}(\[.*\])?(\{.*\})?(.*)';
        $endregex='(.*)\\\\end\{'.$environment.'\}(.*)';

        $begin=-1;
        $end=-1;

        $n=0;

        $start=array();
        $end=array();
        $content=array();
        $optargs="";
        $compargs="";

        $done=FALSE;
        for (;$n<count($latex) && !$done;$n++)
        {
            if (preg_match('/'.$beginregex.'/',$latex[$n],$matches))
            {
                array_push($start,$matches[1]);
                $optargs=$matches[2];
                $compargs=$matches[3];
                array_push($content,$matches[4]);              


                $optargs=preg_replace('/^\[/',"",$optargs);
                $optargs=preg_replace('/\]$/',"",$optargs);

                $compargs=preg_replace('/^\[/',"",$compargs);
                $compargs=preg_replace('/\]$/',"",$compargs);

                $done=TRUE;
            }
            else
            {
                array_push($start,$latex[$n]);
            }
        }

        $done=FALSE;
        for (;$n<count($latex) && !$done;$n++)
        {
            if (preg_match('/'.$endregex.'/',$latex[$n],$matches))
            {
                array_push($content,$matches[1]);
                array_push($end,$matches[2]);

                $done=TRUE;
            }
            else
            {
                array_push($content,$latex[$n]);
            }
        }

        for (;$n<count($latex);$n++)
        {
            array_push($end,$latex[$n]);
        }

        $info[ $environment."_Start" ]=$start;
        $info[ $environment."_Content" ]=$content;
        $info[ $environment."_End" ]=$end;
        $info[ $environment."_Optional" ]=$optargs;
        $info[ $environment."_Compulsory" ]=$optargs;

        return $info;
   }


    function ProcessLatexDoc($latex=array())
    {
        $info=array();

        $info=$this->ScanDocclass($latex,$info);

        $info=$this->ScanPreamblePackages($info[ "Document" ],$info);

        if ($info[ "Packages" ][ "inputenc" ] && $info[ "Packages" ][ "inputenc" ][ "Optional" ]=='latin1')
        {
            $rlatex=array();
            foreach ($info[ "Document" ] as $id => $text)
            {
                $text=iconv("ISO-8859-1", "UTF-8//TRANSLIT", $text);
                array_push($rlatex,$text);
            }

            $info[ "Document" ]=$rlatex;
        }

        $latex=$info[ "Document" ];
        $info=$this->ScanTexEnvironment("document",$latex,$info);


        $latex=$info[ "document_Content" ];
        $info=$this->ScanTexEnvironment("abstract",$latex,$info);

        $latex=$this->MergeLists($info[ "abstract_Start" ],$info[ "abstract_End" ]);

        $info=$this->ScanTexEnvironment("thebibliography",$latex,$info);


        $info[ "Body" ]=$this->MergeLists($info[ "thebibliography_Start" ],$info[ "thebibliography_End" ]);

        return $info;
    }

    function LatexTables($head,$tail,$glue,$titles,$tables,$specs="")
    {
        foreach ($tables as $id => $table)
        {
            $tables[ $id ]=
                $head.
                $this->LatexTable($titles,$table,$specs,FALSE,FALSE).
                $tail;
        }
        
        return join($glue,$tables);
    }


    function LatexOnePage($latex,$width="27.5cm",$scale=1.0)
    {
        return 
            "\\scalebox{".$scale."}{\n".
            "\\makebox[".$width."][c]{\n".
            "\\begin{minipage}[t]{".$width."}\n".
            "\\begin{center}\n".
            $latex.
            "\\end{center}\n".
            "\\end{minipage}\n".
            "}\n}\n\n";
    }

    function LatexDateSigner($width=0.5)
    {
        return 
            "\\underline{\\hspace{".$width."cm}}/".
            "\\underline{\\hspace{".$width."cm}}/".
            "\\underline{\\hspace{".(2.0*$width)."cm}}";
    }

    function LatexAlign($content,$align="")
    {
        $latex="";
        if (!empty($align))
        {
            $latex.="\\begin{".$align."}\n";
        }

        $latex.=$content."\n";

        if (!empty($align))
        {
            $latex.="\\end{".$align."}\n";
        }

        return $latex;
    }


    function MiniPage($width,$content,$pos='t',$align="")
    {
        $latex="\\begin{minipage}[".$pos."]{".$width."cm}\n";
        if (!empty($align))
        {
            $latex.=$this->LatexAlign($content,$align=="");
        }
        $latex.="\\end{minipage}\n";

        return $latex;
    }

    function LatexBox($width,$content,$frame=FALSE,$minipage=FALSE,$pos='t',$align="")
    {
        $box="mbox";
        if ($frame) { $box="fbox"; }

        $latex="\\".$box."{\n";
        if ($minipage)
        {
            $latex.=$this->MiniPage($width,$content,$pos,$align);
        }
        else
        {
            $latex.=$content;
        }
        $latex.="}\n";
        
        return $latex;
            
    }

    /* function ShowLatexCode($latex,$linenumbers=False,$exit=True) */
    /* { */
    /*     $latex=$this->Latex_Trim($latex); */
    /*     $this->Latex_Code_Show($latex,$linenumbers,$exit); */
    /* } */

    function LatexEnv($env,$latex,$options=array(),$newlines=TRUE)
    {
        $newline="";
        if ($newlines) { $newline="\n"; }
        
        if (is_array($options))
        {
            $roptions=array();
            foreach ($options as $key => $value)
            {
                array_push($roptions,$key."=".$value);
            }

            $options=join(",",$roptions);
        }

        if (!empty($options))
        {
            $options="[".$options."]";
        }

        return
            "\\begin{".$env."}".$options.$newline.
            $latex.
            "\\end{".$env."}".$newline;
            
    }

    //* function LatexSwitchLandscape, Parameter list: $student=array()
    //*
    //* Generate newgeometry entry, switching to landscape.
    //*

    function LatexSwitchLandscape()
    {
        return
            "\\newgeometry\n".
            "{\n".
            "a4paper,\n".
            "landscape,\n".
            "left=0.5cm,\n".
            "right=0.5cm,\n".
            "top=0.75cm,\n".
            "bottom=0.75cm,\n".
            "includehead,\n".
            "includefoot,\n".
            "headheight=2.5cm,\n".
            "headsep=0.75cm\n".
            "}\n\n";
    }

    //* function LatexSwitchPortrait, Parameter list: $student=array()
    //*
    //* Generate newgeometry entry, switching to landscape.
    //*

    function LatexSwitchPortrait()
    {
        return
            "\\newgeometry\n".
            "{\n".
            "  a4paper,\n".
            "  portrait,\n".
            "  left=0.5cm,\n".
            "  right=0.5cm,\n".
            "  top=0.75cm,\n".
            "  bottom=0.75cm,\n".
            "  includehead,\n".
            "  includefoot,\n".
            "  headheight=2.5cm,\n".
            "  headsep=0.75cm\n".
            "}\n\n";
    }
    
}
?>