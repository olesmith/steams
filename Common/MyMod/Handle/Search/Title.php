<?php

trait MyMod_Handle_Search_Title
{
   //*
   //* Generates title for search/editlist table.
   //*

   function MyMod_Handle_Search_Title_Section($group)
   {
       $title_method=
           $this->ItemDataGroups($group,"Title_Method");

       if (!empty($title_method))
       {
           return $this->$title_method($group);          
       }
       
       return array();
           array
           (
               $this->Htmls_H
               (
                   1,
                   array
                   (
                       $this->LanguagesObj()->Message_Debug_Pre
                       (
                           $this->LanguagesObj()->Language_Module_Type,
                           "ItemsName",
                           array
                           (
                               "Module" => $this->ModuleName,
                           )
                       ),
                       $this->MyMod_ItemsName().": ",                     
                       $this->LanguagesObj()->Message_Debug_Pre
                       (
                           $this->LanguagesObj()->Language_Group_Type,
                           $group,
                           array
                           (
                               "Module" => $this->ModuleName,
                           )
                       ),
                       $this->MyMod_Data_Group_Name($group),
                   )
               )
           );
   }
}

?>