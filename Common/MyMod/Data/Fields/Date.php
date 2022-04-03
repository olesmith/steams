<?php

trait MyMod_Data_Fields_Date
{
    //*
    //* function MyMod_Data_Field_Date_Edit, Parameter list: ($rdata,$item,$value)
    //*
    //* Creates edit password field.
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Date_Edit($data,$item,$value,$rdata="",$searchfield=False,$tabindex="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $date=0;
        $mon=0;
        $year=0;

        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$value,$matches))
        {
            $year=$matches[1];
            $mon =sprintf("%02d",$matches[2]);
            $date=sprintf("%02d",$matches[3]);

            $value=$date."/".$mon."/".$year;
        }

        $prekey=$rdata;
        $postkey="";
        if ($searchfield)
        {
            $prekey=$this->ModuleName."_".$data;
            $postkey="_Search";
        }

        if ($value==0 || $value=="0") { $value=""; }

        $size=10;
        if (!empty($this->ItemData[ $data ][ "Size" ])) { $size=$this->ItemData[ $data ][ "Size" ]; }


        $options=
            array
            (
                "ID" => $this->MyMod_Data_Field_Input_Edit_ID($data,$item),
                "SIZE" => $size,
            );

        if (!empty($tabindex))
        {
            $options[ "TABINDEX" ]=$tabindex;
        }

        return
            $this->Htmls_Input
            (
                "text",
                $prekey.$postkey,
                $value,
                $options
            );
        
        /* return */
        /*     $this->CreateDateField($rdata,$item,$value); */
    }        
}

?>