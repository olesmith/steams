<?php



trait MyMod_Globals
{
    //*
    //* function Module2Object, Parameter list: $data
    //*
    //* Shortcut function for get module object.
    //*

    function Module2Object($data)
    {
        return $this->MyMod_Data_Fields_Module_2Object($data);
    }


    //*
    //* function IsMain, Parameter list:
    //*
    //* Returns FALSE here in MyMod, TRUE in MyAppd.
    //*

    function IsMain()
    {
        return $this->IsMain;
    }

    //*
    //* function ApplicationObj, Parameter list: 
    //*
    //* For application modules to work with ApplicationObj accessor.
    //*

    function ApplicationObj()
    {
        return $this->ApplicationObj;
    }



    //*
    //* function ModuleName, Parameter list:
    //*
    //* ModuleName accessor.
    //*

    function ModuleName()
    {
        if ($this->IsMain())
        {
            return "Application";
        }
        else
        {
            return $this->ModuleName;
        }
    }

    //*
    //* function ModulePath, Parameter list:
    //*
    //* ModulePath accessor.
    //*

    function ModulePath()
    {
        if ($this->IsMain())
        {
            return "Application";
        }
        else
        {
            return $this->ModuleName;
        }
    }

    //*
    //* function SubModulesVars, Parameter list: $module,$key =""
    //*
    //* Accessor to SubModuleVars global array.
    //*

    function SubModulesVars($module,$key="")
    {
        if (!empty($this->ApplicationObj()->SubModulesVars[ $module ][ $key."_".$this->Profile() ]))
        {
            $key=$key."_".$this->Profile();
        }
        
        return
            $this->MyHash_HashHashes_Get($this->ApplicationObj()->SubModulesVars,$module,$key);
    }

    //*
    //* Short accessor for error reporting method.
    //*

    function Warn($msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        //var_dump($info1);
        return
            $this->ApplicationObj()->MyMessage_Warn
            (
                $msgs,
                $info1,
                $info2,
                $info3,
                $info4,
                $info5
            );
    }

    //*
    //* Prints $msgs and exits.
    //*

    function DoExit($msgs=array(),$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if (is_array($msgs))
        {
            $msgs=join("<BR>\n",$msgs);
        }
        echo
            $msgs;
        exit();
    }

    //*
    //* Short accessor for error reporting method.
    //*

    function DoDie($msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        return
            $this->ApplicationObj()->MyMessage_Die
            (
                $msgs,
                $info1,$info2,$info3,$info4,$info5
            );
    }

    //*
    //* Returns TRUE if we are logged on, false if not.
    //*

    function IsLogged()
    {
        $res=FALSE;
        if ($this->Profile()!="Public")
        {
            $res=TRUE;
        }
    }

    //*
    //* function IsAdmin, Parameter list: 
    //*
    //* Returns TRUE if we are admin, false if not.
    //*

    function IsAdmin()
    {
        $res=FALSE;
        if ($this->Profile()!="Admin")
        {
            $res=TRUE;
        }
    }


    //*
    //* Login acessor, using ApplicationObj.
    //*

    function LoginData($key="")
    {
        if (empty($key)) { return $this->ApplicationObj()->LoginData; }
        elseif (!empty($this->ApplicationObj()->LoginData[ $key ]))
        {
            return $this->ApplicationObj()->LoginData[ $key ];
        }

        return "";
    }

    //*
    //* Profile acessor, using ApplicationObj.
    //*

    function Profile()
    {
        $profile=$this->ApplicationObj()->__Profile__;

        if (empty($profile)) { $profile="Public"; }

        return $profile;
    }

    //*
    //*

    function Profiles($profile="",$key="")
    {
        if (!empty($profile))
        {
            if (!empty($key))
            {
                return $this->ApplicationObj()->Profiles[ $profile ][ $key ];
            }

            return $this->ApplicationObj()->Profiles[ $profile ];
            
        }
        
        return $this->ApplicationObj()->Profiles;
    }

    //*
    //* Returns TRUE if current user's profile is in $profiles
    //*

    function Profiles_Is($profiles,$profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=FALSE;
        if (preg_match('/^('.join("|",$profiles).')$/',$profile))
        {
            $res=TRUE;
        }
        
        return $res;
    }

    //*
    //* Returns Logintyppe
    //*

    function LoginType()
    {
        $logintype=$this->ApplicationObj()->LoginType;

        if (empty($logintype)) { $logintype="Public"; }

        return $logintype;
    }


    //*
    //* Reads module profile file, if necesary.
    //*

    function ModuleProfiles($subkey1="",$subkey2="")
    {
        if (empty($this->ModuleProfiles))
        {
            $this->MyMod_Profiles_Read();
        }

        return $this->MyHash_HashHashes_Get($this->ModuleProfiles,$subkey1,$subkey2);
    }

    //*
    //* Dynamic read of module Messages.
    //*

    function Messages($key="",$skey="Name")
    {
        if (empty($this->Messages))
        {
            $this->MyMod_Language_Read();
        }

        if (!empty($key))
        {
            if (!empty($this->Messages[ $key ]))
            {
                return $this->GetRealNameKey($this->Messages[ $key ],$skey);
            }

            return $key;
        }

        return $this->Messages;
    }

    
    //*
    //* Dynamic read of Actions. If $value defined, sets appropriate $action/$key.
    //*

    function Actions($action="",$key="",$value="")
    {
        if (empty($this->Actions))
        {
            $this->MyActions_Read();
        }

        if (!empty($value))
        {
            $this->MyHash_HashHashes_Set($this->Actions,$value,$action,$key);
        }

        return $this->MyHash_HashHashes_Get($this->Actions,$action,$key);
    }

    //*
    //* Dynamic read of ItemData.
    //*

    function ItemData($data="",$key="",$subkey="")
    {
        if (empty($this->ItemData))
        {
            $this->MyMod_Data_Read();
            $this->MyMod_Language_Datas_Init();
        }

        return $this->MyHash_HashHashes_Get($this->ItemData,$data,$key,$subkey);
    }

    //*
    //* Dynamic read of Groups.
    //*

    function ItemDataGroups($group="",$key="",$value="")
    {
        if (empty($group)) { $group=$this->MyMod_Group_Default; }
        
        if (empty($this->ItemDataGroups))
        {
            $this->MyMod_Data_Groups_Initialize();
        }

        return $this->MyHash_HashHashes_Get($this->ItemDataGroups,$group,$key);
    }

    //*
    //* Dynamic read of SGroups.
    //*

    function ItemDataSGroups($group="",$key="",$value="")
    {
        if (empty($group)) { $group=$this->MyMod_Group_Default; }
        
        if (empty($this->ItemDataGroups))
        {
            $this->MyMod_Data_Groups_Initialize();
        }

        return $this->MyHash_HashHashes_Get($this->ItemDataSGroups,$group,$key);
    }

    
    //*
    //* Dynamic read of ItemData.
    //*

    function LatexData($singularplural="",$key="")
    {
        if (empty($this->LatexData))
        {
            $this->MyMod_Latex_Read();
        }

        return
            $this->MyHash_HashHashes_Get($this->LatexData,$singularplural,$key);
    }

    //*
    //* Dynamic read of LatexDoc's..
    //*

    function LatexDoc($singularplural="",$docno=0)
    {
        if (empty($singularplural))
        {
            $singularplural="PluralLatexDocs"; 
            if ($this->Singular) { $singularplural="SingularLatexDocs"; }
            
        }
        
        $docs=$this->LatexData($singularplural,"Docs");
        if ($docno==0) { $docno=$this->CGI2LatexDocNo(); }

        $doc=array();
        if (!empty($docs[ $docno ]))
        {
            $doc=$docs[ $docno ];
        }

        return $doc;
    }

}

?>