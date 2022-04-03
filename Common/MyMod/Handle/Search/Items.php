<?php

trait MyMod_Handle_Search_Items
{
   //*
   //* Generates the paged item list table.
   //*

   function MyMod_Handle_Search_Items_Table($output,$edit,$title,$group)
   {
       $table=array();

       $landscape=False;
       if ($this->MyMod_Search_Options_Export_Orientation_CGI_Value()==2)
       {
           $landscape=True;
       }

       if (empty($output))
       {           
           $table=
               $this->MyMod_Handle_Search_Items_Group_Table
               (
                   $edit,$title,$group
               );

           if (!empty($this->ItemDataGroups[ $group ][ "TitleGenMethod" ]))
           {
               $method=$this->ItemDataGroups[ $group ][ "TitleGenMethod" ];
               array_unshift($table,array($this->$method()));
           }
       }
       elseif ($output==1)
       {
           $table=$this->MyMod_Items_CSV_Table();
       }
       elseif ($output==2) //just latex
       {
           $table=$this->MyMod_Items_Latex_Table
           (
               $latex_only=True,
               $items=array(),
               $datas=array(),
               $titles=array(),
               $landscape
           );
       }
       elseif ($output==3) //pdf
       {
           $table=
               $this->MyMod_Items_Latex_Table
               (
                   $latex_only=False,
                   $items=array(),
                   $datas=array(),
                   $titles=array(),
                   $landscape
               );
       }
       elseif ($output==4) //JSON
       {
           $table=
               $this->MyMod_Items_JSON_Table();
       }
       elseif ($output==5) //PHP
       {
           $table=$this->MyMod_Items_PHP_Table();
       }
       elseif ($output==6) //SQL (Dialect used)
       {
           $table=$this->MyMod_Items_SQL_Table();
       }

       if (empty($table)) { $table=array(); }
       
       return $table;
   }
   
   //*
   //* Generates the paged item list table.
   //*

   function MyMod_Handle_Search_Items_Group_Table($edit,$title,$group)
   {
       $dynamic=$this->ItemDataGroups($group,"Dynamic");

       
       $table=array();
       if (empty($dynamic))
       {
           $table=
               $this->MyMod_Data_Group_Table
               (
                   $title,
                   $edit,
                   $group,
                   array()
               );
       }
       else
       {
           $table=
               $this->MyMod_Items_Dynamic_Html
               (
                   $edit,
                   $this->ItemHashes,
                   $group,

                   $extrarows=array(),$options=array(),$notitle=True,
                   $form=True                   
               );
       }
       
       return $table;
   }
}

?>