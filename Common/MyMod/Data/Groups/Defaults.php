<?php


//include_once("Data/Groups.php");

trait MyMod_Data_Groups_Defaults
{
    //use MyMod_Data_Defaults,MyMod_Data_Groups;

    //*
    //* function MyMod_Data_Groups_Defaults_Defs, Parameter list: 
    //*
    //* Returns groups default definitions.
    //*

    function MyMod_Data_Groups_Defaults_Defs()
    {
        return array
        (
            "Name" => "",
            "Files" => array(),
            "Actions" => array(),
            "Data" => array(),
            "ShowData" => array(),
            "Data_Read" => array(),
            
            "Order" => 0,
            "Edit" => 0,
            "Admin" => TRUE,
            "Person" => FALSE,
            "Public" => FALSE,
            "Single" => FALSE,
            "Single" => True,
            "NoTitleRow" => FALSE,
            "SqlWhere" => "",
            "Sort" => "",
            "SubTable"  => NULL,
            "TitleData"  => NULL,
            "TableDataMethod" => "",  //arguments:
                                     // singular: $edit,$item,$group
                                     // plural:   $edit
            "GenTableMethod" => "",  //arguments:
                                     // singular: $edit,$item,$group
                                     // plural:   $edit
            "OtherClass"  => FALSE,
            "OtherGroup" => FALSE,
            "PreMethod" => FALSE,
            "NItemsPerPage" => FALSE,
            "Visible" => 1,
            "NonAddGroup" => FALSE,
            "PreMethod" => "",//arguments: $items,$group
        );

    }


    //*
    //* function MyMod_Data_Groups_Defaults_Take, Parameter list: &$groups
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_Groups_Defaults_Take(&$groups)
    {
        $defaults=$this->MyMod_Data_Groups_Defaults_Defs();
        foreach (array_keys($groups) as $data)
        {
            $this->MyMod_Data_Group_Defaults_Take($groups[ $data ],$defaults);
        }
    }

    //*
    //* function MyMod_Data_Group_Default_Take, Parameter list: &$data,$defaults=array()
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_Group_Defaults_Take(&$group,$defaults=array())
    {
        if (empty($defaults))
        {
            $defaults=$this->MyMod_Data_Groups_Defaults_Defs();
        }

        $this->MyHash_AddDefaultKeys($group,$defaults);
    }

    //*
    //* Names of data groups.
    //*

    function MyMod_Data_Group_Names_Get($singular=FALSE)
    {
        $this->MyMod_Data_Groups_Initialize();
        if (($this->Singular || $single) && count($this->ItemDataSGroups)>0)
        {
            return array_keys($this->ItemDataSGroups);
        }
        else
        {
            return array_keys($this->ItemDataGroups);
        }
        $accgroups=$this->MyMod_Data_Groups_AccName($singular);

        return array_keys($this->$accgroups);
    }
    
    //*
    //* Return object data group var, that is:
    //* ItemDataSGroups if Singular, elsewise ItemDataGroups
    //*

    function MyMod_Data_Group_Singular($single=FALSE)
    {
        if (($this->Singular || $single) && count($this->ItemDataSGroups)>0)
        {
            return True;
        }
        else
        {
            return False;
        }
    }
    
    //*
    //* Return object data group var, that is:
    //* ItemDataSGroups if Singular, elsewise ItemDataGroups
    //*

    function MyMod_Data_Group_Defs_Get($single=FALSE)
    {
        $this->MyMod_Data_Groups_Initialize();
        if ($this->MyMod_Data_Group_Singular($single))
        {
            return $this->ItemDataSGroups;
        }
        else
        {
            return $this->ItemDataGroups;
        }
    }
    
    //*
    //* Return data to display in Data Group
    //*

    function MyMod_Data_Group_Def_Get($group,$single=FALSE,$echo=True)
    {
        $this->ItemDataGroups();
        if ($this->MyMod_Data_Group_Singular($single))
        {
            if (!empty($this->ItemDataSGroups[ $group ]))
            {
                return $this->ItemDataSGroups[ $group ];
            }
        }
        else
        {
            if (!empty($this->ItemDataGroups[ $group ]))
            {
                return $this->ItemDataGroups[ $group ];
            }
        }
        
        if ($echo)
        {
            echo $this->ModuleName." MyMod_Data_Group_Def_Get, Warning: Group $group undefined";
            $this->AddMsg("Warning: Group $group undefined");

            $this->CallStack_Show();
            exit();
        }

        return array();
    }

    //*
    //* Return object data group CGI Var name.
    //*

    function MyMod_Data_Group_Actual_CGI_Name()
    {
        $keys=
            array
            (
                $this->ModuleName."_GroupName",
                "GroupName",
            );

        $rkey="";
        foreach ($keys as $key)
        {
            if (isset($_POST[ $key ]))    { return $key; }
        }
        
        foreach ($keys as $key)
        {
            if (isset($_GET[ $key ]))     { return $key; }
        }
        
        foreach ($keys as $key)
        {
            if (isset($_COOKIE[ $key ]))  { return $key; }
        }

        return "";
    }

    //*
    //* Return object data group CGI Var value.
    //*

    function MyMod_Data_Group_Actual_CGI_Value()
    {
        return
            $this->CGI_VarValue
            (
                $this->MyMod_Data_Group_Actual_CGI_Name()
            );
    }

    

    //*
    //* Return current Data Group
    //*

    function MyMod_Data_Group_Actual_Get()
    {
        $this->PostInitItems();

        if (!empty($this->CurrentDataGroup))
        {
            $group=$this->CurrentDataGroup;
        }
        else
        {
            $group=$this->MyMod_Data_Group_Actual_CGI_Value();
            if (empty($group))
            {
                $group=$this->MyMod_Group_Default;
            }            
        }

        $groups=$this->MyMod_Data_Groups_Get();
        if (!is_string($group) || !preg_grep('/^'.$group.'$/',$groups))
        {
            $group="";
        }
        
        if  (
               empty($group)
               ||
               !$this->MyMod_Group_Allowed($this->ItemDataGroups[ $group ])
            )
        {
            //No group found (or group found was not allowed)            
            //Localize (first) $group with Default not empty
            foreach ($this->MyMod_Data_Groups_Get() as $rgroup)
            {
                if (!empty($this->ItemDataGroups[ $rgroup ][ "Default" ]))
                {
                    $group=$rgroup;
                    break;
                }
            }

        }
        
        if  (
               empty($group)
               ||
               !$this->MyMod_Group_Allowed($this->ItemDataGroups[ $group ])
            )
        {
            //Localize first allowed data group
            foreach ($this->MyMod_Data_Groups_Get() as $rgroup)
            {
                if ($this->MyMod_Group_Allowed($this->ItemDataGroups[ $rgroup ]))
                {
                    $group=$rgroup;
                    break;
                }
            }
        }

        return $group;
    }

    //*
    //* Return data to display in Data Group
    //*

    function MyMod_Data_Groups_Get()
    {
        return
            $this->MyHash_Order_Hashes_Keys
            (
                $this->ItemDataGroups,
                "Order",
                "Visible"
            );
    }

    
    //*
    //* Return data to display in Data Group
    //*

    function MyMod_Data_Group_Datas_Get($group,$single=FALSE,$item=array(),$callmethod=True)
    {
        if (empty($group)) { return array(); }
        
        $this->ItemData();
        
        if ($callmethod && $single)
        {
            if (!empty($this->ItemDataSGroups[ $group ][ "TableDataMethod" ]))
            {
                $method=$this->ItemDataSGroups[ $group ][ "TableDataMethod" ];
                return $this->$method($group,$item);
            }
        }
        elseif ($callmethod)
        {
            if (!empty($this->ItemDataGroups[ $group ][ "TableDataMethod" ]))
            {
                $method=$this->ItemDataGroups[ $group ][ "TableDataMethod" ];
                return $this->$method($group);
            }
        }
        
        $groupdef=$this->MyMod_Data_Group_Def_Get($group,$single);
        if (!$single)
        {
            $commongroupdef=
                $this->MyMod_Data_Group_Def_Get("_Common_",$single,False);
        }

        //var_dump($commongroupdef);
        $datas=array();
        foreach (array("Actions","ShowData","Data") as $type)
        {
            $rdatas=$this->GetRealNameKey($groupdef,$type);
            if (is_array($rdatas))
            {
                $datas=array_merge($datas,$rdatas);
            }
        }

        if
            (
                !$single
                &&
                !empty($commongroupdef)
            )
        {
            if ( empty($this->ItemDataGroups[ $group ][ "_No_Common_" ]))
            {
                $rdatas=$this->GetRealNameKey($commongroupdef,"Data");
                if (is_array($rdatas))
                {
                    $datas=array_merge($rdatas,$datas);
                }
            }
        }

        if (empty($datas) || !is_array($datas))
        {
            $this->AddMsg("Warning: Group $group has no data defined");
            return array();
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (!is_array($data)) { $data=array($data); }

            foreach ($data as $rdata)
            {
                //var_dump($rdata,$this->ItemData($rdata,"Sql"));
                if (isset($this->ItemData[ $rdata ]))
                {
                    
                    if (!$single && preg_grep('/^'.$rdata.'$/',$this->MyMod_Language_Data))
                    {
                        $rdata.=$this->MyLanguage_GetLanguageKey();
                    }
                    $res=$this->MyMod_Data_Access($rdata);
                    
                    #if ($this->MyMod_Access_HashAccess($this->ItemData[ $rdata ],array(1,2)))

                    if ($res>=1)
                    {
                        array_push($rdatas,$rdata);
                    }
                }
                elseif (isset($this->Actions[ $rdata ]))
                {
                    $action=$data;
                    if ($this->MyAction_Allowed($rdata))
                    {
                        array_push($rdatas,$rdata);
                    }
                    else
                    {
                        if (!empty($this->Actions[ $rdata ][ "AltAction" ]))
                        {
                            $altaction=$this->Actions[ $rdata ][ "AltAction" ];
                            if ($this->MyAction_Allowed($altaction))
                            {
                                array_push($rdatas,$altaction);
                            }
                        }
                    }
                }
                elseif (method_exists($this,$rdata))
                {
                    array_push($rdatas,$rdata);
                }
                elseif (
                          $rdata=="No"
                          ||
                          preg_match('/^newline/',$rdata)
                          ||
                          preg_match('/^text\_/',$rdata)
                       )
                {
                    array_push($rdatas,$rdata);
                }
            }
        }
      
        return $this->MyHash_List_Unique($rdatas);
    }
}

?>