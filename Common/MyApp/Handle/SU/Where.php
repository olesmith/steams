<?php

trait MyApp_Handle_SU_Where
{
    //*
    //* function MyApp_Handle_SU_Where, Parameter list: $peoplewhere=array()
    //*
    //* Sql where clause for relevant users.
    //*

    function MyApp_Handle_SU_Where($peoplewhere=array())
    {
        if (
              $this->Unit 
              &&
              !empty($this->UsersObj()->ItemData[ "Unit" ]))
        {
            $peoplewhere[ "Unit" ]=$this->Unit[ "ID" ];
        }

        if ($this->Profile!="Admin")
        {
            $profiles=$this->ApplicationObj()->MyApp_Handle_SU_Profiles_Unallowed();

            $ors=array();
            foreach ($profiles as $profile)
            {
                $key="Profile_".$profile;
                array_push
                (
                    $ors,
                    "(".$this->Sql_Table_Column_Name_Qualify($key).
                    "!=".
                    $this->Sql_Table_Column_Value_Qualify(2).
                    " OR ".
                    $this->Sql_Table_Column_Name_Qualify($key).
                    " IS NULL".
                    ")"
                );
            }

            $peoplewhere[ "__Profiles__" ]=join(" AND ",$ors);
        }
        else
        {
            $peoplewhere[ "__ID__" ]="ID>'0'";
        }
        
        return $this->UsersObj()->MyMod_Items_Where_Clause_Real($peoplewhere);
    }
}

?>