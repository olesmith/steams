<?php

trait MyApp_CLI_Defaults
{
    //*
    //* Runs CLI commands for Defaults table:
    //*    remove ancient actions and create default
    //*    actions, item data and groups.
    //*

    function MyApp_CLI_Defaults($args)
    {
        if
            (
                count($args)<2
                ||
                !preg_match('/Defaults/i',$args[1])
            )
        {
            print "Omitting Language_Defaults_CLI\n";
            return;
        }

        $this->LanguagesObj()->Language_Defaults_CLI($args);
    }
}
