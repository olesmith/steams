<?php


trait MyMod_Item_Print
{
    //*
    //* Print one file name.
    //*

    function MyMod_Item_Print_FileName($item,$docno=0)
    {        
        if ($docno==0)
        {
            $docno=$this->CGI2LatexDocNo();
        }

        return
            preg_replace
            (
                '/\s+/',
                "_",
                $this->ApplicationObj()->MyApp_Name().
                ".".
                $this->MyMod_ItemName().
                "-".
                $this->MTime2FName().
                ".tex"
            );
    }
    
    //*
    //* Prints $item.
    //*

    function MyMod_Item_Prints($item=array())
    {
        $this->LatexData();

        if (empty($item))
        {
            $item=$this->ItemHash;
        }
        
        $pdffiles=array();
        $docno=-1;
        foreach
            (
                $this->LatexData[ "SingularLatexDocs" ][ "Docs" ]
                as $doc
            )
        {
            $docno++;
            
            $include=$this->CGI_POSTint("Include_".($docno+1));
            if ($include!=1)
            {
                continue;
            }

            $pdffile=
                $this->Latex_PDF
                (
                    $this->MyMod_Item_Print_FileName($item,$docno),
                    $this->MyMod_Item_Print_Latex($item,$docno),
                    False  //do not send PDF (nor exit)
                );

            array_push($pdffiles,$pdffile);
        }
        
        return $pdffiles;        
    }
    
    //*
    //* Prints $item.
    //*

    function MyMod_Item_Print($item=array(),$docno=0)
    {
        if  (empty($item)) { $item=$this->ItemHash; }

        //Must be first, to ensure changes to $item
        //done in MyMod_Item_Print_Latex,
        //reflected in MyMod_Item_Print_FileName
        
        $latex=
            $this->MyMod_Item_Print_Latex($item,$docno);

        
        $doc=$this->LatexDoc("SingularLatexDocs",$docno);
        if (!empty($doc[ "Debug" ]))
        {
            //Debugging activated from Module LatexData setupfile.
            var_dump($this->MyMod_Item_Print_FileName($item));
            $this->Latex_Code_Show($latex);
            exit();
        }
        
        return
            $this->Latex_PDF
            (
                $this->MyMod_Item_Print_FileName($item,$docno),
                $latex
            );
    }
    
    //*
    //* Adds Head and Tail
    //*

    function MyMod_Item_Print_Latex(&$item,$docno)
    {
        return
            $this->FilterObject
            (
                $this->MyHash_Filter
                (
                    $this->MyMod_Latex_Head
                    (
                        "Singular",
                        $docno
                    ),
                    $item
                )
            ).
            $this->MyMod_Item_Latex($item,$docno).
            $this->FilterObject
            (
                $this->MyHash_Filter
                (
                    $this->Latex_Tail
                    (
                        "Singular",
                        $docno
                    ),
                    $item
                )
            );
    }
}

?>