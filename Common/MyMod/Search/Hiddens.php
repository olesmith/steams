<?php


trait MyMod_Search_Hiddens
{
    //*
    //* function MyMod_Search_Hiddens_Hash, Parameter list: 
    //*
    //* Returns hash according to hidden vars defined.
    //*

    function MyMod_Search_Hiddens_Hash()
    {
        $hiddens=array();
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $pre=
                    join
                    (
                        "_",
                        array
                        (
                            $this->ModuleName,
                            $data,
                            "Search",
                        )
                    );
                
                $keys=preg_grep('/^'.$pre.'_?/', array_keys($_POST) );
                foreach ($keys as $key)
                {
                    $value=$this->CGI_POST($key);
                    if (!empty($value))
                    {
                        $hiddens[ $key ]=$this->CGI_POST($key);
                    }
                }
            }
        }
        
        $hiddens[ $this->MyMod_Search_CGI_Include_All_Key() ]=
            $this->MyMod_Search_CGI_Include_All_Value();
        
        return $hiddens;
    }
    
    //*
    //* function MyMod_Search_Hiddens_Fields, Parameter list: 
    //*
    //* Creates hiddens according to search vars defined.
    //*

    function MyMod_Search_Hiddens_Fields()
    {
        $hiddens=array();
        foreach ($this->MyMod_Search_Hiddens_Hash() as $data => $value)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                array_push($hiddens,$this->MakeHidden($rdata,$value));
            }
        }        

        return $hiddens;
    }
 }

?>