<?php

trait MyLanguage_File
{
    var $Message_Files_Read=False;
    
    //*
    //* Adds message $files to $this->Messages;
    //*

    function MyLanguage_Files_Add($files)
    {
        foreach ($files as $file)
        {
            $this->MyLanguage_File_Add($file);   
        }
    }

    //*
    //* Adds message $file to $this->Messages;
    //*

    function MyLanguage_File_Add($file)
    {
        if (empty($this->ApplicationObj()->MessagesFiles[ $file ]))
        {
            $this->ApplicationObj()->MessagesFiles[ $file ]=$file;

            foreach ($this->ReadPHPArray($file) as $key => $value)
            {
                $this->ApplicationObj()->Messages[ $key ]=$value;
                $this->ApplicationObj()->Messages[ $key ][ "File" ]=$file;
            }
        }

        return $file;
    }
}
?>