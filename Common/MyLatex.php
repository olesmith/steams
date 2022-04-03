<?php

trait MyLatex
{
    var $LatexScript="pdflatex.sh";
    var $LatexDelete=FALSE;

    
    //*
    //* Creates and args hash with hidden args and their values.
    //* 
    //*

    function LatexMode($hash=array())
    {
        if
            (
                isset($this->ApplicationObj->LatexMode)
                &&
                $this->ApplicationObj->LatexMode
            )
            { return TRUE; }
        
        if
            (
                isset($this->LatexMode)
                &&
                $this->LatexMode
            ) { return TRUE; }

        return FALSE;
    }

    //*
    //* Prints the Latex Head (leading HEAD section and top/left of page).
    //* Stored in /usr/local/UEG/Skels/Html/Head.Head.html, resp.
    //* Stored in /usr/local/UEG/Skels/Html/Head.Body.html.
    //* 

    function Latex_Head()
    {
        if (!empty($this->LatexData[ "Head" ]))
        {
            return $this->GetLatexSkel($this->LatexData[ "Head" ]);
        }
        else
        {
            return $this->GetLatexSkel("Head.tex");
        }
    }


    //*
    //* Prints the Latex Tail (trailing right/bottom of the page).
    //* Stored in /usr/local/UEG/Skels/Html/Tail.html, resp.
    //* 
    //*

    function Latex_Tail()
    {
        if (!empty($this->LatexData[ "Tail" ]))
        {
            return $this->GetLatexSkel($this->LatexData[ "Tail" ]);
        }
        else
        {
            return $this->GetLatexSkel("Tail.tex");
        }
    }
    
    //*
    //* Prints the Latex Head with landscape set(leading HEAD section and top/left of page).
    //* Stored in /usr/local/UEG/Skels/Html/Head.Head.html, resp.
    //* Stored in /usr/local/UEG/Skels/Html/Head.Body.html.
    //* 

    function Latex_Head_Land()
    {
        if (!empty($this->LatexData[ "Head_Land" ]))
        {
            return $this->GetLatexSkel($this->LatexData[ "Head_Land" ]);
        }
        else
        {
            $head=$this->Latex_Head();
            //Include landscape in \documentclass
            if (preg_match('/\s*(\S)documentclass\[([^\[\]]+)\]/',$head,$matches) && count($matches)>=2)
            {
                $head=preg_replace
                (
                   '/\s*(\S)documentclass\[([^\[\]]+)\]/',
                   $matches[1]."documentclass[landscape,".$matches[2]."]",
                   $head
               );
            }

            return $head;
        }
    }

    
    //*
    //* Apply latex filters in ApplicationObj()->MyApp_Latex_Filters
    //*

    function Latex_Apply_Filters($latex)
    {
        foreach ($this->ApplicationObj()->MyApp_Latex_Filters as $key => $hash)
        {
            if (!is_array($hash))
            {
                if (method_exists($this->ApplicationObj(),$hash))
                {
                    $rhash=$this->ApplicationObj()->$hash();

                    $obj=$key."sObj";
                    if (method_exists($this,$obj))
                    {
                        $rhash=$this->$obj()->MyMod_Data_Fields_Enums_ApplyAll($rhash,TRUE);
                    }
                    
                    $hash=array();
                    foreach ($rhash as $rkey => $rvalue)
                    {
                        $hash[ $key."_".$rkey ]=$rvalue;
                    }
                }
            }
            
            if (is_array($hash))
            {
                $latex=$this->FilterHash($latex,$hash);
            }
        }


        return $latex;
    }
    //*
    //* Runs pdflatex, saving cntent of $latex to $path."/".$texfilename.
    //*

    function Latex_Command($path,$texfilename)
    {
        $command=
            $this->ApplicationObj()->MyApp_Setup_Root().
            "/".
            $this->LatexScript.
            " ".
            $path.
            " ".
            $texfilename;

        return $command;
    }

    //*
    //* Removes or substitutes anything unwanted in a file name.
    //*

    function Latex_File_Name($texfilename)
    {
        $texfilename=$this->Html2Sort($texfilename);
        $texfilename=$this->Text2Sort($texfilename);
        $texfilename=preg_replace('/&#\d+;/',"",$texfilename);
        $texfilename=preg_replace('/[^a-zA-Z0-9\._\-]/',"_",$texfilename);
        $texfilename=preg_replace('/_+/',"_",$texfilename);

        return $texfilename;
    }

    
    //*
    //* Runs pdflatex, saving cntent of $latex to $path."/".$texfilename.
    //*

    function Latex_Run($texfilename,$latex,$runbibtex=FALSE)
    {
        if ($this->GetGETOrPOST("Latex_Code_Show")==1)
        {
            $this->Latex_Code_Show($latex);
            exit();
        }
        
        $texfilename=$this->Latex_File_Name($texfilename);

        $path=$this->LatexTmpPath();

        $pdffilename=preg_replace('/\.tex$/',".pdf",$texfilename);

        $latex=
            $this->Text2Tex
            (
                $latex,
                html_entity_decode
                (
                    $this->Latex_Apply_Filters($latex)
                )
            );

        $this->MyWriteFile
        (
            $path."/".$texfilename,
            $latex
        );
        
        $command=$this->Latex_Command($path,$texfilename);
        
        //Run pdflatex first time
        $mess=system($command,$res1);

        if ($runbibtex)
        {
            //Store dir
            $cwd=getcwd();
            chdir($path);

            $bibtex=preg_replace('/\.tex$/',"",$texfilename);
            system("/usr/bin/bibtex $bibtex > bibtex.log 2>&1");

            //Restore dir
            chdir($cwd);
        }

        if ($this->RunLatexThrice || $runbibtex)
        {
            //Make sure we run Latex 3 times, so all refs tect are updated
            $mess=system($command,$res1);
            $mess=system($command,$res1);
            $this->UnlinkFiles(array($bibtex.".bib",$bibtex.".blg",$bibtex.".bbl"),$path);
        }

        $logfile=preg_replace('/\.pdf/',".log",$pdffilename);
        $auxfile=preg_replace('/\.pdf/',".aux",$pdffilename);
        $tocfile=preg_replace('/\.pdf/',".toc",$pdffilename);

        $this->UnlinkFiles(array($auxfile,$tocfile,"latex.log"),$path);

        if (is_file($path."/".$pdffilename))
        {
            if ($this->LatexDelete)
            {
                $this->UnlinkFiles(array($texfilename,$logfile),$path);
            }
            
            return $pdffilename;
        }
        else
        {
            //print "Res pdflatex: $res1, $mess\n";
            return NULL;
        }
    }

    
    
    //*
    //* Runs Latex, and displays resulting pdf.
    //*

    function Latex_PDF($texfilename,$latex,$printpdf=TRUE,$runbibtex=FALSE,$copypdfto=FALSE,$clean=True)
    {
        $texfilename=preg_replace('/&quot;/',"",$texfilename);
        $texfilename=$this->Latex_File_Name($texfilename);

        $path=$this->LatexTmpPath();
        $pdffilename=
            $this->Latex_Run
            (
                $texfilename,
                $this->Latex_Trim($latex),
                $runbibtex
            );

        if (!$this->ApplicationObj()->Latex_PDF_Send)
        {
            $printpdf=False;
        }
        

        $logfilename="$path/latex.log";

        $rpdffilename=$path."/".$pdffilename;
        if ($pdffilename && is_file($rpdffilename))
        {
            if ($printpdf)
            {
                $this->MyMod_Doc_Header_Send("pdf",$pdffilename);

                #Read and send PDF
                echo
                    join("",$this->MyReadFile($path."/".$pdffilename));

                if ($copypdfto)
                {
                    rename($rpdffilename,$copypdfto);
                }
                elseif ($clean)
                {
                    $this->MyFiles_Unlink
                    (
                        array
                        (
                            $path."/".$pdffilename,
                            $path."/".$texfilename,
                            $path."/".preg_replace('/\.tex$/',".log",$texfilename)
                        )
                    );
                }

                exit();
            }
            else
            {
                if ($copypdfto)
                {
                    rename($rpdffilename,$copypdfto);
                }
            
                if ($clean)
                {
                    $this->MyFiles_Unlink
                    (
                        array
                        (
                            $path."/".$texfilename,
                            $path."/".preg_replace('/\.tex$/',".log",$texfilename)
                        )
                    );                    
                }
                
                return $path."/".$pdffilename;
            }
        }
        else
        {
            $this->ApplicationObj->UnSetLatexMode();
            $this->ApplicationObj->MyApp_Interface_Head();

            echo
                "<DIV ALIGN='left'>\n".
                "Error generating latex ($path/$texfilename):".
                $this->BR().
                "Caller 1: ".$this->Caller(1).".".
                $this->BR().
                "Caller 2: ".$this->Caller(2).".".
                $this->BR().
                "Latex Command: ".
                $this->Latex_Command($path,$texfilename).
                $this->BR().
                "";

            if (!file_exists($logfilename))
            {
                $logfilename=$path."/".preg_replace('/\.tex$/',".log",$texfilename);
            }

            if (file_exists($logfilename))
            {
                echo
                    "Logfile: ".$logfilename."<BR>".
                    join("<BR>",$this->MyReadFile($logfilename)).
                    "";
            }
            else
            {       
                echo "No logfile: ".$logfilename."<BR>";
            }

            echo "Arquivo gerado:<BR>";
            $lines=$this->MyReadFile($path."/".$texfilename);
            
            $n=1;
            foreach ($lines as $line)
            {
                $line=preg_replace('/ /',"&nbsp;",$line);
                $nn=sprintf("%04d",$n);
                echo $nn." ".$line."<BR>";
                $n++;
            }

            print "</DIV>";
            exit();
        }

        return $pdffilename;
    }

    //*
    //* Reorganizes latex table.
    //*

    function Latex_Table_Resize_Rows($rows,$nmax)
    {
        $table=array();
        $rrow=array();

        foreach ($rows as $row)
        {
            if (count($rrow)>=$nmax)
            {
                array_push($table,$rrow);
                $rrow=array();
            }
            
            $rrow=array_merge($rrow,$row);
        }

        if (count($rrow)>0)
        {
            if (count($rrow)<$nmax) { array_push($rrow,""); }
            array_push($table,$rrow);
        }

        return $table;
    }
    
    //*
    //* Shows latex code. Runs through \n --> <BR>, etc.
    //*

    function Latex_Code_Show($latex,$linenumbers=False,$exit=True)
    {
        $latex=preg_split('/\n/',$latex);
        $n=1;
        foreach ($latex as $llatex)
        {
            if ($linenumbers)
            {
                echo sprintf("%06d: ",$n++);
            }
            
            echo
                preg_replace('/\s/',"&nbsp;",$llatex).
                "<BR>\n";
        }

        if ($exit) { exit(); }
    }

    //*
    //* Generates mini page environment
    //*

    function Latex_Minipage($latex,$width,$pos="c",$align="",$height="",$units="cm")
    {
        $align=strtolower($align);
            if ($align=="c") { $align="center"; }
        elseif ($align=="l") { $align="flushleft"; }
        elseif ($align=="r") { $align="flushright"; }
        
        if (!empty($height)) { $height="[".$height."cm]"; }

        if (!empty($align))
        {
            $latex=
                $this->LatexEnv($align,$latex,array(),FALSE);
        }
        
        $latex=
            "\\begin{minipage}[".$pos."]".$height."{".$width."cm}\n".
            $latex."\n".
            "\\end{minipage}".
            "";
        

        return $latex;   
    }

   
    //*
    //* .
    //*

    function Latex_FBox_ParBox($latex,$width,$units="cm")
    {
        return
            array
            (
                "\\fbox{\\parbox{".$width.$units."}",
                "{",
                $latex,
                "}}",
            );
    }
    
    //*
    //* .
    //*

    function Latex_Mini_Page($latex,$width,$pos="t",$align="",$units="cm")
    {
        if (!empty($align))
        {
            $latex=$this->LatexEnv($align);
        }
        
        return
            array
            (
                "\\begin{minipage}[".$pos."]{".$width.$units."}",
                $latex,
                "\\end{minipage}",
            );
    }
    
    //*
    //* 
    //*

    function Latex_ScaleBox($scale,$latex)
    {
        return
            array
            (
                "\\scalebox{".$scale."}",
                "{",
                $latex,
                "}",
            );
    }
    
    //*
    //* Trims Latex code.
    //*

    function Latex_Trim($latex=array())
    {
        if (is_array($latex)) { $latex=join("",$latex); }

        $latexfilter=array();
        if (!empty($this->ApplicationObj->LatexFilters))
        {
            foreach ($this->ApplicationObj->LatexFilters as $filter => $hash)
            {
                $rfilter=array();
                if (!empty($this->$filter))
                {
                    $rfilter=$this->$filter;
                }
                elseif (!empty($this->ApplicationObj->$filter))
                {
                    $rfilter=$this->ApplicationObj->$filter;
                }

                $pre=$hash[ "PreKey" ];
                if (!empty($hash[ "Object" ]))
                {
                    $obj=$hash[ "Object" ];

                    if (method_exists($this->ApplicationObj,$obj))
                    {
                        $this->ApplicationObj->$obj()->DatasRead=array_keys($rfilter);
                        $rfilter=
                            $this->ApplicationObj->$obj()->
                            MyMod_Data_Fields_Enums_ApplyAll($rfilter);
                    }
                    else
                    {
                        $this->ApplicationObj->$obj->DatasRead=array_keys($rfilter);
                        $rfilter=
                            $this->ApplicationObj->$obj->
                            MyMod_Data_Fields_Enums_ApplyAll($rfilter);
                    }
                }

                if (!empty($rfilter) && is_array($rfilter))
                {
                    foreach ($rfilter as $key => $value)
                    {
                        $latexfilter[ $pre.$key ]=$value;
                    }
                }
            }
        }

        
        $latex=$this->FilterHash($latex,$latexfilter);
        if (!empty($this->UnitHash))
        {
            $unit=$this->UnitHash;
        }
        elseif (!empty($this->ApplicationObj->UnitHash))
        {
            $unit=$this->ApplicationObj->UnitHash;
        }

        if (!empty($unit))
        {
            $latex=$this->FilterHash($latex,$unit);
        }

        if (
              isset($this->LatexData[ "Filter" ])
              &&
              is_array($this->LatexData[ "Filter" ])
           )
        {
            $latex=$this->FilterHash($latex,$this->LatexData[ "Filter" ]);
        }

        $latex=$this->FilterHash($latex,$this->ApplicationObj()->CompanyHash);
        $latex=$this->FilterObject($latex);


        $latex=preg_replace("/&#0?39;/",'\'',$latex);
        $latex=preg_replace("/&#92;/",'\\\\',$latex);
        $latex=preg_replace("/&#92;/",'\\\\',$latex);
        $latex=preg_replace('/\\#/','!!!!!!',$latex);
        $latex=preg_replace("/&amp;/",'&',$latex);
        $latex=preg_replace("/&nbsp;/",'',$latex);
        $latex=preg_replace('/\\\\"/','"',$latex);
        #$latex=preg_replace('/#/','',$latex);
        //$latex=preg_replace('/%/','\%',$latex);
        $latex=preg_replace('/\r/','',$latex);

        $latex=preg_replace('/!!!!!!/',"#",$latex);
        
        $latex=$this->Html2Text($latex);

        //Must be last - remove remaining html entities.
        $latex=preg_replace('/&[a-zA-Z0-9]+;/','',$latex);

        #print preg_replace('/\n/',"<BR>",$latex);exit();

        return $latex;
    }
}
?>