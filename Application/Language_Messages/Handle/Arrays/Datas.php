<?php

class Language_Messages_Handle_Arrays_Datas extends Language_Messages_Handle_Arrays_Cells
{
    //*
    //*
    //*

    function Language_Messages_Handle_Array_Datas()
    {
        return
            array("No","ID","Module","Message_Key","Message_Type","N",);
    }
    //*
    //*
    //*

    function Language_Messages_Handle_Array_Language_Key_Datas($lang)
    {
        $datas=array();
        foreach ($this->KeyDatas as $data)
        {
            $rdata=$data."_".$lang;
            array_push($datas,$data."_".$lang);
        }
        
        return $datas;
    }

}
?>