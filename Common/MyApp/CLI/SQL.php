<?php


trait MyApp_CLI_SQL
{
    var $Count_Table_Name="__Count__";

    
    function MyApp_CLI_SQL_Become($args)
    {
        $this->DBHash=
            $this->ReadPHPArray
            (
                $args[2]
            );

        if (count($args)>=4)
        {
            $db=$args[3];
            $this->DBHash[ "DB" ]='sade_1';

            $this->DBs=array();
        
            $this->DB_Connect($this->DBHash);
        }
    }
        
    //*
    //* Updates counting tables with entries:
    //*
    //* Time Date SQL_Table NEntries
    //*

    function MyApp_CLI_SQL_Count_Tables($args)
    {
        if
            (
                count($args)<2
                ||
                !preg_match('/count/i',$args[1])
            )
        {
            print "Omitting MyApp_CLI_SQL_Count_Tables\n";
            return;
        }
        
        if
            (
                count($args)>=3
            )
        {
            $this->MyApp_CLI_SQL_Become($args);
        }
        
        
        $destinationtable=$this->Count_Table_Name;;
        
        $mtime=time();
        $today=$this->MyTime_2Sort();
        
        $datadefs=
            $this->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/Count/Data.php"
            );
        
        $tables=$this->Sql_Table_Names();
        
        print
            "Counting DB '".
            $this->DBHash[ "DB" ].
            "': ".
            count($tables)."\n";
        
        if (!$this->Sql_Table_Exists($destinationtable))
        {
            $this->Sql_Table_Structure_Update_Force=True;
        
            $this->Sql_Table_Structure_Update
            (
                array_keys($datadefs),
                $datadefs,
                $maycreate=TRUE,
                $destinationtable
            );

            print "Count table created - please rerun\n";
            exit();
        }

        $where=
            array
            (
                "Date" => $today,
            );
        
        $new=
            array
            (
                "Time" => $mtime,
            );
            

        $ninserted=0;
        $nupdated=0;
        
        $texts=array();
        foreach ($tables as $table)
        {            
            $where[ "SQL_Table" ]=$table;

            $new[ "N" ]=$this->Sql_Select_NHashes("",$table);

            $item=
                $this->Sql_Select_Hash
                (
                    $where,
                    array(),
                    $noecho=FALSE,
                    $destinationtable
                );

            $text=
                join
                (
                    "\t",
                    array($table,$new[ "N" ],"")
                );

            if (empty($item))
            {
                $item=array_merge($where,$new);
                $this->Sql_Insert_Item($item,$destinationtable);
                $text.="inserted\n";
                $ninserted++;
            }
            else
            {
                $nupdated++;
                $text.="updated\n";
            }
            
            $item=array_merge($where,$new);
            $this->Sql_Update_Item
            (
                $item,
                $where,
                array_keys($new),
                $destinationtable
            );

            array_push($texts,$text);
        }

        print
            "Counted ".
            count($tables).
            " in ".
            (time()-$mtime).
            " seconds: ".
            $ninserted.
            " inserted, ".
            $nupdated.
            " updated\n";
        

        return $texts;
    }
}

?>