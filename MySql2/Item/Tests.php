<?php

#include_once("Tests/Item.php");

class ItemTests extends ItemBackRefs
{
   //*
    //* function ItemCompulsoriesUndefined, Parameter list: $item=array(),$datas=array()
    //*
    //* Tests item according to whether all compulsory fields are defined.
    //* Returns lista of undefined data, empty list of all defined.
    //*


    function ItemCompulsoriesUndefined($item=array(),$datas=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($datas)) { $datas=array_keys($this->ItemData); }

        $rdatas=array();
        foreach ($datas as $data)
        {
            if ($this->ItemData[ $data ][ "Compulsory" ])
            {
                if (empty($item[ $data ]))
                {
                    $res=FALSE;
                    array_push($rdatas,$data);
                }
            }
        }

        return $rdatas;
    }




    //*
    //* Treats $newvalue, backspaces and stuff.
    //*

    function TreatNewValue($newvalue)
    {
        //replace's
        $newvalue=preg_replace("/'/","&#39;",$newvalue);

        //backslashes
        $newvalue=preg_replace('/\\\\/',"&#92;",$newvalue);
        //$newvalue=preg_replace("/&#92;&#92;/","&#92;",$newvalue);
        $newvalue=preg_replace('/\s+$/',"",$newvalue);

        return $newvalue;
    }

    //*
    //* function TestPRN, Parameter list: $item
    //*
    //* Verifies brazilian PRN, rejects if invalid.
    //*

    function TestPRN($prn)
    {
        $body = substr($prn,0,9);
        $dv = substr($prn,9,2);
        $d1 = 0;
        for ($i = 0; $i < 9; $i++)
        {
            $d1 += intval( substr ($body, $i, 1)) * (10 - $i);
        }

        $res=TRUE;
        if ($d1 == 0)
        {
            $res=FALSE;
        }

        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9)
        {
            $d1 = 0;
        }
        if (substr ($dv, 0, 1) != $d1)
        {
            $res=FALSE;
        }

        $d1 *= 2;
        for ($i = 0; $i < 9; $i++)
        {
            $d1 += intval(substr($body, $i, 1)) * (11 - $i);
        }
        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9)
        {
            $d1 = 0;
        }
        if (substr ($dv, 1, 1) != $d1)
        {
            $res=FALSE;
        }

        if (!$res)
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add("CPF ".$prn." Inválido!");
            echo $this->H(5,"CPF ".$prn." Inválido!");
        }

        return $res;
    }
}
?>