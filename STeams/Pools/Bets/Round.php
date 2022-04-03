<?php

include_once("Round/Read.php");
include_once("Round/Permissions.php");
include_once("Round/Cells.php");
include_once("Round/Rows.php");
include_once("Round/Titles.php");
include_once("Round/Table.php");
include_once("Round/Html.php");
include_once("Round/Update.php");
include_once("Round/Form.php");

trait Pool_Bets_Round
{
    use
        Pool_Bets_Round_Read,
        Pool_Bets_Round_Permissions,
        Pool_Bets_Round_Cells,
        Pool_Bets_Round_Rows,
        Pool_Bets_Round_Titles,
        Pool_Bets_Round_Table,
        Pool_Bets_Round_Html,
        Pool_Bets_Round_Update,
        Pool_Bets_Round_Form;
    
    //* 
    //* 
    //*

    function Pool_Bets_Round_Handle()
    {
        $this->Htmls_Echo
        (
            array
            (
                $this->Pool_Bets_Round_Form()
            )
        );
    }

    //*
    //* 
    //*

    function Pool_Bets_Round_Edit($bet=array(),$match=array())
    {
        $edit=0;
        if ($this->Profile_Admin_Is())
        {
            $edit=1;
        }
        elseif ($this->Profile_Friend_Is())
        {
            //var_dump();
            if
                (
                    !empty($bet)
                    &&
                    $bet[ "Friend" ]==$this->LoginData("ID")
                )
            {
                $edit=1;
                if (!empty($match))
                {
                    $edit=
                        $this->Pool_Bet_Permissions($bet,$match)-1;
                }
            }
            elseif ($this->CGI_GETint("Friend")==$this->LoginData("ID"))
            {
                $edit=1;
            }
        }
        
        return $edit;
    }

    var $__Pool_Bet_Matches__=array();
    
  
    //*
    //* 
    //*

    function Pool_Bet_Round_Show($bet)
    {
        return 1;
    }
    
    //*
    //* Reads $bet. If not found, creates it.
    //*

    function Pool_Bet_Round_Read_Create($match,$pool_friend)
    {
        $where=
            $this->Pool_Bet_Round_Where($match,$pool_friend);
        
        $bet=
            $this->Sql_Select_Hash($where);

        if (empty($bet))
        {
            $bet=$where;
            $bet[ "Goals1" ]="-";
            $bet[ "Goals2" ]="-";
            $bet[ "Friend" ]=$pool_friend[ "Friend" ];
            $bet[ "Pool_Friend" ]=$pool_friend[ "ID" ];
            
            $this->Sql_Insert_Item($bet);
        }

        return $bet;
        return $this->PostProcess($bet,$force=True);
    }
    
    //*
    //* 
    //*

    function Pool_Bet_Round_Where($match,$pool_friend)
    {
        return
            array
            (
                "Tournament"       => $this->Tournament("ID"),
                "Tournament_Round" => $match[ "Tournament_Round" ],
                "Tournament_Match" => $match[ "ID" ],
                
                "Pool"        => $pool_friend[ "Pool" ],                    
                "Season"      => $pool_friend[ "Season" ],                    
                "Pool_Friend" => $pool_friend[ "ID" ],                    
                //"Pool"   => $pool_friend[ "Pool" ],                    
            );
    }
}

?>