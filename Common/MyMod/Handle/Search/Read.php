<?php

trait MyMod_Handle_Search_Read
{
    //*
    //* Reads items
    //*

    function MyMod_Handle_Search_Items_Read
        (
            $where,$datas,
            $nosearches=FALSE,$nopaging=FALSE
        )
    {
        if (count($this->ItemHashes)==0)
        {
            if ($where=="")
            {
                $this->MyMod_Items_Read("",$datas,$nosearches);
            }
            else
            {
                $this->MyMod_Items_Read($where,$datas,$nosearches,$nopaging);
            }
        }
    }
    
    //*
    //* Detects which data to actually read.
    //*

    function MyMod_Handle_Search_Items_Read_Datas($datas=array(),$nosearches=FALSE,$sep="")
    {
        if
            (
                $this->MyMod_Search_Options_Export_CGI_Value()>=4
            ) { return array_keys($this->ItemData); }

        $group=$this->MyMod_Data_Group_Actual_Get();
        if (count($datas)==0)
        {
            $datas=$this->MyMod_Data_Group_Datas_Get($group);

            if (
                isset($this->ItemDataGroups[ $group ])
                &&
                count($this->ItemDataGroups[ $group ][ "SubTable" ])>0
               )
            {
                $subdatas=$this->CheckHashKeysArray
                (
                   $this->ItemDataGroups[ $group ][ "SubTable" ],
                   array($this->Profile."_Data",$this->LoginType."_Data","Data")
                );

                $count=$this->ItemDataGroups[ $group ][ "SubTable" ][ "Max" ];
                for ($i=1;$i<=$count;$i++)
                {
                    $crow=array();
                    foreach ($subdatas as $data)
                    {
                        array_push($datas,$data.$sep.$i);
                    }
                }
            }
        }

        if (!$nosearches)
        {
            $datas=$this->MyMod_Search_Vars_Add_2_List($datas);
        }

        $datas=$this->MyMod_Sort_Vars2Data($datas);

        //Always read IDs
        if (!preg_grep('/^ID$/',$datas))
        {
            array_unshift($datas,"ID");
        }

        //Other data that we should always read - to be set by specific module
        foreach ($this->AlwaysReadData as $id => $data)
        {
            if (!preg_grep('/^'.$data.'$/',$datas)) { array_unshift($datas,$data); }
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (
                isset($this->ItemData[ $data ])
                &&
                is_array($this->ItemData[ $data ])
                &&
                empty($this->ItemData[ $data ][ "Derived" ])
               )
            {
                if (empty($this->ItemFieldMethods[ $data ]))
                {
                    array_push($rdatas,$data);
                }
            }

            if (!empty($this->ItemData[ $data ][ "Languaged" ]))
            {
                foreach ($this->MyMod_Languaged_Data_Get($data) as $langdata)
                {
                    array_push($rdatas,$langdata);          
                }
            }
        }

        if (!empty($this->ItemDataGroups[ $group ][ "Data_Read" ])>0)
        {
            $rdatas=
                array_merge
                (
                    $rdatas,
                    $this->ItemDataGroups[ $group ][ "Data_Read" ]
                );
        }
 
        $this->DatasRead=$rdatas;

        return $rdatas;
    }
 }

?>