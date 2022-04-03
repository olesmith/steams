<?php

include_once("Hide/Functions.php");
include_once("Hide/Buttons.php");
include_once("Hide/Contents.php");
include_once("Hide/Boths.php");

trait Htmls_Hide
{
    use
        Htmls_Hide_Functions,
        Htmls_Hide_Buttons,
        Htmls_Hide_Contents,
        Htmls_Hide_Boths;
    
    //*
    //* Interface methods
    //*
    
    //*
    //* 
    //*

    function Htmls_Hide_Button_ByID($msgkey,$spanid,$shouldhide=False,$display='inline',$options=array())
    {
        return
            $this->Htmls_Hide_Button($msgkey,$spanid,"ID",$shouldhide,$display);
    }

    //*
    //* 
    //*

    function Htmls_Hide_Button_ByClass($msgkey,$spanclass,$shouldhide=False,$display='inline',$options=array())
    {
        return
            $this->Htmls_Hide_Button($msgkey,$spanclass,"CLASS",$shouldhide,$display,$options);
    }

    //*
    //* 
    //*

    function Htmls_Hide_Button_And_Content_ByID($content,$msgkey,$spanid,$shouldhide=False)
    {
        return
            $this->Htmls_Hide_Button_And_Content($content,$msgkey,$spanid,"ID",$shouldhide);        
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Buttons_And_Contents_ByID($contents)
    {
        return
            $this->MyMod_Handle_Buttons_And_Contents($contents,"ID");
    }
}


?>