<?php

trait Htmls_Anchors
{

    //*
    //* Creates a href args as hash.
    //* 
    //*

    function Htmls_Anchor($content,$anchor)
    {
        return
            $this->Htmls_Tag
            (
                "A",
                $content,
                array
                (
                    "HREF" => "#".$anchor,
                )
            );
    }
    

}
?>