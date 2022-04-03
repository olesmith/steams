<?php

include_once("Handle/Arrays.php");

class Language_Messages_Handle extends Language_Messages_Handle_Arrays
{
    //*
    //* function Language_Messages_Handle, Parameter list: 
    //*
    //* 

    function Language_Messages_Handle()
    {
        $this->Sql_Table_Structure_Update();
        $this->ItemData();
        $this->Actions();

        $update=$this->Language_Message_Types_Update();
        
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Language_Message_Types_Form(),
                $update
            )
        );
    }
    
    //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        if (count($this->ItemHash)>0)
        {
            if ($this->ItemHash[ "Message_Type" ]==$this->Language_Array_Type)
            {
                $this->Language_Messages_Handle_Array(1,$this->ItemHash);
            }
            else
            {
                parent::MyMod_Handle_Edit($echo,$formurl,$title,$noupdate);
            }
        }       
    }
    //*
    //* function MyMod_Handle_Show, Parameter list: 
    //*
    //* Handles module object Show.
    //*

    function MyMod_Handle_Show($title="")
    {
        if (count($this->ItemHash)>0)
        {
            if ($this->ItemHash[ "Message_Type" ]==$this->Language_Array_Type)
            {
                $this->Language_Messages_Handle_Array(0,$this->ItemHash);
            }
            else
            {
                parent::MyMod_Handle_Show($title);
            }
        }
    }
    
    //*
    //* Postprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Post_Process(&$item)
    {
        if ($item[ "Message_Type" ]!=2) { return; }
        
        $ns=
            $this->Sql_Select_Hashes
            (
                $this->MyHash_Values_Hash
                (
                    $item,
                    array("Message_Key","Message_Type",)
                ),
                array("N"),
                $orderby="N"
            );
        $rns=array();
        $max=0;
        foreach ($ns as $n)
        {
            $rn=$n[ "N" ];
            $max=$this->Max($max,$rn);
            
            if (!empty($rns[ $rn ])) { var_dump("Invalid N key: ",$ns); }

            $rns[ $rn ]=$rn;
        }

        $item[ "N" ]=count($ns);
    }
}
?>