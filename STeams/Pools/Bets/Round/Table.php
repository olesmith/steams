<?php

trait Pool_Bets_Round_Table
{   
    //*
    //* 
    //*

    function Pool_Bets_Round_Table($matches)
    {
        $edit=$this->Pool_Bets_Round_Edit();
        
        $titles=
            $this->Pool_Bets_Round_Title_Rows($edit,$matches);

        $titles_each=7;
        
        $table=array();
        $n=0;

        $participants=array();
        
        $friend=$this->CGI_GETint("Friend");
        if (!empty($friend))
        {
            $participants=
                array
                (
                    $this->Pool_FriendsObj()->Sql_Select_Hash
                    (
                        array("ID" => $friend)
                    )
                );
        }
        else
        {
            $participants=
                $this->PoolsObj()->Pool_Read_Participants();
        }
        
        foreach ($participants as $pool_friend)
        {
            $n++;
            if ( ($n % $titles_each)==1)
            {
                $table=
                    array_merge
                    (
                        $table,$titles
                    );
            }
            
            $table=
                array_merge
                (
                    $table,
                    $this->Pool_Bet_Round_Rows
                    (
                        $edit,$n,$matches,
                        $pool_friend
                    )
                );
        }
       
        return $table;
    }
}

?>