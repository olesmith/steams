<?php

trait MyMod_Handle_Prints_Sort
{
    //*
    //* Handles module object Prints. Deprecated
    //*

    function MyMod_Handle_Prints_Sort($type,$docno)
    {
       $sort="";
       if
           (
               isset
               (
                   $this->LatexData[ $type ]
                   [ "Docs" ][ $docno ][ "Sort" ]
               )
           )
       {
           $sort=
               $this->LatexData[ $type ]
               [ "Docs" ][ $docno ][ "Sort" ];
       }

       if ($sort=="")
       {
           $this->MyMod_Sort_Detect();
       }
       else
       {
           $this->Sort=$sort;
       }

       return $sort;
    }
}

?>