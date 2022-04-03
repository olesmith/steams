<?php

trait Language_Messages_Actions_Defaults
{
    var $Language_Module_Actions_Defaults=array();
    
    
    //*
    //* 
    //*

    function Language_Actions_Defaults(&$message)
    {
        if ($message[ "Message_Type" ]!=$this->Language_Action_Type) { return array(); }
        
        $this->Language_Actions_Defaults_Read();

        $action=$message[ "Message_Key" ];
        if (empty($this->Language_Module_Actions_Defaults[ $action ])) { return array(); }
        

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
                    !empty($this->Language_Module_Actions_Defaults[ $action ][ $rldata ])
                )
            {
                $message[ $ldata ]=
                    $this->Language_Module_Actions_Defaults[ $action ][ $rldata ];
                
                array_push($updatedatas,$ldata);
            }
        }

        return $updatedatas;
    }
    
    //*
    //* 
    //*

    function Language_Actions_Defaults_Read()
    {
        if (empty($this->Language_Module_Actions_Defaults))
        {
            $this->Language_Module_Actions_Defaults=
                $this->ReadPHPArray
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Common/System/Actions.php"
                );
        }
    }
}
?>