<?php

trait Pool_Bets_Round_Update
{
    //*
    //* 
    //*

    function Pool_Bet_Round_Update($match,$pool_friend,&$bet)
    {
        if
            (
                $this->Pool_Bets_Round_Edit($bet,$match)!=1
                ||
                $this->CGI_POSTint("Save")!=1
            )
        {
            return False;
        }
        
        $base="Goals";
        $updatedatas=array();
        for ($n=1;$n<=2;$n++)
        {
            $key=$base.$n;
            $cgi_key=$bet[ "ID" ]."_".$base.$n;
            $cgi_value=$this->CGI_POST($cgi_key);
            if ($cgi_value=="-")
            {
                //continue;
            }

            //var_dump($bet[ "ID" ]." - ".$bet[ $key ].": ".$cgi_value);
            if ($bet[ $key ]!=$cgi_value)
            {
                $bet[ $key ]=$cgi_value;
                array_push($updatedatas,$key);
            }
        }

        //var_dump($updatedatas);
        if (count($updatedatas)>0)
        {
            $bet[ "MTime" ]=time();
            array_push($updatedatas,"MTime");
            //var_dump($updatedatas);
            $this->Sql_Update_Item_Values_Set($updatedatas,$bet);
            
            $bet=
                $this->PostProcess($bet,True);

            return True;
        }

        return False;
    }
}

?>