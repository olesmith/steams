<?php


trait MyMod_Item_Latex
{
    //*
    //* function MyMod_Item_Latex, Parameter list: $item=array()
    //*
    //* Latexifies one item.
    //*

    function MyMod_Item_Latex(&$item,$latexdocno=0)
    {
        //Test access methods and deny if not satified!!! Used individually for each item, should be used overall too.

        $this->Actions();
        $accessmethod=$this->Actions("Print","AccessMethod");

        if (empty($item)) { $item=$this->ItemHash; }

        if ($latexdocno==0)
        {
            $latexdocno=$this->CGI2LatexDocNo();
        }
        
        if
            (
                empty($this->LatexData)
                ||
                empty($this->LatexData[ "SingularLatexDocs" ])
                ||
                empty($this->LatexData[ "SingularLatexDocs" ][ "Docs" ])
                ||
                empty($this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ])
            )
        {
            echo "Latex Info undef: SingularLatexDocs, ".$latexdocno;
            var_dump($this->LatexData[ "SingularLatexDocs" ]);
            exit();
        }

        $latexdef=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ];
        
        if
            (
                !empty($latexdef[ "Latex_Handler" ])
            )
        {
            $handler=$latexdef[ "Latex_Handler" ];

            if (method_exists($this,$handler))
            {
                return
                    $this->$handler
                    (
                        $latexdef,
                        $latexdocno,
                        $item
                    );
            }
            else
            {
                print "No such method: ".$handler."(\$latexdef,\$latexdocno,\$item)\n";
                exit();
            }
        }

        $glue=
            $this->MyMod_Latex_Skel("Singular","Glue",$latexdocno);

        $head=
            $this->MyMod_Latex_Skel
            (
                "Singular","PageHead",$latexdocno,
                True //optional
            );
        
        $tail=
            $this->MyMod_Latex_Skel
            (
                "Singular","PageTail",$latexdocno,
                True //optional
            );

        //See if we need to check access on individual objects
        if ($accessmethod!="")
        {
            if (method_exists($this,$accessmethod))
            {
                if (!$this->$accessmethod($item))
                {
                    return;
                }
            }
        }

        //Preprocessing or read prior to latex generation
        $this->MyMod_Item_Latex_Init($item);
        
        $item[ "No" ]=sprintf("%03d",1);


        $rlatex="";
        if (isset($item[ "LatexPre" ]))
        {
            $rlatex.=$item[ "LatexPre" ];
        }

        //Glue
        $rlatex.=$glue;

        $latex=
            $this->FilterObject
            (
                $this->MyHash_Filter($rlatex,$item)
            );

        //if ($nitems==0) { $latex="Empty Document..."; }
       return
            $this->FilterObject
            (
                $this->MyHash_Filter($head,$item)
            ).
            $latex.
            $this->FilterObject
            (
                $this->MyHash_Filter($tail,$item)
            );

        
        return $latex;
    }
    
    //*
    //* Prepare $item for Latex.
    //*

    function MyMod_Item_Latex_Init(&$item)
    {
        foreach (array_keys($item) as $data)
        {
            if ($this->MyMod_Data_Field_Is_Sql($data))
            {
                $module=$this->MyMod_Data_2Module($data);
                
                $subitem=
                    $module->Sql_Select_Hash
                    (
                        array("ID" => $item[ $data ])
                    );

                $subitem=
                    $module->MyMod_Data_Item_Apply_Enums_Only($subitem,TRUE);

                $this->MyMod_Item_Latex_Init_Take($item,$data,$subitem);
            }
        }
        
        $item=
            $this->MyMod_Data_Item_Apply_Enums_Only($item,TRUE);
        
        $item=
            $this->MyMod_Item_Latex_Trim($item);

        return $item;
    }
   
    //*
    //* Prepare $item for Latex.
    //*

    function MyMod_Item_Latex_Init_Take(&$item,$key,$subitem)
    {
        foreach ($subitem as $data => $value)
        {
            $item[ $key."_".$data ]=$value;
        }                        
    }
    
    //*
    //* Trims all fields of $item, as latex code.
    //* Except fields with keys starting with _, for ex. _Name.
    //*

    function MyMod_Item_Latex_Trim($item=array())
    {
        if  (count($item)==0) { $item=$this->ItemHash; }

        foreach ($item as $key => $value)
        {
            if (!is_string($value)) { continue; }
            
            $value=preg_replace('/(&\s*#039;)/',"'",$value);
            if (isset($this->ItemData[ $key ]))
            {
                if (!empty($this->ItemData[ $key ][ "LatexCode" ]))
                {
                    $value=preg_replace('/&/',"\\&",$value);
                    $value=preg_replace('/\^/',"\\^",$value);
                }

                if (
                      !empty($this->ItemData[ $key ][ "Sql" ])
                      &&
                      $this->ItemData[ $key ][ "Sql" ]=="FILE"
                      &&
                      !is_array($value)
                   )
                {
                    $value=basename($value);
                    $value=preg_replace('/^\./',"",$value);
                }

                if (
                      !empty($this->ItemData[ $key ][ "TimeType" ])
                      &&
                      $this->ItemData[ $key ][ "TimeType" ]==1
                   )
                {
                    $value=$this->TimeStamp2Text($value);
                }

                if (!empty($this->ItemData[ $key ][ "IsHour" ]))
                {
                    $value=$this->CreateHourShowField($key,$item,$value);
                }

                if (!empty($this->ItemData[ $key ][ "LatexFormat" ]))
                {
                    $value=sprintf($this->ItemData[ $key ][ "LatexFormat" ],$value);
                }
            }

            $value=preg_replace('/_/',"\\_",$value);
            $item[ $key ]=$value;
        }

        return $item;
    }

    
    function MyMod_Item_Latex_Table($item=array(),$datalist=array())
    {
        if (count($item)==0) { $item=$this->ItemHash; }

        $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE);
        $item=$this->MyMod_Item_Latex_Trim($item);

        if (!is_array($datalist) || count($datalist)==0)
        {
            $datalist=array_keys($this->ItemData);
        }

        $tbl=array();
        foreach ($datalist as $data)
        {
            $name=$this->ItemData[ $data ][ "Name" ];

            if ($this->ItemData[ $data ][ "Hidden" ]!="") {}
            elseif (preg_match('/[AMC]Time/',$data)) {}
            elseif (
                  preg_match('/^(\S+)_(.+)/',$data,$matches)
                  &&
                  isset($this->ItemData[ $matches[1] ][ "SqlObject" ])
                  &&
                  $this->ItemData[ $matches[1] ][ "SqlObject" ]!=""
                  &&
                  isset($this->ItemData[ $matches[2] ][ "Name" ])
                )
            {
                $object=$this->ItemData[ $matches[1] ][ "SqlObject" ];

                $name=$this->$object->ItemData[ $matches[2] ][ "Name" ];
                $value=$item[ $data ];
                array_push($tbl,array("\\textbf{".$name.":}",$value));
            }
            else
            {   
                $access=$this->MyMod_Data_Access($data,$item);
                if ($access>=1)
                {
                    if (isset($this->ItemData[ $data ][ "LongName" ]))
                    {
                        $name=$this->ItemData[ $data ][ "LongName" ];
                    }
                    else
                    {
                        $name=$this->ItemData[ $data ][ "Name" ];
                    }

                    $value=$item[ $data ];
                    array_push($tbl,array("\\textbf{".$name.":}",$value));
                }
            }
        }

        return $tbl;
    }

    
    function MyMod_Item_Latex_Table_Print($title,$item=array(),$noid=0,$rdatalist=array())
    {
        $this->ApplicationObj->LogMessage
        (
            "MyMod_Item_Latex_Table_Print",
            $item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item)
        );
        $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item); 
        $title=$this->ItemName.": ".$this->MyMod_Item_Name_Get($item);

        $this->LatexData[ "PageTitle" ]="\\begin{Large}\n".$title."\n\\end{Large}\n\n\\vspace{0.25cm}";
        $this->LatexData[ "NItemsPerPage" ]=50;

        $tbl=$this->MyMod_Item_Latex_Table($item,$noid,$rdatalist);
        $latex=
            $this->Latex_Head().
            "\\begin{center}\n".
            $this->LatexTable("",$tbl).
            "\\end{center}\n".
            $this->Latex_Tail();

        $latex=$this->Latex_Trim($latex);

        $texfile="Item.".$this->ModuleName.".".time().".tex";
        return $this->Latex_PDF($texfile,$latex);
    }

    
    //*
    //* Generates Latex code item from DB. Based on skeleton in
    //* value returned by $this->GetSingularLatexDoc().
    //*

    function Item_Latex($item=array())
    {
        $this->LatexData();

        if  (count($item)==0) { $item=$this->ItemHash; }

        $latexdocno=$this->CGI2LatexDocNo();
        $latexinfo=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];
        if (!empty($latexinfo[ "PreMethod" ]))
        {
            $preprocessmethod=$latexinfo[ "PreMethod" ];
            $item=$this->$preprocessmethod($item);
        }


        $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE);
        $item=$this->MyMod_Item_Latex_Trim($item);
        $latex=$this->GetSingularLatexDoc();

        $latex=$this->Filter($latex,$item);
        $latex=$this->FilterObject($latex);

        return $latex;
    }
}

?>