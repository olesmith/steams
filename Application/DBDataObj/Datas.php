<?php


trait DBDataObj_Datas
{
    //*
    //* Reads item data defs from Datas - and adds to $this->ItemData.
    //* Should be called by PostProcessItemData(), before SQL table structure update.
    //*

    function ReadDBData($quests)
    {
        $this->ItemData("ID");
        
        $skew=array
        (
           "SqlDef" => "Sql",
           "SqlDefault" => "Default",
           /* "Text" => "Name", */
           /* "Text_UK" => "Name_UK", */
           /* "SValues" => "Values", */
           /* "SValues_UK" => "Values_UK", */
        );

        $listvars=array
        (
           "SValues"    => 1,
           "SValues_UK" => 1,
           "Extensions" => 1,
        );

        $newdef=array
        (
           "Public" => 0,
           "Person" => 0,
           "Admin" => 2,
           "Coordinator" => 2,
           "No_DB_Messages" => True,
           "Certificate_Filter_Data" => True,
        );

        $this->DatasData=array();

        foreach ($quests as $quest)
        {
            $data=$quest[ "SqlKey" ];

            $this->ItemData[ $data ]=$newdef;
            foreach ($quest as $key => $value)
            {
                if ($key=="ID") { continue; }
                $rkey=$key;
                if (!empty($skew[ $key ])) { $rkey=$skew[ $key ]; }

                if (!empty($listvars[ $key ]))
                {
                    $value=preg_split('/\s*,\s*/',$value);
                }



                $this->ItemData[ $data ][ $rkey ]=$value;
            }

            $this->ItemData[ $data ][ "Name" ]=
                $quest[ "Text_".$this->Language() ];
            if (empty($this->ItemData[ $data ][ "Name" ]))
            {
                $this->ItemData[ $data ][ "Name" ]=
                    $quest[ "Text_".
                    $this->ApplicationObj()->Language_Default() ];
            }

            $this->MyMod_Data_AddDefaultKeys($this->ItemData[ $data ]);

            //AREA
            $size=$quest[ "Width" ];
            if ($quest[ "Type" ]==6) { $size.="x".$this->ItemData[ $data ][ "Height" ]; }
            $this->ItemData[ $data ][ "Size" ]=$size;

            //SELECT
            if ($quest[ "Type" ]==2)
            {
                $this->ItemData[ $data ][ "NoSelectSort" ]=TRUE;

                $values=$quest[ "SValues_".$this->Language() ];
                if (empty($values))
                {
                    $values=$quest[ "SValues_".$this->Default_Language() ];
                }

                $this->ItemData[ $data ][ "Values" ]=preg_split('/\s*,\s*/',$values);
            }

            //File
            if ($quest[ "Type" ]==3)
            {
                $this->ItemData[ $data ][ "Icon" ]="download_light.svg";
                $extensions=array("pdf");
                if (!empty($quest[ "Extensions" ]))
                {
                    $extensions=$quest[ "Extensions" ];
                }
                
                $this->ItemData[ $data ][ "Extensions" ]=$extensions;
            }
            
            //Info
            if ($quest[ "Type" ]==8)
            {
                $this->ItemData[ $data ][ "Info" ]=$quest[ "SqlDefault" ];
            }
            
            //Search
            if (intval($quest[ "SqlSearch" ])==2)
            {
                $this->ItemData[ $data ][ "Search" ]=TRUE;
            }
            
            foreach (array("Friend","Assessor","Compulsory") as $key)
            {
                if (!empty($this->ItemData[ $data ][ $key ]))
                {
                    $this->ItemData[ $data ][ $key ]=$this->ItemData[ $data ][ $key ]-1;
                }
            }

            array_push($this->DatasData,$data);
        }
    }

    //*
    //* Returns quest data of file type.
    //*

    function DBDataFileDatas()
    {
        $fdatas=
            array
            (
                "No","Edit","Delete","Zips",
                "CTime",
                "Friend","Status","Complete",
                "Homologated","Result","Selected");
        foreach ($this->DatasData as $data)
        {
            if ($this->MyMod_Data_Field_Is_File($data))
            {
                array_push($fdatas,$data);
            }
        }

        return $fdatas;
    }
}

?>