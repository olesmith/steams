<?php

trait App_CLI_Messages_Profiles
{
    //*
    //* Profile Messages to insert.
    //*

    function MyApp_CLI_Message_Profiles()
    {
        $profiles=$this->GetProfiles();
        foreach ($this->GetProfiles() as $profile => $hash)
        {
            $where=
                array
                (
                    "Message_Key" => $profile,
                    "Message_Type" => $this->LanguagesObj()->Language_Profile_Type,
                );
            
            $message=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    $where                        
                );

            if (empty($message))
            {
                $message=$where;
                $message[ "Name_PT" ]=$profile;

                $this->LanguagesObj()->PostProcess_Defaults($message);
                $this->LanguagesObj()->Sql_Insert_Item($message);
            }
                


        }
    }
}
