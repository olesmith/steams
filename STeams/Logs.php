<?php


include_once("Common/MyApp/MyLogs.php");

class Logs extends ModulesCommon
{
    use MyLogs;
    
    
    var $CascadingSearchVars=array
    (
       "Debug" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array(),
          "Default" => "",
       ),
       "Month" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array("Date","Login","Profile","Login","ModuleName"),
          "Where" => array(),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "MonthTitle",
       ),
       "Date" => array
       (
          "RemoveVars" => array("Month"),
          "AddVars" => array(),
          "Where" => array(),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "DateTitle",
       ),
       "Period" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "PeriodTitle",
       ),
       "Profile" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Reverse" => TRUE,
       ),
       "Login" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Method" => "LoginTitle",
       ),
       "ModuleName" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array("Action"),
          "Where" => array("ModuleName","Date"),
          "Default" => "",
       ),
       "Action" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("ModuleName","Date"),
          "Default" => "",
       ),
       "UserAgent" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("ModuleName","Date"),
          "Default" => "",
       ),
    );

    //*
    //*
    //* Constructor.
    //*

    function Logs($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->NItemsPerPage=25;

        /* array_push */
        /* ( */
        /*     $this->Logs_Search_Vars, */
        /* ); */
        /* array_push */
        /* ( */
        /*     $this->LogGETVars, */
        /* ); */
        /* array_push */
        /* ( */
        /*     $this->LogPOSTVars, */
        /* ); */

        $this->CellMethods=
            array_merge
            (
                $this->CellMethods,
                array
                (
                    "Logs_Date_Cell" => 1,
                    "Logs_Time_Cell" => 1,
                )
            );
    }
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        /* $this->ProcessOldLogs(); */
    }


    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }


    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Item post processor. Called after read of each item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/^Logs/',$module))
        {
            return $item;
        }

        return $item;
    }
    




    //*
    //* function CreateCascatingSearchWhere, Parameter list: $data
    //*
    //* Returns heirarcical Search where.
    //*

    function CreateCascatingSearchWhere($data)
    {
        $where=array();
        foreach ($this->CascadingSearchVars[ $data ][ "Where" ] as $key)
        {
            $value=$this->MyMod_Search_CGI_Value($key);
            if (!empty($value))
            {
                $where[ $key ]=$value;
            }
        }

        return $where;
    }

    //*
    //* function CreateCascatingSearchField, Parameter list: $data,$rdata="",$rvalue=""
    //*
    //* Creates heirarcical Searchfield.
    //*

    function CreateCascatingSearchField($data,$rdata="",$rvalue="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $values=$this->MySqlUniqueColValues
        (
           "",
           $data,
           $this->CreateCascatingSearchWhere($data),
           "",
           $data
        );

        if (!empty($this->CascadingSearchVars[ $data ][ "Reverse" ]))
        {
            $values=array_reverse($values);
        }

        $rvalues=array();
        if (!empty($this->CascadingSearchVars[ $data ][ "Method" ]))
        {
            $method=$this->CascadingSearchVars[ $data ][ "Method" ];
            foreach ($values as $id => $value)
            {
                if (empty($value))
                {
                    unset($values[ $id ]);
                    continue;
                }

                $rvalues[ $id ]=$this->$method($value);
                if (empty($rvalues[ $id ]))
                {
                    unset($values[ $id ]);
                    unset($rvalues[ $id ]);
                    continue;
                }
            }
        }
        else
        {
            $rvalues=$values;
        }

        array_unshift($values,0);
        array_unshift($rvalues,"");


        //Take default, if detectable
        $cgivalue=$this->MyMod_Search_CGI_Value($data);
        if (empty($cgivalue) && !empty($this->CascadingSearchVars[ $data ][ "Default" ]))
        {
            $cgivalue=$this->CascadingSearchVars[ $data ][ "Default" ];
        }

        //If value given, add vars and remove vars.
        if (!empty($cgivalue))
        {
            foreach ($this->CascadingSearchVars[ $data ][ "RemoveVars" ] as $var)
            {
                $this->MyMod_Search_Var_Remove($var);
            }

            foreach ($this->CascadingSearchVars[ $data ][ "AddVars" ] as $var)
            {
                $this->MyMod_Search_Var_Add($var);
            }
        }

        //If value given, add Date as SearchVar.
        if (!empty($cgivalue))
        {
        }

        return $this->MakeSelectField
        (
           $this->MyMod_Search_CGI_Name($rdata),
           $values,
           $rvalues,
           $cgivalue
        );
    }
 
    //*
    //* function DebugSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Debug Searchfield.
    //*

    function DebugSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }
    
    //*
    //* function PeriodTitle, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Returns period title.
    //*

    function PeriodTitle($value)
    {
        return $this->PeriodsObj()->MySqlItemValue("","ID",$value,"Title",TRUE);
    }

    //*
    //* function PeriodSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates School Searchfield.
    //*

    function PeriodSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* function MonthTitle, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Returns Month title.
    //*

    function MonthTitle($value)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$value,$matches))
        {
            $year=$matches[1];
            $value=$matches[2];

            $value=$value."/".$year;
        }

        return $value;
    }

    //*
    //* function MonthSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Month Searchfield.
    //*

    function MonthSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* function DateTitle, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Returns Date title.
    //*

    function DateTitle($value)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$value,$matches))
        {
            $value=
                $matches[3]."/".
                $matches[2]."/".
                $matches[1];
        }
 
        return $value;
    }

    //*
    //* function LogDateSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Date Searchfield.
    //*

    function LogDateSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* function LogDateSearchWhere, Parameter list:
    //*
    //* Creates Date, Month or Yeat search where.
    //*

    function LogDateSearchWhere()
    {
        $date=$this->MyMod_Search_CGI_Value("Date");
        $month=$this->MyMod_Search_CGI_Value("Month");
        if (!empty($date))
        {
            return array("Date" => $date);
        }
        elseif (!empty($month))
        {
            return array("Month" => $month);
        }
        else
        {
            return array("Month" => $this->CurrentYear().$this->CurrentMonth());
        }
    }

    //*
    //* function ProfileSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Profile Searchfield.
    //*

    function ProfileSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
   }

    //*
    //* function LoginTitle, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Returns Login title.
    //*

    function LoginTitle($value)
    {
        if (!empty($value))
        {
            $value=
                $this->UsersObj()->MySqlItemValue("","ID",$value,"Name",TRUE).
                " (".$value.")";
        }
 
        return $value;
    }

     //*
    //* function LoginSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Login Searchfield.
    //*

    function LoginSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* function ModuleSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Module Searchfield.
    //*

    function ModuleSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* function ActionSearchField, Parameter list: $data,$rdata="",$rval=""
    //*
    //* Creates Action Searchfield.
    //*

    function ActionSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Log entry $msg.
    //*

    function LogEntry($msgs,$level=5)
    {
        if (is_array($msgs)) { $msgs=join("\n",$msgs); }

        /* if (!$this->Sql_Table_Exists()) */
        /* { */
        /*     $this->Sql_Table_Structure_Update(); */
        /* } */

        $server="CLI";
        if (empty($_SERVER['REMOTE_ADDR']))
        {
            $server=$_SERVER['REMOTE_ADDR'];
        }
        
        $log=
            array
            (
                "Time"    => $this->TimeStamp(),
                "IP"      => $server,
                "App"  => $this->CGI_GET("App"),
                "Debug"   => $level,
                "Login"   => $this->ApplicationObj()->LoginData[ "ID" ],
                "Profile" => $this->ApplicationObj()->Profile(),
                "Module"  => $this->CGI_GET("ModuleName"),
                "Action"  => $this->CGI_GET("Action"),
                "Message" => $this->TreatCGIValue($msgs),
            );

        foreach ($this->LogGETVars as $getvar)
        {
            if (isset($_GET[ $getvar ]))
            {
                $log[ $getvar ]=$this->GetGET($getvar);
            }
        }

        foreach ($this->LogPOSTVars as $getvar)
        {
            if (isset($_POST[ $getvar ]))
            {
                $log[ "POST_".$getvar ]=$this->GetPOST($getvar);
            }
        }
        
        $this->MyFile_Append
        (
            $this->Log_File(),
            join
            (
                "\t",
                array
                (
                    $this->TimeStamp(),
                    $_SERVER['REMOTE_ADDR'],
                    $this->CGI_GET("App"),
                    $level,

                    $this->ApplicationObj()->Profile(),
                    $this->ApplicationObj()->LoginData("ID"),
                    $this->ApplicationObj()->LoginData("Email"),
                    $this->CGI_GET("ModuleName"),
                    $this->CGI_GET("Action"),
                    $_SERVER['HTTP_USER_AGENT'],
                    $this->TreatCGIValue($msgs),
                )
            )
        );
        
        return;
    }
    
}

?>