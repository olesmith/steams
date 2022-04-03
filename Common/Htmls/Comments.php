<?php


trait Htmls_Comments
{
    //*
    //* sub Htmls_Comment, Parameter list: $comments
    //*
    //* Formats as list of HTML comments
    //*
    //*

    function Htmls_Comments($comments,$calllevel=2)
    {
        if (!is_array($comments)) { $comments=array($comments); }
        
        if (!is_array($comments)) { $comments=array($comments); }
        
        $traces=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $function="";
        $file="";
        $line="";

        if (!empty($traces[$calllevel-1]) && !empty($traces[$calllevel-2]))
        {
            $function=$traces[$calllevel-1][ 'function' ];
            $file=$traces[$calllevel-2][ 'file' ];
            $line=$traces[$calllevel-2][ 'line' ];            
        }
        
        
        $comment="                                                                 ";
        array_push
        (
            $comments,
            "Function: ".$function."()",
            "File: ".$file.", line ".$line,
            $comment
        );
        
        array_unshift($comments,$comment);
        
        foreach (array_keys($comments) as $id)
        {
            $comments[ $id ]="<!-- ".$comments[ $id ]." -->";
        }
        
        return $comments;
    }
    
    //*
    //* sub Htmls_Comment_Section, Parameter list: $comment,$html
    //*
    //* Creates a start/end html comments around $html.
    //*
    //*

    function Htmls_Comment_Section($comment,$html)
    {
        return
            array_merge
            (
                $this->Htmls_Comments($comment.": *START*",3),
                $html,
                $this->Htmls_Comments($comment.": **END**",3),
                array("")
            );
    }
}
?>