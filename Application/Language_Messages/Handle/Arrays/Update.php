<?php

class Language_Messages_Handle_Arrays_Update extends Language_Messages_Handle_Arrays_Html
{
    //*
    //* Updates the common table.
    //*

    function Language_Messages_Handle_Array_Update($edit,&$item)
    {
        if ($this->CGI_POSTint($this->Language_Messages_Handle_Arrays_Form_CGI)!=1)
        {
            return False;
        }
        
        $updatedatas=array();
        foreach ($this->Language_Messages_SGroup_Datas() as $data)
        {
            if (isset($_POST[ $data ]))
            {
                $newvalue=$this->CGI_POST($data);
                if ($item[ $data ]!=$newvalue)
                {
                    $item[ $data ]=$newvalue;
                    array_push($updatedatas,$data);
                }
            }
        }

        foreach (array_keys($this->Messages) as $n)
        {
            $rupdatedatas=$updatedatas;
            foreach ($updatedatas as $data)
            {
                $this->Messages[ $n ][ $data ]=$item[ $data ];
            }

            foreach ($this->Language_Keys() as $lang)
            {
                foreach ($this->KeyDatas as $data)
                {
                    $rdata=$data."_".$lang;
                    $cgikey=$this->Messages[ $n ][ "ID" ]."_".$rdata;
                    $newvalue=$this->CGI_POST($cgikey);
                    if ($this->Messages[ $n ][ $rdata ]!=$newvalue)
                    {
                        $this->Messages[ $n ][ $rdata ]=$newvalue;
                        array_push($rupdatedatas,$rdata);
                    }
                }
            }

            $datas=
                array_merge
                (
                    $this->Language_Messages_Handle_Array_Datas(),
                    $this->Language_Messages_Handle_Array_Datas()
                );

            foreach ($this->Language_Messages_Handle_Array_Datas() as $data)
            {
                if ($data=="No") { continue; }
                
                $cgikey=$this->Messages[ $n ][ "ID" ]."_".$data;
                if (isset($_POST[ $cgikey ]))
                {
                    $newvalue=$this->CGI_POST($cgikey);
                    if ($this->Messages[ $n ][ $data ]!=$newvalue)
                    {
                        $this->Messages[ $n ][ $data ]=$newvalue;
                        array_push($rupdatedatas,$data);
                        var_dump("set $data=$newvalue");
                    }
               }
            }
            
            if (count($rupdatedatas)>0)
            {
                $this->Sql_Update_Item_Values_Set($rupdatedatas,$this->Messages[ $n ]);
            }
        }
    }
}
?>