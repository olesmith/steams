<?php

trait MyMod_Handle_Add_Table
{
    //*
    //* Creates table for adding data. May be overwritten.
    //*

    function MyMod_Handle_Add_Table($datas,$key="Add",$title="")
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            if ($this->MyMod_Handle_Add_Data_Should($data))
            {
                $rdatas[ $data ]=True;
            }
        }

        $table=array();
        if (count($this->ItemDataSGroups)>0)
        {
            if ($key=="Add")
            {
                return
                    $this->MyMod_Item_Table
                    (
                        1,
                        $this->AddDefaults,
                        $datas
                    );
            }
            
            //Generate a list of tables
            foreach ($this->MyMod_Handle_Edit_SGroups_Get() as $group)
            {
                if
                    (
                        empty($this->ItemDataSGroups[ $group ])
                        ||
                        !empty($this->ItemDataSGroups[ $group ][ "NonAddGroup" ])
                    )
                {
                    continue;
                }


                $datas=array();
                foreach ($this->ItemDataSGroups[ $group ][ "Data" ] as $data)
                {
                    if (!empty($rdatas[ $data ]))
                    {
                        array_push($datas,$data);
                        
                    }
                }
                
                $table=
                    array_merge
                    (
                        $table,
                        $this->MyMod_Item_SGroup_Html_Row
                        (
                            1,
                            $this->AddDefaults,
                            $group,
                            $datas,
                            TRUE,
                            $includename=False,
                            $includecompulsorymsg=True
                        )
                    );
             }
        }
        else
        {
            /* $table= */
            /*     $this->MyMod_Item_Table_PreKey */
            /*     ( */
            /*         1, */
            /*         $this->AddDefaults, */
            /*         1, */
            /*         $rdatas */
            /*     ); */
            $table=
                $this->MyMod_Item_Table
                (
                    1,
                    $this->AddDefaults,
                    $rdatas
                );
        }

        if (!empty($title))
        {
            array_unshift
            (
                $table,
                array
                (
                    $this->H(1,$title)
                )
            );
        }

        return
            array
            (
                $this->Htmls_Table
                (
                    "",
                    $table,
                    array
                    (
                        "ALIGN" => 'center',
                        "BORDER" => 0,
                        "CLASS" => "card",
                    ),
                    array(),
                    array(),
                    TRUE,
                    TRUE
                )
            );
    }
    //*
    //* Creates table for adding data. May be overwritten.
    //*

    function MyMod_Handle_Add_Table_Datas($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            if
                (
                    $this->ItemData($data,"Compulsory")
                    ||
                    $this->ItemData($data,"Add")
                    ||
                    !empty($this->AddFixedValues[ $data ])
                )
            {
                $rdatas[ $data ]=True;
            }
        }

        $datas=array_keys($rdatas);

        return $datas;
    }
 }

?>