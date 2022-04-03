<?php

trait Language_Messages_Datas_Defaults
{
    var $Language_Module_Datas_Defaults=array();
    
    //*
    //* 
    //*

    function Language_Datas_Defaults(&$message)
    {
        if ($message[ "Message_Type" ]!=$this->Language_Data_Type) { return array(); }
        
        $this->Language_Datas_Defaults_Read();

        $key=$message[ "Message_Key" ];
        if (empty($this->Language_Module_Datas_Defaults[ $key ])) { return array(); }
       

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
                    !empty($this->Language_Module_Datas_Defaults[ $key ][ $rldata ])
                )
            {
                $message[ $ldata ]=$this->Language_Module_Datas_Defaults[ $key ][ $rldata ];
                array_push($updatedatas,$ldata);
            }
        }

        return $updatedatas;
    }
    
    //*
    //* 
    //*

    function Language_Datas_Defaults_Read()
    {
        if (empty($this->Language_Module_Datas_Defaults))
        {
            $this->Language_Module_Datas_Defaults=
                array_merge
                (
                    $this->ReadPHPArray
                    (
                        $this->ApplicationObj()->MyApp_Setup_Root().
                        "/Common/System/Data.php"
                    ),
                    $this->ReadPHPArray
                    (
                        $this->ApplicationObj()->MyApp_Setup_Path().
                        "/Data.php"
                    )
                );
        }
    }
    
}
?>
