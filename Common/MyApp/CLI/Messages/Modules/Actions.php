<?php

trait App_CLI_Messages_Modules_Actions
{
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Actions_Do($hash,$module_method,$module)
    {
        print "SigaZ Messages Module Actions CLI $module_method,$module\n";
        $actions=
            $this->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/Actions.php"
            );

        $nactions=0;
        $nactionsadded=0;
        foreach ($actions as $action => $rhash)
        {
            print "\t".$action;
            if (empty($hash[ "Module" ]))
            {
                $hash[ "Module" ]=$module;
            }
            
            if (!empty($rhash[ "Name" ]))
            {
                $rhash[ "Name_PT" ]=$rhash[ "Name" ];
            }
            
            if (empty($rhash[ "Name_PT" ]))
            {
                $rhash[ "Name_PT" ]=$action;
            }

            $nactionsadded+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $action,
                    $this->LanguagesObj()->Language_Action_Type,
                    $rhash
                );
            $nactions++;
        }

        if (!empty($module_method))
        {
            foreach ($this->$module_method()->Actions() as $action => $rhash)
            {
                if (empty($hash[ "Module" ]))
                {
                    $hash[ "Module" ]=$module;
                }
            
                if (!empty($rhash[ "Name" ]))
                {
                    $rhash[ "Name_PT" ]=$rhash[ "Name" ];
                }
            
                if (empty($rhash[ "Name_PT" ]))
                {
                    $rhash[ "Name_PT" ]=$action;
                }
            
                $nactionsadded+=
                    $this->MyApp_CLI_Message_Hash_Do
                    (
                        $hash,
                        $action,
                        $this->LanguagesObj()->Language_Action_Type,
                        $rhash
                    );
                $nactions++;
            }
        }
        
        print $hash[ "Module" ].": ".$nactions." Actions, ".$nactionsadded." added\n";        
    }
}
