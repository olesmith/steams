<?php

trait MyActions_Entry_Name
{
    //*
    //* function MyActions_Entry_Title, Parameter list: $data,$item=array()
    //*
    //* Generates only action title.
    //*

    function MyActions_Entry_Title($data="",$item=array(),$key="Title")
    {
        if (empty($data)) { $data=$this->CGI_GET("Action"); }
        
        if (!empty($this->Actions[ $data ][ "TitleMethod" ]))
        {
            $method=$this->Actions[ $data ][ "TitleMethod" ];
            return $this->$method($data,$item);
        }
        
        $title=
            $this->LanguagesObj()->Language_Action_Title_Get
            (
                $this,
                $data,
                $key
            );

        if (!empty($item))
        {
            $title=$this->Filter($title,$item);
        }
        
        return $title;
    }

    //*
    //* function MyActions_Entry_Name, Parameter list: $data,$noicons=0,$item=array(),$icon="",
    //*
    //* Generates only action name (content
    //*

    function MyActions_Entry_Name($data,$noicons=0,$item=array(),$icon="",$name="",$size="")
    {
        if (!empty($name)) { return $name; }

        $def=$this->Actions($data);

        if (!empty($this->Actions[ $data ][ "NameMethod" ]))
        {
            $method=$this->Actions[ $data ][ "NameMethod" ];
            return $this->$method($data,$item);
        }
        
        return 
            $this->Filter
            (
                $this->MyActions_Entry_Icon($data,$noicons,$size,$icon),
                $item
            );
    }
}