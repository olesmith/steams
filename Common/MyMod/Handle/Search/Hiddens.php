<?php

trait MyMod_Handle_Search_Hiddens
{
   //*
   //* function MyMod_Handle_Search_Hiddens_Hash, Parameter list: 
   //*
   //* Returns hiddens to include in result table form.
   //*

   function MyMod_Handle_Search_Hiddens_Hash($edit)
   {
       return
           array_merge
           (
               array
               (
                   "Update"    => 1,
                   "EditList"  => $edit,
                   "__MTime__" => time(),
               ),
               $this->MyMod_Handle_Search_Hiddens_Options_Hash($edit),
               $this->MyMod_Search_Hiddens_Hash(),
               $this->CGI_Hiddens_Hash()
           );
   }
   
   //*
   //* function MyMod_Handle_Search_Options_Hash, Parameter list: 
   //*
   //* Returns hash of search uption filed/values.
   //* May be used for generating cookes or hiddens.
   //*

   function MyMod_Handle_Search_Hiddens_Options_Hash($edit)
   {
       $hash=
           array
           (
               $this->MyMod_Groups_CGI_Key() => $this->MyMod_Data_Group_Actual_Get(),
               $this->MyMod_Groups_CGI_Edit_Key() => $edit+1,
           );
       
       foreach
           (
               array
               (
                   "MyMod_Search_CGI_Include_All_Key"
                   =>
                   "MyMod_Search_CGI_Include_All_Value",

                   
                   "MyMod_Search_CGI_Edit_Key"
                   =>
                   "MyMod_Search_CGI_Edit_Value",

                   
                   "MyMod_Search_CGI_Page_Key"
                   =>
                   "MyMod_Search_CGI_Page_Value",
               )
               as $func1 => $func2
           )
       {
           $hash[ $this->$func1() ]=$this->$func2();
       }

       return $hash;
   }
}

?>