<?php

include_once("Latex/Files.php");


trait MyMod_Latex
{
    use MyMod_Latex_Files;

    var $MyMod_Latex_CGI_DocNo="LatexDoc";
    
    //*
    //* Creates row with item cells.
    //*

    function MyMod_Latex_Read()
    {
        foreach ($this->MyMod_Latex_Files_Get() as $file)
        {
            if (file_exists($file))
            {
                $this->MyMod_Latex_Add_File($file);
            }
        }
    }
    
    function MyMod_Latex_Skel_Path()
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

    function MyMod_Latex_Skel_Read($latexdoc,$comment=FALSE)
    {
        $latex="";

        $latexdocs=$latexdoc;
        if (!is_array($latexdocs)) { $latexdocs=array($latexdocs); }

        $path=$this->MyMod_Latex_Skel_Path();
        $path=preg_replace('/#Setup/',$this->ApplicationObj->SetupPath,$path);
        $path=preg_replace('/#Module/',$this->ModuleName,$path);

        foreach ($latexdocs as $latexdoc)
        {
            $latexdoc=
                preg_replace
                (
                    '/#Setup/',
                    $this->ApplicationObj->SetupPath,$latexdoc
                );
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
    //* function MyMod_Latex_Skel, Parameter list: $type,$skel,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Skel($type,$skel,$latexdocno=0,$optional=False)
    {
        if (empty($this->LatexData))
        {
            $this->LatexData();
        }

        
        $latex="%%! $skel $type:$skel not found\n";
        if
            (
                !empty
                (
                    $this->LatexData
                    [ $type."LatexDocs" ][ "Docs" ]
                    [ $latexdocno ][ $skel ]
                )
            )
        {
            $latex=
                $this->MyMod_Latex_Skel_Read
                (
                    $this->LatexData
                    [ $type."LatexDocs" ][ "Docs" ]
                    [ $latexdocno ][ $skel ]
                );
        }
        elseif (!$optional)
        {
            var_dump
            (
                "Latex skel $type, $skel not found: $latexdocno",
                $this->LatexData[ $type."LatexDocs" ],
                $this->LatexData
            );
            exit();
        }
        
        return $latex;
    }
    
    //*
    //* functionMyMod_Latex_Head , Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Head($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Head",$latexdocno);
    }

    //*
    //* function MyMod_Latex_Glue, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Glue($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Glue",$latexdocno);
    }

    //*
    //* function GetLatexTail, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Tail($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Tail",$latexdocno);
    }

    //*
    //* Retrieves LatexDoc (no) from CGI environment.
    //* 

    function MyMod_Latex_DocNo()
    {
        $latexdoc=
            $this->GetGETOrPOST($this->MyMod_Latex_CGI_DocNo);
        if ($latexdoc=="" || $latexdoc<=0) { $latexdoc=1; }

        return $latexdoc-1;
    }
    
    //*
    //* Retrieves LatexDoc (no) from CGI environment.
    //* 

    function MyMod_Latex_Data_Key($latexdocno,$key,$type="Plural",$default="")
    {
        $value=$default;
        if
            //Individual latex doc
            (
                !empty
                (
                    $this->LatexData
                    [ $type."LatexDocs" ][ "Docs" ]
                    [ $latexdocno ][ $key ]
                )
            )
        {
            $value=
                $this->LatexData
                [ $type."LatexDocs" ][ "Docs" ]
                [ $latexdocno ][ $key ];
        }
        elseif
            //All latex doc
            (
                !empty
                (
                    $this->LatexData
                    [ $type."LatexDocs" ][ $key ]
                )
            )
        {
           $value =
                $this->LatexData
                [ $type."LatexDocs" ][ $key ];
        }

        return ;
    }
    
    //*
    //* Retrieves LatexDoc (no) from CGI environment.
    //* 

    function MyMod_Latex_ItemsPerPage($latexdocno,$type="Plural",$key="ItemsPerPage")
    {
        return
            $this->MyMod_Latex_Data_Key
            (
                $latexdocno,$key,
                $type,
                40
            );
    }
}

?>