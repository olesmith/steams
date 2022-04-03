<?php

trait Tournament_Matches_Access
{
    //*
    //* 
    //*

    function Tournament_Match_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
            
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

       $res=
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($item[ "Tournament" ]);
            
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Matches_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Search();
    }
    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Tournament_Matches_Access_Edit();
    }

    
    //*
    //* List edit access
    //*

    function Tournament_Matches_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    //*
    //* 
    //*

    function Tournament_Match_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        
        return $res;
    }

    
    //*
    //* Sets up active part of match table.
    //*

    function Tournament_Matches_Initial_Set($edit,$items,$group)
    {
        $today=$this->MyTime_2Sort();

        $dates_before=array();
        $dates_after=array();
        foreach ($items as $item)
        {
            $date=$item[ "Date" ];

            if ($date>$today)
            {
                if (empty($dates_after[ $date ]))
                {
                    $dates_after[ $date ]=0;
                }
                
                $dates_after[ $date ]++;
            }
            else
            {
                if (empty($dates_before[ $date ]))
                {
                    $dates_before[ $date ]=0;
                }
                
                $dates_before[ $date ]++;                
            }            
        }

        $dates=array();
        $before=5;
        $after=5;

        $before_dates=array_reverse(array_keys($dates_before));
        $n_before=0;
        
        for ($n=0;$n<count($before_dates);$n++)
        {
            $date=$before_dates[ $n ];
            $n_before+=$dates_before[ $date ];
            array_unshift($dates,$date);
            
            if ($n_before>=$before)
            {
                break;
            }
        }
        
        $after_dates=array_keys($dates_after);
        $n_after=0;
        
        for ($n=0;$n<count($after_dates);$n++)
        {
            $date=$after_dates[ $n ];
            $n_after+=$dates_after[ $date ];
            
            array_push($dates,$date);
            
            if ($n_after>=$after)
            {
                break;
            }
        }        

        $this->MyMod_Items_Dynamic_Table_Focus_Icons_Every=5;
        $this->MyMod_Items_Dynamic_Table_Focus_Start=0;

        $keys=array_keys($items);
        foreach ($keys as $key)
        {
            if (!in_array($items[ $key ][ "Date" ],$dates))
            {
                $this->MyMod_Items_Dynamic_Table_Focus_Start++;                
            }
            else
            {
                break;
            }
        }
        
        $this->MyMod_Items_Dynamic_Table_Focus_End=count($items);
        $keys=array_reverse($keys);
        foreach ($keys as $key)
        {
            if (!in_array($items[ $key ][ "Date" ],$dates))
            {
                $this->MyMod_Items_Dynamic_Table_Focus_End--;                
            }
            else
            {
                break;
            }
        }
    }
    
}

?>