<?php

class Language_Messages_Access extends Language_Messages_DBHash
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* Determines if we have access to module.
    //*

    function HasModuleAccess($item=array())
    {
        return True;
    }
    
    //*
    //* Determines if we have access to module.
    //*

    function Language_Permissions($data,$item=array())
    {
        $res=1; //public read access

        $trust=$this->Profile_Trust();
        if ($trust>=$this->Profile_Trust("Admin"))
        {
            $res=2;
        }
        elseif ($trust>=$this->Profile_Trust("Coordinator"))
        {
            $regex=join("|",array_keys($this->ApplicationObj()->Languages));
            $languages=
                $this->PermissionsObj()->Permissions_Friend_Languages_Edit_Get();
            
            if (preg_match('/_('.$regex.')$/',$data,$matches))
            {
                $language=$matches[1];
                if (!empty($languages[ $language ]))
                {
                    $res=2;
                }
            }
        }
        
        return $res;
    }
    
    //*
    //* Determines if we have access to some language.
    //*

    function Has_Language_Edit_Access($item=array())
    {
        $res=False;

        $trust=$this->Profile_Trust();
        if ($trust>=$this->Profile_Trust("Admin"))
        {
            $res=True;
        }
        else
        {
            $res=
                $trust>=$this->Profile_Trust("Coordinator")
                &&
                count
                (
                    //$this->PermissionsObj()->Permissions_Friend_Languages_Edit_Get()
                    array(1)
                )>0;
        }
        
        return $res;
    }
    
    //* function HasModuleEditAccess, Parameter list: $event=array()
    //*
    //* Determines if we have access to module.
    //*

    function HasModuleEditAccess($item=array())
    {
        $res=
            $this->HasModuleAccess($item)
            &&
            $this->Module_Profile_Current_User_Edit_May()
            &&
            $this->Has_Language_Edit_Access($item);

        
        return $res;
    }
    
    //*
    //* Tests if user has coordenator edit access to language messages module.
    //*

    function Module_Profile_User_Edit_May($user=array(),$profile="Coordinator")
    {
        if (empty($user))    { $user=$this->LoginData(); }
        if (empty($profile)) { $profile=$this->Profile(); }
        
        return ($this->Profile_Trust()>=$this->Profile_Trust($profile));
    }

     //*
    //* function CheckShowAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=$this->HasModuleAccess();

        return $res;
    }
    //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowListAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=$this->HasModuleAccess();

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
         $res=
             $this->HasModuleEditAccess();

         return $res;
    }

    //*
    //* function CheckEditListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckEditListAccess($item=array())
    {
       return
            $this->HasModuleEditAccess();
    }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted. That is:
    //* No questionary data defined - and no inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        $res=FALSE;

        if (
              $this->CheckEditAccess($item)
              &&
              preg_match('/^(Coordinator|Admin)$/',$this->Profile())
           )
        {
            $res=TRUE;
        }
 
        return $res;
    }
}

?>