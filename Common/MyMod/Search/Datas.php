<?php


trait MyMod_Search_Datas
{
    
    //*
    //* function MyMod_Search_Data_May, Parameter list: 
    //*
    //* Decides whether we 'may' show $data.
    //*
    
    function MyMod_Search_Data_May($data)
    {
        $access=$this->MyMod_Data_Access($data);

        $res=False;
        if ($access>=1) { $res=True; }
        
        if
            (
                $res
                &&
                !empty($this->ItemData[ $data ])
                &&
                isset($this->ItemData[ $data ][ "Search_".$this->Profile() ])
            )
        {
            $res=$this->ItemData[ $data ][ "Search_".$this->Profile() ];
        }

        return $res;
    }
    
    //*
    //* Returns ordered list of datas to put in Search Vars Table.
    //* May be overriden.
    //*
    
    function MyMod_Search_Datas_Get($details=False)
    {
        $datas=
            $this->MyHash_Order_Hashes_Keys
            (
                $this->ItemData,
                "Search_Order",
                "Search"
            );

        if ($details)
        {
            $rdatas=array();
            foreach ($datas as $data)
            {
                $value=$this->ItemData($data,"Search_Details");
                if (!empty($value)) { array_push($rdatas,$data); }
            }

            //Omit AMCTime's
            $rdatas=preg_grep('/^[AMC]Time$/',$rdatas,PREG_GREP_INVERT);
            
        }
        else
        {
            $rdatas=array();
            foreach ($datas as $data)
            {
                $value=$this->ItemData($data,"Search_Details");
                if (empty($value)) { array_push($rdatas,$data); }
            }
        }

        return $rdatas;
    }

    //*
    //* Retrieves GET vars from Search.
    //* Disables in ItemData[ $data ] if $remove is true.
    //*
    
    function MyMod_Search_Datas_GETs($remove=False)
    {
        #GET vars;
        $gets=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (isset($_GET[ $data ]))
            {
                $gets[ $data ]=$this->CGI_GET($data);
                if ($remove)
                {
                    $this->ItemData[ $data ][ "Search" ]=False;
                }
            }
        }

        return $gets;
    }


}

?>