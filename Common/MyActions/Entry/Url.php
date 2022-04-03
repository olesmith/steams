<?php

trait MyActions_Entry_Url
{
    //*
    //* Generates only action title.
    //*

    function MyActions_Entry_URL($data,$item=array(),$rargs=array(),$noargs=array(),$itemargs=array())
    {
        $this->Actions($data);
        if (!isset($this->Actions[ $data ][ "Name" ])) { return ""; }

        if (!empty($this->Actions[ $data ][ "URLMethod" ]))
        {
            $method=$this->Actions[ $data ][ "URLMethod" ];
            return $this->$method($data,$item);
        }
        
        $args=$this->CGI_URI2Hash("");
        $args=$this->CGI_Hidden2Hash($args);
        if (!empty($this->ModuleName))
        {
            $args[ "ModuleName" ]=$this->ModuleName();
        }
        
        $args[ "Action" ]=$data;

        foreach (array("ID","RAW","NoHorMenu","NoSearch") as $key)
        {
            unset($args[ $key ]);
        }
        
        foreach (
                   array_merge
                   (
                      $noargs,
                      array("Profile","Admin"),
                      $this->NonPostVars,
                      $this->Actions[ $data ][ "NonPostVars" ],
                      $this->NonGetVars,
                      $this->Actions[ $data ][ "NonGetVars" ]
                   ) as $var
                )
        {
            if (isset($args[ $var ])) { unset($args[ $var ]); }
        }

        $var="";
        if (!empty($this->ModuleName))
        {
            $var=$this->IDGETVar;
        }
        
        if (
              empty($this->Actions[ $data ][ "Singular" ])
              &&
              !empty($var)
              &&
              !empty($args[ $var ])
           )
        {
            unset($args[ $var ]);
        }


        foreach ($rargs as $key => $value) { $args[ $key ]=$value; }

        if (!empty($this->Actions[ $data ][ "HrefArgs" ]))
        {
            $args=
                $this->CGI_URI2Hash
                (
                    $this->Actions[ $data ][ "HrefArgs" ],
                    $args
                );
        }
        
        $id="";
        if (isset($item[ "ID" ])) { $id=$item[ "ID" ]; }
        else                      { $id=$this->CGI_GETOrPOSTint("ID"); }

        if (
              $this->Actions[ $data ][ "AddIDArg" ]
              &&
              $id!="" && $id>0
           )
        {
            $args[ "ID" ]=$id;
        }

        foreach ($itemargs as $itemarg)
        {
            $args[ $itemarg ]=$item[ $itemarg ];
        }
        
        $href=$this->Actions[ $data ][ "Href" ];

        $action=
            $href."?".
            $this->CGI_Hash2Query($args);

        if ($id!="" && $id>0) { $action=preg_replace('/[\&\?]#ID/',$id,$action); }
        else                  { $action=preg_replace('/[\&\?]ID=#ID/',"",$action); }

        foreach ($this->ActionArgVars as $var)
        {
            $action=preg_replace('/#'.$var.'/',$this->$var,$action);
        }

        if (!empty($this->IDGETVar))
        {
            $action=preg_replace('/[\&\?]ID=/',"&".$this->IDGETVar."=",$action);
        }

        if (!empty($this->Actions[ $data ][ "Confirm" ]))
        {
            $title=$this->GetRealNameKey($this->Actions[ $data ],"ConfirmTitle");
            $action=$this->MyActions_Entry_Alert($action,$title,$item);
        }        

        return $this->Filter($action,$item);
    }
}