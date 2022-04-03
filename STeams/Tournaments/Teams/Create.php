<?php

trait Tournaments_Teams_Create
{
    //*
    //* 
    //*

    function Tournament_Teams_Get($update_structure=False)
    {
        if ($update_structure)
        {
            $this->Sql_Table_Structure_Update();
        }

        if (empty($this->__Teams__))
        {
            $where=
                $this->Tournament_Teams_Where();
            
            $sort="Name,ID";
            $this->__Teams__=
                $this->Sql_Select_Hashes
                (
                    $where,
                    array(),
                    $sort
                );

            //Still empty, create.
            if (count($this->__Teams__)<$this->Tournament("NTeams"))
            {
                $this->Tournament_Teams_Create();
                $this->__Teams__=
                    $this->Sql_Select_Hashes
                    (
                        $where,
                        array(),
                        $sort
                    );
            }

            $this->__Teams__=
                $this->MyHash_HashesList_Key
                (
                    $this->__Teams__,
                    $key="Tournament_Group"
                );
        }

        return $this->__Teams__;
    }
    
    //*
    //* 
    //*

    function Tournament_Teams_Create()
    {
        
        $groups=$this->Tournament_Groups_Get();
        if (count($groups)==0) { return; }

        $nteams=$this->Tournament("NTeams");
        $ngroups=count($groups);
        return;
        
        $where=$this->Tournament_Teams_Where();

        $nteams_read=
            $this->Sql_Select_NHashes
            (
                $where
            );
        
        for ($group_no=0;$group_no<count($groups);$group_no++)
        {
            $rwhere=
                array_merge
                (
                    $where,
                    array
                    (
                        "Tournament_Group" => $groups[ $group_no ][ "ID" ],
                    )
                );

            $nteams_group=
                $this->Sql_Select_NHashes
                (
                    $rwhere
                );

            for
                (
                    $n=$nteams_group+1;
                    $n<=$this->Tournament_Group_Teams_N();
                    $n++
                )
            {
                $this->Tournament_Team_Create
                (
                    $groups[ $group_no ],
                    $n
                );
            }
        }
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Create($group,$n)
    {
        return;
        $where=
            $this->Tournament_Teams_Where();

        $group_where=
            $this->Tournament_Teams_Where_Group($group,$where);

        
        $nteams_read=
            $this->Sql_Select_NHashes
            (
                $where
            );
        
        $nteams_in_group=
            $this->Sql_Select_NHashes
            (
                $group_where
            );

        if
            (
                $nteams_read<$this->Tournament("NTeams")
                &&
                $nteams_in_group<$this->Tournament_Group_Teams_N()
            )
        {                
            var_dump("DEBUG",$this->Sql_Insert_Item_Query($group_where));
            //$this->Sql_Insert_Item($group_where);
        }
    }
    
    //*
    //* 
    //*

    function Tournament_NTeams_Per_Group($groups=array())
    {
        $nteams=$this->Tournament("NTeams");
        $ngroups=$this->Tournament("NTeams");
                
        return intval(floor($nteams/$ngroups));
    }
        
    //*
    //* 
    //*

    function Tournament_Teams_Where_Group($group,$where=array())
    {
        return
            array_merge
            (
                $where,
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season" => $this->Season("ID"),
                    "Tournament_Group" => $group[ "ID" ],
                )
            );
        
    }
    //*
    //* 
    //*

    function Tournament_Teams_Where($where=array())
    {
        return
            array_merge
            (
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season" => $this->Season("ID"),
                ),
                $where
            );
    }
}

?>