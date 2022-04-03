<?php

class Language_Messages_Handle_Arrays_Titles extends Language_Messages_Handle_Arrays_Rows
{
    
    //*
    //* Scans $this->Titles.
    //*

    function Language_Messages_Handle_Array_Titles($display,$lang)
    {
        $titles=$this->KeyDatas;
        $titles=
            $this->MyMod_Data_Titles
            (
                $this->Language_Messages_Handle_Array_Datas()
            );
            
        foreach ($this->KeyDatas as $data)
        {
            array_push
            (
                $titles,
                $this->Language_Messages_Handle_Array_Cell_Data_Title($data,$lang)
            );
        }
        $titles=$this->Htmls_Table_Head_Row($titles);
        $titles[ "Style" ]=$display;
        $titles[ "Class" ]=array($titles[ "Class" ],$lang);
         
            array_unshift($titles[ "Row" ],"");
        return $titles;
    }
    
    var $Ns=NULL;
    
    //*
    //* Returns $this->Ns from $ritems. Scans if necessary.
    //*

    function Language_Messages_Handle_Array_N_Titles()
    {
        if ($this->Ns==NULL)
        {
            $this->Ns=array_keys($this->Messages);
            sort($this->Ns,SORT_NUMERIC);
        }

        return $this->Ns;
    }
}
?>