<?php

trait Pool_Handle
{
    //*
    //* 
    //*

    function Pool_Handle_Participants($pool=array())
    {
        if (empty($pool)) { $pool=$this->ItemHash; }

        $participants=
            $this->Pool_FriendsObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament" => $pool[ "Tournament" ],
                    "Pool" => $pool[ "ID" ],
                ),
                array(),
                "Name"
            );

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $pool[ "Name" ].",",
                        $this->Pool_FriendsObj()->MyMod_ItemsName(),
                    )
                ),
                $this->Pool_FriendsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Pool_Read_Participants($pool),
                    "Basic"
                )
            )
        );        
    }
                
    //*
    //* 
    //*

    function Pool_Handle_Rounds($pool=array())
    {
        if (empty($pool)) { $pool=$this->ItemHash; }

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $pool[ "Name" ]
                ),
                $this->GroupsObj()->Tournament_Groups_Rounds_Generate
                (
                    $datagroup="Bets"
                )
            )
        );
    }
    
    //*
    //* 
    //*

    function Pool_Handle_Select($pool=array())
    {
        if (empty($pool))
        {
            $pool=$this->ItemHash;
        }

        $dest_id="Pools";

        $pools=
            $this->Tournament_SeasonsObj()->Tournament_Season_Pools_Read();

        if (count($pools)==0)
        {
            return array("No Pools");
        }
        
        $this->Htmls_Echo
        (
            array
            (
                $this->B
                (
                    $this->MyMod_ItemName(":")
                ),
                $this->Htmls_Select_Hashes_Field
                (
                    "Pool",
                    $pools,
                    //$args=
                    array
                    (
                        "Selected"  => $pool[ "ID" ],
                        "Name_Key"  => "Name",
                        "Title_Key" => "ID",
                    ),
                    //$options=
                    array
                    (
                        "ONCHANGE" => array
                        (                            
                            $this->JS_Select_Send
                            (
                                $this->CGI_URI2Hash(),
                                "Pools"
                            ),
                        ),
                    )
                ),
                $this->Pool_Handle_Select_Actions
                (
                    $pool,
                    "Action",
                    array("Show","Friend","Participants","Rounds","Ranking"),
                    "Friend"
                ),
            )
        );
    }
    
    //*
    //* 
    //*

    function Pool_Handle_Select_Actions($pool,$dest_id,$actions,$default_action)
    {
        return
            array
            (
                $this->Pool_Handle_Select_Actions_Field
                (
                    $pool,$dest_id,$actions,$default_action
                ),
                //$this->Pool_Handle_Select_Actions_SPAN($dest_id),
                $this->Pool_Handle_Select_Actions_SCRIPT
                (
                    $pool,$dest_id,$default_action
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Handle_Select_Actions_Field($pool,$dest_id,$actions,$default_action)
    {
        $this->Actions();

        $values=array(0);
        $names=array("");
        foreach ($actions as $action)
        {
            
            if
                (
                    !$this->MyAction_Allowed
                    (
                        $action,
                        $pool
                    )
                )
            {
                continue;
            }
            
            array_push($values,$action);
            array_push
            (
                $names,
                $this->MyActions_Entry_Name($action,$noicons=True)
            );
        }

        return
            $this->Htmls_Select
            (
                "Action",
                $values,
                $names,
                $default_action,
                array(),
                array
                (
                    "ONCHANGE" => array
                    (                            
                        $this->JS_Select_Send
                        (
                            $this->Pool_Handle_Select_Actions_URL($dest_id),
                            "Action"
                        ),
                    ),
                )
            );
    }
    
    
    //*
    //* 
    //*

    function Pool_Handle_Select_Actions_SCRIPT($pool,$dest_id,$default_action)
    {            
        return
            $this->Htmls_SCRIPT
            (
                $this->JS_Load_Once
                (
                    $this->Pool_Handle_Select_Action_URL
                    (
                        $dest_id,
                        $default_action
                    ),
                    $dest_id
                )
            );            
    }
    
    //*
    //*
    //* 
    //*

    function Pool_Handle_Select_Action_URL($dest_id,$action)
    {
        return
            array_merge
            (
                $this->Pool_Handle_Select_Actions_URL($dest_id),
                array
                (
                    "Action" => $action,
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Handle_Select_Actions_URL($dest_id)
    {
        $url=$this->CGI_URI2Hash();
        if (!empty($url[ "Pool" ]))
        {
            //unset($url[ "Pool" ]);
        }
            
        return
            array_merge
            (
                $url,
                array
                (
                    "NoHorMenu" => 1,
                    "ModuleName" => "Pools",
                    "Dest" => $dest_id,
                )
            );
    }
}

?>