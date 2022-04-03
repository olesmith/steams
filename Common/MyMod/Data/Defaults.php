<?php

trait MyMod_Data_Defaults
{
    //*
    //* function MyMod_Data_DefaultDefs, Parameter list: 
    //*
    //* Returns data default definitions.
    //*

    function MyMod_Data_DefaultDefs()
    {
        return array
        (
            "Name"              => "",
            "Name_UK"           => "",
            "ShortName"         => "",
            "ShortName_UK"      => "",
            "LongName"          => "",
            "LongName_UK"       => "",
            "Title"             => "",
            "Title_UK"          => "",
            "Sql"               => "",
            "Unique"            => FALSE,
            "Compound"          => "",

            "Size"              => FALSE,
            "Size_Max"          => "100px",
            "Size_Dynamic"      => True,
            
            "CGIName"           => "",
            
            "Type"              => "",
            "MD5"               => FALSE,
            "Crypt"             => "",  #MD5, BlowFish
            "Hidden"            => FALSE,
            "Password"          => FALSE,
            "TimeType"          => FALSE,
            "Derived"           => FALSE,
            "DerivedFilter"     => "",
            "DerivedNamer"      => "",
            "ConditionalShow"   => "",
            "ReadOnly"          => FALSE,
            "PublicReadOnly"    => FALSE,
            "PersonReadOnly"    => FALSE,
            "AdminReadOnly"     => FALSE,

            "SqlDerivedData"    => array(),
            "SqlData"           => NULL,
            "SqlDerivedNamer"   => "",
            "SqlDisabledMethod" => "",
            "SqlHRefIt"         => FALSE,
            "SqlTextSearch"     => FALSE,
            "SqlObject"         => NULL,
            "SqlClass"          => NULL,
            "SqlMethod"         => NULL,
            "SqlSortReverse"    => FALSE,
            "SqlWhere_Method"   => NULL,
            
            /* "Admin"             => 1, */
            /* "Public"            => 0, */
            /* "Person"            => 0, */

            "Search"            => FALSE,
            "SearchFieldMethod" => "",
            "SearchDefault"     => "",
            "SearchCompound"     => "",
            "SearchCheckBox"     => "",
            "SearchRadioSet"     => "",
            "GETSearchVarName"  => FALSE,
            "NoSearchRow"       => FALSE,
            "NoSearchEmpty"       => FALSE,

            "Default"           => FALSE,
            "Values"            => array(),

            "ValuesMatrix"      => NULL,

            "SortAsDate"        => FALSE,
            "TrimCase"          => FALSE,
            "ToUpper"           => FALSE,
            "ToLower"           => FALSE,
            "Iconify"           => FALSE,
            "Compulsory"        => FALSE,
            "FieldMethod"       => "",  //args: $data,$item,$edit=0,$rdata=$data
            "ShowFieldMethod"   => "",  //args: $data,$item
            "EditFieldMethod"   => "",  //args: $data,$item,$edit=0,$rdata=$data
            "NameFieldMethod"   => "",  //args: $data,$item
            "TitleFieldMethod"  => "",  //args: $data,$item
            "NoAdd"             => FALSE,
            "NoSort"            => FALSE,
            "NoSelectSort"      => True, //default altered 20210116
            "SelectCheckBoxes"  => FALSE,
            "EmptyName"         => "",
            "AltTable"          => FALSE,
            "NamerLink"         => FALSE,
            "MaxLength"         => 0,
            "IconColors"        => "",
            "BkIconColors"      => "",
            "CompulsoryText"    => "",
            "TableSize"         => "",
            "LatexCode"         => FALSE,
            "LatexWidth"        => "",
            "LatexFormat"        => FALSE,
            "HRef"              => "",
            "HRefIt"            => FALSE,
            "HRefIcon"          => "",
            "Iconed"            => "",
            "Format"            => FALSE,
            "IsDate"            => FALSE,
            "IsHour"            => FALSE,
            "ToDayIsDefault"    => FALSE,
            "Info"              => FALSE,
            "IsColor"          => FALSE,
            "IsBarcode"          => FALSE,
            "TabIndex"          => "",
            "PermsMethod"      => "",  // args: $data,$item,$res

            #Messages
            "Comment"      => "",
            "Comment_UK"      => "",
            "Comment_ES"      => "",
            "Comment_Method"      => "",
            
            "AccessMethod" => "", //args: (??$item??)
            "SearchAccessMethod" => "", //args: (??$item??)
            "Search_Order" => 0,
        );

    }


    //*
    //* function MyMod_Datas_AddDefaultKeys, Parameter list: 
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Datas_AddDefaultKeys()
    {
        $defaults=$this->MyMod_Data_DefaultDefs();

        foreach (array_keys($this->ItemData) as $data)
        {
            $this->MyMod_Data_AddDefaultKeys($this->ItemData[ $data ],$defaults);
        }
    }

    //*
    //* function MyMod_Data_AddDefaultKeys, Parameter list: &$data,$defaults=array()
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_AddDefaultKeys(&$data,$defaults=array())
    {
        if (empty($defaults))
        {
            $defaults=$this->MyMod_Data_DefaultDefs();
        }

        $this->MyHash_AddDefaultKeys($data,$defaults);

        //Should read all from DB, unless speecified in Data.php file(s).
        #$this->MyMod_Profiles_AddDefaultKeys($data);
    }

    //*
    //* function MyMod_Data_Add_Default_Init, Parameter list: $hash=array()
    //*
    //* Puts some default values into the AddDefaults array.
    //* Creator is set to LoginID.
    //*

    function MyMod_Data_Add_Default_Init($hash=array())
    {
        foreach ($hash as $data => $value)
        {
            $this->AddDefaults[ $data ]=$value;
        }
        foreach ($this->MyMod_Handle_Add_Fixed() as $data => $value)
        {
            $this->AddDefaults[ $data ]=$value;
        }


        if ($this->LoginType!="Admin" && isset($this->ItemData[ $this->CreatorField ]))
        {
            $this->AddDefaults[ $this->CreatorField ]=$this->LoginData[ "ID" ];
            $this->AddDefaults[ $this->CreatorField."_Value" ]=$this->LoginData[ "Name" ];
        }

        foreach (array_keys($this->ItemData) as $data)
        {
            if
                (
                    $this->ItemData[ $data ][ "Default" ]
                    &&
                    !isset($this->AddDefaults[ $data ])
                )
            {
                $this->AddDefaults[ $data ]=
                    $this->ItemData[ $data ][ "Default" ];
            }

            if
                (
                    isset($this->ItemData[ $data ][ "NoAdd" ])
                    &&
                    $this->ItemData[ $data ][ "NoAdd" ]
                    &&
                    !$this->ItemData[ $data ][ "Compulsory" ]
               )
            {
                unset($this->AddDefaults[ $data ]);
                $this->ItemData[ $data ][ $this->Profile ]=0;
            }

            if ($this->ItemData[ $data ][ "Sql" ]=="INT")
            {
                if (!isset($this->ItemData[ $data ][ "Default" ]))
                {
                    $this->ItemData[ $data ][ "Default" ]=" 0";
                }
            }
        }
    }

}

?>