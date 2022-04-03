<?php


trait MyMod_Search_Options_Paging_Values
{
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_Values($npages)
    {
        $values=array();       
        for ($n=1;$n<=$npages;$n++)
        {
            array_push
            (
                $values,$n
            );
        }

        return $values;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_Value_Names($npages)
    {
        $format=$this->MyMod_Search_Options_Paging_Format($npages);
        
        $valuenames=array();       
        for ($n=1;$n<=$npages;$n++)
        {
            array_push
            (
                $valuenames,
                sprintf($format,$n).
                ": ".
                join
                (
                    "-",
                    $this->MyMod_Search_CGI_Page_Info_List($n)
                )
            );
        }

        return $valuenames;
    }
}

?>