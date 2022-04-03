<?php

include_once("Common.php");

include_once("Tournaments/Seasons/Read.php");
include_once("Tournaments/Seasons/Access.php");
include_once("Tournaments/Seasons/Cells.php");
include_once("Tournaments/Seasons/Select.php");

class Tournament_Seasons extends Common
{
    use
        Tournaments_Seasons_Read,
        Tournaments_Seasons_Access,
        Tournaments_Seasons_Cells,
        Tournaments_Seasons_Select;
    

    //*
    //* Constructor.
    //*

    function Tournament_Seasons($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Year","StartDate","EndDate");
        $this->Sort=array("Year");
        $this->Reverse=True;

        $this->CellMethods[ "Tournament_Season_Cell_Public_URL" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Mobile_URL" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Period" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Teams_N" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Matches_N" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Groups_N" ]=True;
        $this->CellMethods[ "Tournament_Season_Cell_Rounds_N" ]=True;
        $this->NItemsPerPage=20;

        $this->IDGETVar="Season";
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ModuleName;
        /* if (empty($table)) */
        /* { */
        /*     $table=$this->Tournament_Sql_Table($this->ModuleName); */
        /* } */
        
        /* return $table; */
    }

    
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push
        (
            $this->ItemDataFiles,
            "../Data.Seasons.php",
            "../Data.API.php",
            "../Data.API.Teams.php",
            "../Data.API.Matches.php"
        );
    }

    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->__Data_From_Tournaments__=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($data=="API_ID") { continue; }
            
            $file="";
            if (!empty($this->ItemData[ $data ][ "File" ]))
            {
                $file=$this->ItemData[ $data ][ "File" ];
            }
            
            if
                (
                    preg_match
                    (
                        '/('.
                        join
                        (
                            "|",
                            array
                            (                                
                                "Data.Seasons.php",
                                "Data.API.php",
                                "Data.API.Teams.php",
                                "Data.API.Matches.php"
                            )
                        ).
                        ')$/',
                        $file
                    )
                )
            {
                $this->__Data_From_Tournaments__[ $data ]=True;
            }
        }
            
    }

    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        //parent::PostInit();
     }

    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item,$force=False)
    {
        $modulename=$this->GetGET("ModuleName");
        if
            (
                !$force
                &&
                $modulename!=$this->ModuleName
                &&
                $modulename!="Tournaments"
            )
        {
            return $item;
        }
 
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $item=
            $this->Sql_Select_Hash
            (
                array("ID" => $item[ "ID" ]),
                array()
            );

        $updatedatas=array();
        foreach (array_keys($this->__Data_From_Tournaments__) as $data)
        {
            if (empty($item[ $data ]))
            {
                $oldvalue=False;
                if (isset($item[ $data ])) { $oldvalue=$item[ $data ]; }
                    
                $item[ $data ]=$this->Tournament($data);
                array_push($updatedatas,$data);
            }
        }

        $updatedatas=array();
        if (count($updatedatas)>0)
        {
            var_dump($item[ "ID" ].": ".join(", ",$updatedatas));
            
            print $this->Sql_Update_Item_Values_Set_Query($updatedatas,$item);
        }
        
        return $item;
    }

    
    function Season_Handle_Teams($season=array())
    {
        $this->TournamentsObj()->Tournament_Handle_Teams();
    }
}

?>