<?php

trait MyMod_Handle_Search_Script
{
   //*
   //* function MyMod_Handle_Search, Parameter list: 
   //*
   //* Handles module object Search.
   //*

   function MyMod_Handle_Search_SCRIPTs($action)
   {
       $group=$this->MyMod_Data_Group_Actual_Get();
       
       $scripts=array();
       /* foreach ($this->ItemDataGroups($group,"Dynamic") as $action => $cell) */
       /* { */
       /*     array_push */
       /*     ( */
       /*         $scripts, */
       /*         $action */
       /*     ); */
       /* } */
       
       return $scripts;
   }
}

?>