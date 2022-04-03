<?php

//include_once("Handle/Start.php");

trait MyApp_Profiles
{
    //Changes: 18/09/2015.

    //*
    //* function MyApp_Profiles_Path, Parameter list: 
    //*
    //* Returns Profiles path.
    //*

    function MyApp_Profiles_Path()
    {
        return $this->ApplicationObj->MyApp_Setup_Path($this->ModuleName);
    }

    //*
    //* function GetProfiles, Parameter list: 
    //*
    //* Reads profiles if necessary.
    //*

    function GetProfiles()
    {
        if (empty($this->Profiles))
        {
            $this->MyApp_Profiles_Read();
        }

        return $this->Profiles;
    }

    //*
    //* Returns profile definition belonging to $profile.
    //* If $profile omitted or empty, returns profile
    //* belonging to $this->Profile.
    //*

    function MyApp_Profile_Def($profile="")
    {
        if ($profile=="") { $profile=$this->Profile(); }

        if (!empty($key))
        {
            return $this->Profiles[ $profile ][ $key ];
        }
        
        return $this->Profiles[ $profile ];
    }

    //*
    //* function MyApp_Profile_Name, Parameter list: $profile="",$plural=FALSE
    //*
    //* Returns name of Profile $profile or current.
    //*

    function MyApp_Profile_Name($profile="",$plural=FALSE)
    {
        if (empty($profile)) { $profile=$this->Profile(); }

        if (empty($profile)) { $profile="Public"; }

        $key="Name";
        if ($plural) { $key="PName"; }

        
        $name=$this->GetRealNameKey($this->Profiles[ $profile ],$key);
        if (empty($name))
        {
            
            if ($plural)
            {
                return $this->LanguagesObj()->Language_Profile_Name_Plural($profile);
            }
            else
            {
                return $this->LanguagesObj()->Language_Profile_Name_Singular($profile);
            }
        }

        return $name;
    }

    //*
    //* function MyApp_Profiles_Read, Parameter list:
    //*
    //*

    function MyApp_Profiles_Read()
    {
        if (count($this->Profiles())>0)
        {
            return;
        }

        if (file_exists($this->MyApp_Setup_Profiles_File()))
        {
            $this->Profiles=$this->ReadPHPArray($this->MyApp_Setup_Profiles_File());
            foreach ($this->ValidProfiles as $id => $profile)
            {
                if (empty($this->Profiles[ $profile ]))
                {
                    $this->Warn
                    (
                       "ReadProfiles: Profile ".$profile." unset in ",
                       $this->MyApp_Setup_Profiles_File()
                    );
                }
                
            }
        }
        else
        {
            $this->DoDie
            (
               "ReadProfiles: No Profiles file: ",
                $this->MyApp_Setup_Profiles_File()
            );
        }

        $this->NProfiles=count($this->ValidProfiles);
        //$this->MyApp_Profile_Cookie_Send();
    }


    //*
    //* function MyApp_Profile_Detect, Parameter list: 
    //*
    //* Detect profile from $this->LoginData, and
    //* then CGI/Cookie value of key Profile. Sets profile
    //* to value found, if allowed. Otherwise, set profile to Public.
    //*


    function MyApp_Profile_Detect()
    {
        //$profile=$this->CGI_VarValue("Profile");
        $profile=$this->MyApp_Profiles_CGI_Get();
        if (empty($profile))
        {
            $profile=$this->MyApp_Profile_Default();
        }

        $this->MyApp_Profile_Set($profile);
    }

    
    //*
    //* function MyApp_Profile_Default, Parameter list:
    //*
    //* Returns default profile - first in $this->AllowedProfiles.
    //*

    function MyApp_Profile_Default()
    {
        //Make sure allowed profiles has been set.
        $this->MyApp_Profile_Allowed_Detect();
        
        $profile="Public";
        if (count($this->AllowedProfiles)>0)
        {
            $profile=$this->MyApp_Profile_From_Login_Data();
        }

        return $profile;
    }

    
    //*
    //* function MyApp_Profile_Is, Parameter list:
    //*
    //* Checks if current user accesses as $profile. 
    //*

    function MyApp_Profile_Is($profile)
    {
        return $this->MyMod_Profile_Is($profile);
    }
    
    //*
    //* Checks if CGI tries to reset profile.
    //* Checks if allowed, if so returns new profile.
    //*

    function MyApp_Profiles_CGI_Get()
    {
        $this->MyApp_Profile_Allowed_Detect();
        
        $profile=$this->CGI_GET("Profile");
        if (!empty($profile))
        {
            if (preg_grep('/^'.$profile.'$/',$this->AllowedProfiles))
            {
                if (!empty($this->LoginData[ "Profile_".$profile ]))
                {
                    $this->__Profile__=$profile;
                    $this->MyApp_Profile_Set($profile);
                    $this->__Profile__=$profile;
                }
            }
        }
        elseif (!empty($this->Session[ "Profile" ]))
        {
            $this->__Profile__=$this->Session[ "Profile" ];
        }
 
        return $this->__Profile__;
    }
    
    //*
    //* function MyApp_Profile_Cookie_Send, Parameter list:
    //*
    //* Sends the Profile cookie.
    //*

    function MyApp_Profile_From_Login_Data()
    {
        foreach ($this->AllowedProfiles as $profile)
        {
            if (!empty($this->LoginData[ "Profile_".$profile ]))
            {
                $this->__Profile__=$profile;
                break;
            }
        }
 
        return $this->__Profile__;
    }
    


    //*
    //* Detects $profile trust value.
    //*

    function MyApp_Profile_Trust($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        return intval($this->Profiles($profile,"Trust"));
    }
   
    //*
    //* Checks whether $user hash has admin permissions.
    //*

    function Current_User_Admin_Is()
    {
        return //boolean
            (
                $this->MyApp_Profile_Trust()
                >=
                $this->MyApp_Profile_Trust("Admin")
            );
    }
    
    
    //*
    //* function MyApp_Profile_Set, Parameter list: $profile
    //*
    //* Tries to set profile to $profile.
    //* Checks if allowed - dies if not.
    //*

    function MyApp_Profile_Set($profile)
    {
        //Make sure allowed profiles has been set.
        $this->MyApp_Profile_Allowed_Detect();

        $res=FALSE;
        if ($profile=="Public")
        {
            $this->__Profile__=$profile;
            $this->LoginType=$profile;

            $res=TRUE;
        }
        elseif (preg_grep('/^'.$profile.'$/',$this->AllowedProfiles))
        {
            if ($profile=="Admin")
            {
                if ($this->MyApp_Profile_MayBecomeAdmin())
                {
                    $this->__Profile__=$profile;
                    $this->LoginType="Admin";
                    
                    /* $this->MyApp_Profile_Cookie_Send(); */
                
               
                    $res=TRUE;
                }
            }
            else
            {
                $this->__Profile__=$profile;
                $this->LoginType="Person";
                
                /* $this->MyApp_Profile_Cookie_Send(); */
                
                $res=TRUE;
            }
        }

        return $res;
    }

    
    //*
    //* function MyApp_Profile_MayBecomeAdmin, Parameter list: 
    //*
    //* Detects if logged on user may become admin.
    //*

    function MyApp_Profile_MayBecomeAdmin()
    {
        $res=FALSE;

        if ($this->LoginID>0)
        {
            if ($this->LoginData[ "Profile_Admin" ]==2)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* function MyApp_Profile_MayBecomeAdmin, Parameter list: 
    //*
    //* Detects Allowed profiles from Valid profiles, based on
    //* Login data and profiles.
    //*

    function MyApp_Profile_Allowed_Detect()
    {
        if (count($this->AllowedProfiles)==0)
        {
            //Necessary?
            $this->NProfiles=count($this->ValidProfiles);

            $this->AllowedProfiles=array();

            if ($this->LoginData)
            {
                if (!empty($this->AuthHash[ "ForceProfile" ]))
                {
                    $this->AllowedProfiles=$this->ValidProfiles;
                }
                else
                {
                    $this->AllowedProfiles=
                        $this->MyApp_Profile_User_Profiles($this->LoginData);
                }
            }
        }

        return $this->AllowedProfiles;
    }

    //*
    //* Detects $user allowed profiles.
    //*

    function MyApp_Profile_User_Profiles($user=array())
    {
        if (empty($user)) { $user=$this->LoginData; }
        
        $profiles=array();
        foreach ($this->ValidProfiles as $n => $profile)
        {
            if ($profile=="Public") { continue; }

            if
                (
                    isset($user[ "Profile_".$profile ])
                    &&
                    $user[ "Profile_".$profile ]==2
                )
            {
                array_push($profiles,$profile);
            }
        }

        return $profiles;
    }

}

?>