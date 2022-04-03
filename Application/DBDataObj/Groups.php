<?php


trait DBDataObj_Groups
{
    //*
    //* function ReadDBGroups, Parameter list: $groups,$commonpdatas=array()
    //*
    //* Reads item data defs from Quest - and adds to $this->ItemData.
    //*

    function ReadDBGroups($groups,$commonpdatas=array())
    {
        $this->ItemDataGroups();

        $skew=array
        (
           "Text_PT" => "Name",
           "Text_UK" => "Name_UK",
           "Text_ES" => "Name_ES",
        );

        $listvars=array
        (
        );

        $newdef=array
        (
           "Public"         => 0,
           "Person"         => 0,
           "Admin"          => 2,
           "Coordinator"    => 2,
           "No_DB_Messages" => True,
        );

        $this->ItemDataGroups[ "Files" ]=array
        (
            "Name"        => $this->MyLanguage_GetMessage("Files"),
            "Title"       => $this->MyLanguage_GetMessage("Files"),
          
            "Public"      => 0,
            "Person"      => 0,
            "Admin"       => 2,
            "Coordinator" => 2,
            "Data"        => $this->DBDataFileDatas(),           
        );

        $this->DatasGroups=array();

        $sgroups=$this->ItemDataSGroups;
        $this->ItemDataSGroups=array();

        $n=1;
        foreach ($groups as $group)
        {
            $def=$newdef;
            foreach ($group as $key => $value)
            {
                if ($key=="ID") { continue; }

                $rkey=$key;
                if (!empty($skew[ $key ])) { $rkey=$skew[ $key ]; }

                if (!empty($listvars[ $key ]))
                {
                    $value=preg_split('/\s*,\s*/',$value);
                }

                $def[ $rkey ]=$value;
            }

            $this->MyMod_Data_Group_Defaults_Take($def);

            $def[ "Friend" ]=$group[ "Friend" ]-1;
            if (!empty($def[ "Assessor" ]))
            {
                $def[ "Assessor" ]=$group[ "Assessor" ]-1;
            }

            $def[ "Data" ]=$this->DatasObj()->Sql_Select_Unique_Col_Values
            (
               "SqlKey",
               array("DataGroup" => $group[ "ID" ]),
               array("SortOrder","ID")
            );

            $nn=1;
            foreach ($def[ "Data" ] as $data)
            {
                foreach ($this->LanguageKeys() as $lang)
                {
                    foreach (array("Name","Title") as $key)
                    {
                        if (!empty($this->ItemData[ $data ][ $key.$lang ]))
                        {
                            $this->ItemData[ $data ][ $key.$lang ]=
                                //$nn.": ".
                                $this->ItemData[ $data ][ $key.$lang ];
                        }
                    }
                }

                $nn++;
            }

            if ($group[ "Singular" ]==2)
            {
                $this->ItemDataSGroups[ $group[ "ID" ] ]=$def;
                $this->ItemDataSGroups[ $group[ "ID" ] ][ "Data" ]=$def[ "Data" ];
                $this->ItemDataSGroups[ $group[ "ID" ] ][ "File" ]="DB";
                $this->ItemDataSGroups[ $group[ "ID" ] ][ "__Name__" ]=$group[ "ID" ];
                if (isset($group[ "Text_".$this->LanguagesObj()->Language ]))
                {
                    $this->ItemDataSGroups[ $group[ "ID" ] ][ "Name" ]=
                        $group[ "Text_".$this->LanguagesObj()->Language ];
                }
            }

            foreach ($this->LanguageKeys() as $lang)
            {
                foreach (array("Name","Title") as $key)
                {
                    if (!empty($def[ $key.$lang ]))
                    {
                        $def[ $key.$lang ]=$def[ $key.$lang ];
                    }
                }
            }

            if ($group[ "Plural" ]==2)
            {
                $this->ItemDataGroups[ $group[ "ID" ] ]=$def;
                $this->ItemDataGroups[ $group[ "ID" ] ][ "PreMethod" ]="Leading_Show_Only";
                $this->ItemDataGroups[ $group[ "ID" ] ][ "ShowData" ]=$commonpdatas;
                $this->ItemDataGroups[ $group[ "ID" ] ][ "Data" ]=$def[ "Data" ];
                $this->ItemDataGroups[ $group[ "ID" ] ][ "File" ]="DB";
                $this->ItemDataGroups[ $group[ "ID" ] ][ "__Name__" ]=$group[ "ID" ];
                if (isset($group[ "Text_".$this->LanguagesObj()->Language ]))
                {
                    $this->ItemDataGroups[ $group[ "ID" ] ][ "Name" ]=
                        $group[ "Text_".$this->LanguagesObj()->Language ];
                }
            }
            
            
            array_push($this->DatasGroups,$group[ "ID" ]);
        }
            
        $this->ItemDataSGroups=array_merge($this->ItemDataSGroups,$sgroups);
    }
}

?>