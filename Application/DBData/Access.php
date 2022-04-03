<?php

class DBDataAccess extends ModulesCommon
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function HasModuleAccess, Parameter list: $event=array()
    //*
    //* Determines if we have access to module.
    //*

    function HasModuleAccess($event=array())
    {
        $res=
            $this->EventMod_Coordinator_Current_User_Edit_May();

        return True;
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
            $this->EventMod_Coordinator_Current_User_Edit_May();

        return $res;
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
        $res=
            $this->HasModuleEditAccess();
       
        return $res;
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
            if ($this->DBDataObj()->Sql_Table_Exists())
            {
                if (empty($item)) { return True; }
                
                if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ "SqlKey" ]))
                {
                    #if ($this->DBDataObj()->MySqlNEntries()>0)
                    #{
                    #    $res=FALSE;
                    #}
                }
            }
        }
 
        return $res;
    }
}

?>