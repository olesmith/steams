<?php


trait MyMod_Item_PreKey
{
    //*
    //* Creates row with item cells, with Pre CGI key..
    //*

    function MyMod_Item_PreKey_Row($edit,$item,$data,&$compulsories=0,$row=array(),$plural=FALSE,$precgikey="")
    {
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));
        $access=$this->MyMod_Data_Access($data,$item);

        $rdata="";
        if ($plural) { $rdata=$item[ "ID" ]."_".$data; }
        if ($precgikey) { $rdata=$precgikey.$rdata; }

        if ($access>=1)
        {
            $value="";
            if ($access==1)
            {
                $value=$this->MyMod_Data_Fields_Show($data,$item);
            }
            else
            {
                $value=$this->MyMod_Data_Fields($edit,$item,$data,$plural,"",$rdata);
            }

            #Make sure $value is an array.
            if (!is_array($value)) { $value=array($value); }
            

            $key=$data."_Message";
            if
                (
                    !$this->LatexMode()
                    &&
                    $this->LoginType!="Public"
                    &&
                    !empty($item[ $key ])
                )
            {
                $rvalue=$item[ $key ];
                $msg=
                    $this->FONT
                    (
                        $rvalue,
                        array("CLASS" => 'errors')
                    );
                array_push
                (
                    $value,
                    $this->Htmls_SPAN
                    (
                        $rvalue,
                        array("CLASS" => 'errors')
                    )
                );
                
            }

            $action=$this->MyActions_Detect();
            $add="";
            if (
                $this->ItemData[ $data ][ "Compulsory" ] &&
                $edit==1
               )
            {
                $add=$dagger;
                $compulsories++;
            }

            if (
                $access==2
                &&
                $this->ItemData[ $data ][ "Sql" ]=="INT"
                &&
                $this->ItemData[ $data ][ "IsDate" ]
                &&
                (
                    empty($item[ $data ])
                    ||
                    !preg_match('/^\d{8}$/',$item[ $data ])
                )
               )
            {
                if (!is_array($value)) { $value=array($value); }
                array_push
                (
                    $value,
                    "DD/MM/YYYY"
                );
            }

            $class='data';
            if ($edit) { $class='editdata'; }
            
            array_push
            (
               $row,
               $this->DecorateDataTitle
               (
                  $this->MyMod_Item_Cell_Name($edit,$data),
                  $this->MyMod_Item_Cell_Title_Or_Name($edit,$data),
                  TRUE
               ).
               $add,
               
               $this->Htmls_SPAN($value,array("CLASS" => $class))
            );
        }

        return $row;
        
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Cell_Title_Or_Name($edit,$data)
    {
        ###$title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyTitle);
        $title=$this->LanguagesObj()->Language_Data_Title_Get($this,$data);
        
        if (empty($title)) { $title=$this->MyMod_Item_Cell_Name($edit,$data); }
        
        if (
              $this->ItemData[ $data ][ "Compulsory" ]
              &&
              $this->LoginType!="Public"
              &&
              $edit==1
              &&
              empty($item[ $data ])
            )
        {
            $title.=
                " - ".
                $this->MyLanguage_GetMessage("CompulsoryFieldTag")."!";
        }

        return $title;
    }
    

}

?>