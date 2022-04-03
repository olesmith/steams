<?php

trait Htmls_List
{
    //*
    //* function  , Parameter list: $list,$ul,$options=array(),$lioptions=array()
    //*
    //* Generate a HTML list (UL) with elements in $list
    //* 
    //*

    function Htmls_List($list,$options=array(),$lioptions=array(),$ul="UL")
    {
        if (count($list)==0) { return array(); }

        if ($this->LatexMode())
        {
            if ($ul=="UL") { $ul="itemize"; }
            else           { $ul="enumerate"; }

            return $this->LatexList($list,$ul);
        }
        else
        {
            return
                array
                (
                    $this->Htmls_Tag
                    (
                        $ul,
                        $this->Htmls_Tag_List
                        (
                            "LI",
                            $list,
                            array_merge
                            (
                                array
                                (
                                   #"CLASS" => 'menu-label',
                                ),
                                $lioptions
                            )
                        ),
                        array_merge
                        (
                            array
                            (
                                "CLASS" => 'content menu-list',
                            ),
                            $options
                        )
                    )
                );
        }
    }

}


?>