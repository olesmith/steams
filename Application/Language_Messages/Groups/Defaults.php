<?php

trait Language_Messages_Groups_Defaults
{
    var $Language_Module_Groups_Defaults=array();
    
    //*
    //* 
    //*

    function Language_Groups_Defaults(&$message)
    {
        if
            (
                $message[ "Message_Type" ]!=$this->Language_Group_Type
                &&
                $message[ "Message_Type" ]!=$this->Language_SGroup_Type
            )
        { return array(); }

        $singular=False;
        if ($message[ "Message_Type" ]==$this->Language_SGroup_Type)
        {
            $singular=True;
        }
        
        $this->Language_Groups_Defaults_Read($singular);

        $group=$message[ "Message_Key" ];
        if
            (
                empty
                (
                    $this->Language_Module_Groups_Defaults
                    [ $singular ][ $group ]
                )
            )
        { return array(); }
        

        $datas=array();
        foreach ($this->KeyDatas as $data)
        {
            foreach ($this->Language_Keys() as $lang)
            {
                array_push($datas,$data."_".$lang);
            }
        }

        $this->Sql_Select_Hash_Datas_Read($message,$datas);

        $updatedatas=array();
        foreach ($datas as $ldata)
        {
            $rldata=preg_replace('/_PT$/',"",$ldata);
            
            if
                (
                    empty($message[ $ldata ])
                    &&
                    !empty
                    (
                        $this->Language_Module_Groups_Defaults
                        [ $singular ][ $group ][ $rldata ]
                    )
                )
            {
                $message[ $ldata ]=
                    $this->Language_Module_Groups_Defaults
                    [ $singular ][ $group ][ $rldata ];
                
                array_push($updatedatas,$ldata);
            }
        }

        return $updatedatas;
    }
    
    //*
    //* 
    //*

    function Language_Groups_Defaults_Read($singular)
    {
        $file="Groups.php";
        if ($singular) { $file="SGroups.php"; }
        
        if (empty($this->Language_Module_Groups_Defaults[ $singular ]))
        {
            $this->Language_Module_Groups_Defaults[ $singular ]=
                $this->ReadPHPArray
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Common/System/".
                    $this->Language_Groups_Defaults_File($singular)
                );
        }
    }
    
    //* 
    //* 
    //*

    function Language_Groups_Defaults_File($singular)
    {
        $file="Groups.php";
        if ($singular) { $file="SGroups.php"; }

        return $file;
    }
    
}
?>