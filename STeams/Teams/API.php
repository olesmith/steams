<?php


trait Teams_API
{
    //*
    //* 
    //*

    function Team_API_Retrieve(&$team)
    {
        $result=
            $this->Team_API_cURL($team);

        //var_dump($result);
        
        $updatedatas=array();
        if ($this->Team_API_Test($team,$result))
        {
            $json=json_decode($result,TRUE);
            $updatedatas=$this->Team_API_Update($team,$json);

            if (count($updatedatas)>=0)
            {
                $team[ "API_Result" ]=$result;
                $team[ "API_Status" ]=3;
                $team[ "API_Last" ]=time();

                array_push($updatedatas,"API_Last","API_Result","API_Status");
            }
            
        }
        elseif ($team[ "API_Status" ]!=2)
        {
            $team[ "API_Result" ]=$result;
            $team[ "API_Status" ]=2;
            $team[ "API_Last" ]=time();

            array_push($updatedatas,"API_Last","API_Result","API_Status");
        }

        if (count($updatedatas)>0)
        {
            
            $this->Sql_Update_Item_Values_Set($updatedatas,$team);
        }
    }
    
    //*
    //* 
    //*

    function Team_API_cURL($team)
    {
        return
            $this->ApplicationObj()->MyApp_CLI_APIs_cURL
            (
                "http://api.football-data.org/v2/teams/".
                $team[ "API_ID" ]
            );
            
    }
    
    //*
    //* 
    //*

    function Team_API_Test($team,$result)
    {
        return preg_match('/\"id\"/',$result);
            
    }
    
    //*
    //* 
    //*

    function Team_API_Update(&$item,$json)
    {
        $updatedatas=array();
        foreach ($this->Teams_API_Hash() as $data => $keys)
        {
            $value=$json;
            foreach ($keys as $key)
            {
                if (isset($value[ $key ]))
                {
                    $value=$value[ $key ];
                }
            }

            if (!is_array($value))
            {
                $item[ $data ]=
                    preg_replace
                    (
                        '/\'/',"&#39;",
                        $this->Text2Html($value)
                    );
            }
        }

        $hash=
            array
            (
                "Country"   => $this->Tournament("Country"),
                "Continent" => $this->Tournament("Continent"),
                
            );

        foreach ($hash as $data => $value)
        {
            if
                (
                    !empty($value)
                    &&
                    empty($item[ $data ])
                )
            {
                $item[ $data ]=$value;
                
                array_push($updatedatas,$data);
            }
        }

        $data="Country";
        if (empty($item[ $data ]))
        {
            $country_api=$json[ 'area' ][ 'name' ];

            $country=
                $this->CountriesObj()->Sql_Select_Hash
                (
                    array
                    (
                        "__Name__" => "Name_UK LIKE '%".$country_api."%'",
                    ),
                    array("ID")
                );

            if (!empty($country))
            {
                $item[ $data ]=$country[ "ID" ];
                array_push($updatedatas,$data);
            }
            else
            {
                print "Empty country: '".$country_api."'\n";
            }
        }
        
        return $updatedatas;
    }

    
    //*
    //* Returns Hash with $data -> $api_key's.
    //* Based on Matches::ItemData 'Key's.
    //*

    function Teams_API_Hash()
    {
        $hash=array();
        foreach (array_keys($this->ItemData()) as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Key" ]))
            {
                $hash[ $data ]=
                    $this->ItemData[ $data ][ "Key" ];
                
                if (!is_array($hash[ $data ]))
                {
                    $hash[ $data ]=array($hash[ $data ]);
                }
            }
        }

        return $hash;
    }  

}

?>