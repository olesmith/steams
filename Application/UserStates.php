<?php


class UserStates extends ModulesCommon
{
    //Should be set by app
    /* var $__CGI_Keys__= */
    /*     array */
    /*     ( */
    /*         //"ModuleName","Action", */
    /*         "Unit","School","Period", */
    /*         "Grade","GradePeriod", */
    /*         "Class",//"Disc", */
    /*     ); */
    
    //*
    //* 
    //*

    function User_State_Store()
    {
        $state=array();
        if (!$this->Profile_Public_Is())
        {
            $this->Sql_Table_Structure_Update();
            
            $state=$this->User_State_Read_Or_Create();
            if ($this->User_State_Update_Should($state))
            {
                $this->User_State_Update_Do($state);
            }
        }

        return $state;
    }

    //*
    //* Create state, if necessary.
    //*

    function User_State_Where()
    {
        return
            array
            (
                "Login"   => $this->LoginData("ID"),
                "Profile" => $this->Profile(),
            );
    }
    
    //*
    //* Create state, if necessary.
    //*

    function User_State_Read_Or_Create()
    {
        $where=
            $this->User_State_Where();
            
        $state=
            $this->Sql_Select_Hash
            (
                $where
            );

        if (empty($state))
        {
            $state=$where;                 
            foreach ($this->__CGI_Keys__ as $key)
            {
                if (!isset($state[ $key ])) { $state[ $key ]=""; }
            }

            $this->LogsObj()->LogEntry
            (
                array
                (
                    "CREATE:",
                    join
                    (
                        " - ",
                        array
                        (
                            $where[ "Login" ],
                            $where[ "Profile" ],
                        )
                    )
                    
                )
            );
            
            $this->Sql_Insert_Item($state);
        }

        
        return $state;
    }
    
    //*
    //* 
    //*

    function User_State_Update_Should($state)
    {
        return True;
    }
    
    
    //*
    //* 
    //*

    function User_State_Update_Take(&$state)
    {
        $updatedatas=array();
        $key="Name";
        $value=$this->LoginData($key);

        if (!isset($state[ $key ]) || $state[ $key ]!=$value)
        {
            $state[ $key ]=$value;                    
            array_push($updatedatas,$key);
        }
        
        foreach ($this->__CGI_Keys__ as $key)
        {
            if (!empty($_GET[ $key ]))
            {
                $value=$this->CGI_GET($key);
                if
                    (
                        !empty($value)
                    )
                {
                    $state[ $key ]=$value;                    
                    array_push($updatedatas,$key);
                }
            }
        }

        return $updatedatas;
    }
    
    //*
    //* Update state.
    //*

    function User_State_Update_Do($state)
    {
        $updatedatas=
            $this->User_State_Update_Take($state);
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set
            (
                $updatedatas,$state
            );
        }
    }
}

?>