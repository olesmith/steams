<?php

trait App_CLI_Messages_Modules_Groups
{
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Groups_Do($hash,$module_method)
    {
        print "SigaZ Messages Groups Actions CLI\n";
        $groups=
            $this->$module_method()->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/Groups.Time.php"
            );

        $ngroups=0;
        $ngroupsadded=0;
        foreach ($groups as $group => $rhash)
        {
            if (!empty($rhash[ "Name" ]))
            {
                $rhash[ "Name_PT" ]=$rhash[ "Name" ];
            }
            
            if (empty($rhash[ "Name_PT" ]))
            {
                $rhash[ "Name_PT" ]=$group;
            }
            
            $ngroupsadded+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $group,
                    $this->LanguagesObj()->Language_Group_Type,
                    $rhash
                );
            $ngroups++;
        }

        $this->$module_method()->ItemDataGroups();
        foreach ($this->$module_method()->ItemDataGroups as $group => $rhash)
        {
            $ngroupsadded+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $group,
                    $this->LanguagesObj()->Language_Group_Type,
                    $rhash
                );
            $ngroups++;
        }
        
        print $hash[ "Module" ].": ".$ngroups." Groups, ".$ngroupsadded." added\n";        
    }
    
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_SGroups_Do($hash,$module_method)
    {
        print "SigaZ Messages SGroups Actions CLI\n";
        $groups=
            $this->$module_method()->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/SGroups.Time.php"
            );

        $ngroups=0;
        $ngroupsadded=0;
        foreach ($groups as $group => $rhash)
        {
            if (!empty($rhash[ "Name" ]))
            {
                $rhash[ "Name_PT" ]=$rhash[ "Name" ];
            }
            
            if (empty($rhash[ "Name_PT" ]))
            {
                $rhash[ "Name_PT" ]=$group;
            }
            
            $ngroupsadded+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $group,
                    $this->LanguagesObj()->Language_SGroup_Type,
                    $rhash
                );
            $ngroups++;
        }

        $this->$module_method()->ItemDataSGroups();
        foreach ($this->$module_method()->ItemDataSGroups as $group => $rhash)
        {
            $ngroupsadded+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $group,
                    $this->LanguagesObj()->Language_SGroup_Type,
                    $rhash
                );
            $ngroups++;
        }
        
        print $hash[ "Module" ].": ".$ngroups." SGroups, ".$ngroupsadded." added\n";        
    }
}
