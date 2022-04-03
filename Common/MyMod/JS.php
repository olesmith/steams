<?php


trait MyMod_JS
{
    //* 
    //*
    //*

    function MyMod_SCRIPTs()
    {
        $action=$this->CGI_GET("Action");

        $method="MyMod_Handle_".$action."_SCRIPTs";

        $scripts=array();
        if (method_exists($this,$method))
        {
            $scripts=
                $this->Htmls_SCRIPT
                (
                    $this->$method($action)
                );
        }
        
        return $scripts;
    }
}

?>