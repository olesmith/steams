<?php


trait Teams_CLI
{
    //*
    //* Postprocesses and returns $item.
    //*

    function Teams_CLI()
    {
        foreach
            (
                $this->Sql_Select_Hashes()
                as $team
            )
        {
            $this->Team_CLI($team);
        }
    }
    
    //*
    //* Postprocesses and returns $item.
    //*

    function Team_CLI($team)
    {
        if ($team[ "Type" ]==2)
        {
            $updatedatas=$this->Team_CLI_National($team);
        }
        else
        {
            $updatedatas=$this->Team_CLI_Club($team);
        }
        
        if (count($updatedatas)>0)
        {
            print $team[ "ID" ].": ".join(",",$updatedatas)."\n";

            
            $this->Sql_Update_Item_Values_Set($updatedatas,$team);
        }
        //else { print $team[ "ID" ].": OK\n"; }
    }
    
    //*
    //* Postprocesses and returns $item.
    //*

    function Team_CLI_National(&$item)
    {
        $datas=array();
        foreach (array("Name","Title") as $data)
        {
            foreach (array("UK","PT","ES") as $lang)
            {
                array_push($datas,$data."_".$lang);
            }
        }
        
        $country=
            $this->CountriesObj()->Sql_Select_Hash
            (
                array("Initials" => $item[ "Initials_UK" ])
            );

        if (empty($country))
        {
            $country=
                $this->CountriesObj()->Sql_Select_Hash
                (
                    array("Name_PT" => $item[ "Name_PT" ])
                );
        }
        
        if (empty($country))
        {
            return array();
        }
        

        
        $updatedatas=array();
        foreach ($datas as $data)
        {
            if
                (
                    isset($item[ $data ])
                    &&
                    (
                        empty($item[ $data ])
                        ||
                        $item[ $data ]!=$country[ $data ]
                    )
                )
            {
                $item[ $data ]=$country[ $data ];
                
                array_push($updatedatas,$data);
            }
        }

        if ($item[ "Country" ]!=$country[ "ID" ])
        {
            $item[ "Country" ]=$country[ "ID" ];
            array_push($updatedatas,"Country");
        }
        
        $path="/usr/local/STeams/";
        $infile=$path.$country[ "Flag" ];
        $outfile=$path.$item[ "Icon" ];

        system("ls -l $infile $outfile");
        system("cp -p $infile $outfile");
        
        print "$infile --> $outfile\n";
        
        return $updatedatas;
    }

            
    //*
    //* Postprocesses and returns $item.
    //*

    function Team_CLI_Club(&$item)
    {
        $updatedatas=array();
        foreach (array("PT","UK","ES") as $lang)
        {
            if
                (
                    empty($item[ "Title_".$lang ])
                    &&
                    !empty($item[ "Name_".$lang ])
                )
            {
                $item[ "Title".$lang ]=$item[ "Name_".$lang ];
                array_push($updatedatas,"Title_".$lang);
            }
        }
        
        foreach (array("ES","UK") as $lang)
        {
            foreach (array("Name","Title","Initials") as $data)
            {
                if
                    (
                        empty($item[ $data."_".$lang ])
                        &&
                        !empty($item[ $data."_PT" ])
                    )
                {
                    $item[ $data."_".$lang ]=$item[ $data."_PT" ];
                    array_push($updatedatas,$data."_".$lang);
                }
            }
        }

        if ($item[ "Country" ]!=31)
        {
            $item[ "Country" ]=31;
            array_push($updatedatas,"Country");
        }

        return $updatedatas;
    }
}

?>