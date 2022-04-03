<?php


class ItemLatex extends ItemPostProcess
{



    //*
    //* function  GetLatexSelectFieldRow, Parameter list: $type
    //*
    //* Prints Latex miniformulario for selecting LatexDoc
    //* 
    //*

    function GetLatexSelectFieldRow($type,$form=FALSE)
    {
        $latexdocs=$this->LatexData[ $type."LatexDocs" ][ "Docs" ];
        if (is_array($latexdocs)&& count($latexdocs)>0)
        {
            if ($type=="Singular")
            {
                $row=array
                (
                   $this->H
                   (
                      3,
                      $this->GetMessage($this->LatexDataMessages,"PrintFormTitle").":"
                   )
                );

                foreach ($this->LatexSelectForm($type,$form) as $cell)
                {
                    array_push($row,$this->Center($cell));
                }
            }
            else
            {
                $row=array
                (
                   $this->SPAN
                   (
                      $this->GetMessage($this->LatexDataMessages,"PrintFormTitle").":",
                      array("CLASS" => 'printformtitle')
                   )
                );

                foreach ($this->LatexSelectForm($type,$form) as $cell)
                {
                    array_push($row,$cell);
                }
                array_push($row,"");
            }
    
            return $row;//join("\n",$row);
        }

        return array();
        
    }

    //*
    //* function GenerateLatexHorMenu , Parameter list: $singular=TRUE
    //*
    //* Generates Latex menu of pritables.
    //* 
    //*

    function GenerateLatexHorMenu($item=array())
    {
        $hash=$this->CGI_Query2Hash();

        $hash[ "Action" ]="Search";
        $key="PluralLatexDocs";
        if (!empty($item))
        {
            $key="SingularLatexDocs";
            $paction="Search";
            $hash[ "ID" ]=$item[ "ID" ];
            $hash[ "Action" ]="Latex";
        }
        
        $latexdocs=$this->LatexData[ $key ][ "Docs" ];

        $hrefs=array();
        $n=1;
        if (is_array($latexdocs)&& count($latexdocs)>0)
        {
            foreach ($latexdocs as $latexdoc)
            {
                $hash[ "LatexDoc" ]=$n;
                array_push
                (
                   $hrefs,
                   $this->Href
                   (
                      "?".$this->CGI_Hash2Query($hash),
                      $latexdoc[ "Name" ],
                      "",
                      "",
                      "",
                      "",
                      array
                      (
                         "CLASS" => "printmenu",
                      )
                   )
                );

                $n++;
            }

            return $this->Center
            (
               $this->SPAN("Impressos: ",array("CLASS" => "printmenu")).
               "[ ".
                join(" | ",$hrefs).
                " ]".
                ""
            );
        }

        return "";
        
    }
}
?>