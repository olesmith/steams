<?php


trait Htmls_Menues_Horisontal
{
    //*
    //* Generates horisontal menu.
    //*

    function Htmls_Menu_Horisontal($hrefs,$title="",$maxnitems=4)
    {
        $rhrefs=$this->MyHashes_Page($hrefs,$maxnitems);
        
        $rrhrefs=array();
        if (!empty($title))
        {
            array_push($rrhrefs,$title);
        }
        
        foreach ($rhrefs as $hrefs)
        {
            $rhrefs=array("[");
            $n=1;
            foreach ($hrefs as $href)
            {
                array_push($rhrefs,$href);
                if ($n<count($hrefs))
                {
                    array_push($rhrefs,"|");
                }

                $n++;
            }
        
            array_push
            (
                $rhrefs,"]",
                $this->BR()
            );

            $rrhrefs=array_merge($rrhrefs,$rhrefs);
        }
        
        return
            $this->Htmls_DIV
            (
                $rrhrefs,
                array
                (
                    "ID" => "HorMenu",
                    "CLASS" => "center tablemenu",
                )
            );
    }
}
?>