<?php

include_once("Search/Read.php");
include_once("Search/Title.php");
include_once("Search/Items.php");
include_once("Search/Hiddens.php");
include_once("Search/Script.php");


trait MyMod_Handle_Search
{
    use
        MyMod_Handle_Search_Read,
        MyMod_Handle_Search_Title,
        MyMod_Handle_Search_Items,
        MyMod_Handle_Search_Hiddens,
        MyMod_Handle_Search_Script;
    
    //*
    //* Handles module object Search.
    //*

    function MyMod_Handle_Search
        (
            $where="",$searchvarstable=TRUE,$edit=0,$group="",
            $omitvars=array(),$action="",$module="",
            $savebuttonname="",$resetbottonname=""
        )
    {
        if
            (
                $edit==0
                &&
                $this->MyAction_Allowed("EditList")
                &&
                $this->MyMod_Search_Options_Details_Edit_Value()==1
            )
        {
            $edit=1;
        }
                       
        $this->Htmls_Echo
        (
            $this->MyMod_Handle_Search_Generate
            (
                $where,
                $searchvarstable,
                $edit,
                $group,
                $omitvars,
                $action,
                $module,
                $savebuttonname,
                $resetbottonname
            )
        );
    }

   
    //*
    //* Should we generate search table?
    //*

    function MyMod_Handle_Search_Should($searchvarstable)
    {
        if (!$searchvarstable) { return False; }
        
        $res=True;
        if (!empty($this->CGI_GETint("NoSearch")))
        {
            $res=False;
        }

        if (!empty($this->CGI_GETint("Search")))
        {
            $res=True;
        }

        return $res;      
     }
    
    //*
    //* Destination cell ID of Search results table.
    //*

    function MyMod_Handle_Search_Results_Destination_ID($key="")
    {
        return $this->CGI_GET("Dest")."_Search".$key;
    }

    
    //*
    //* Handles module object Search.
    //*

    function MyMod_Handle_Search_Generate
       (
           $where="",$searchvarstable=TRUE,$edit=0,$group="",
           $omitvars=array(),$action="",$module="",
           $savebuttonname="",$resetbottonname=""
       )
   {
      $this->Singular=FALSE;
      $this->Plural=TRUE;

      $searchvarstable=$this->MyMod_Handle_Search_Should($searchvarstable);
      
      if ($this->CGI_GETOrPOSTint("LatexDoc")>0)
      {
          $this->MyMod_Handle_Prints($where);
      }

      $output=$this->MyMod_Search_Options_Export_CGI_Value();


      if (empty($output))
      {
          $this->MyMod_Handle_DocHeads($force=True);
          $this->MyMod_HorMenu_Echo(True);
      }
      else
      {
          $this->NoPaging=True;
      }


      if (empty($group))
      {
          $group=$this->MyMod_Data_Group_Actual_Get();
      }

      $datas=$this->MyMod_Data_Group_Datas_Get($group);
      if ($output==4 || $output==5 || $output==6)
      {
          $datas=array_keys($this->ItemData);
      }

      if (!empty($group))
      {
          if
              (
                  empty($where)
                  &&
                  isset($this->ItemDataGroups[ $group ][ "SqlWhere" ])
              )
          {
              $where=$this->ItemDataGroups[ $group ][ "SqlWhere" ];
          }

          if
              (
                  isset($this->ItemDataGroups[ $group ][ "Edit" ])
                  &&
                  $this->ItemDataGroups[ $group ][ "Edit" ]
              )
          {
              $edit=1;
          }
          elseif
              (
                  isset($this->ItemDataGroups[ $group ][ "Edit_".$this->Profile() ])
                  &&
                  $this->ItemDataGroups[ $group ][ "Edit_".$this->Profile() ]
              )
          {
              $edit=1;
          }

          
          if (!empty($this->ItemDataGroups[ $group ][ "NItemsPerPage" ]))
          {
              $this->NItemsPerPage=$this->ItemDataGroups[ $group ][ "NItemsPerPage" ];
              
          }
      }

      $print=array();

      $this->MyMod_Sort_Detect($group);

      $hasitems=FALSE;
      if
          (
              $this->CGI_POSTint("SearchPressed")==1
              ||
              $this->IncludeAllDefault
          )
      {
          $this->MyMod_Handle_Search_Items_Read
          (
              $where,$datas,
              $searchvarstable,$nosearches=FALSE,
              $this->NoPaging
          );
      }
      
      if (count($this->ItemHashes)>0) { $hasitems=TRUE; }

      if (empty($output))
      {
          if ($searchvarstable)
          {
              array_push
              (
                  $print,
                  $this->Htmls_Text
                  (
                      $this->MyMod_Search_Form_List
                      (
                          array
                          (
                              "OmitVars" => $omitvars,
                              "Action" => $this->CGI_GET("Action"),
                              "Module" => $module,
                          )
                      )
                  )
              );
          }
      }


      $action=$this->MyActions_Detect();
      if ($this->MyMod_Search_CGI_Edit_Value()==2)
      {
          $edit=1;
      }

      if ($action=="EditList")
      {
          $edit=1;
      }
      
      $searchvars=$this->MyMod_Search_Vars_Hash($datas);
      if ($this->MyMod_Search_Vars_Add_2_List)
      {
          $datas=$this->MyMod_Search_Vars_Add_2_List($datas);
      }

      $table=
          $this->MyMod_Handle_Search_Items_Table
          (
              $output,
              $edit,
              "",
              $group
          );

      if (count($table)>0 && empty($output))
      {
          /* array_push */
          /* ( */
          /*     $print, */
          /*     $this->MyMod_Paging_Menu_Horisontal() */
          /* ); */

          array_unshift
          (
              $table,
              $this->MyMod_Handle_Search_Title_Section($group)
          );
      }
      
      

      //Return in input not HTML! (empty)
      if (!empty($output))
      {
          return $table;
      }

      if (count($table)>0)
      {
          array_push
          (
              $print,
              $this->Htmls_Comment_Section
              (
                  "Items Form",
                  $this->MyMod_Handle_Search_Generate_DIV($edit,$table)
              )
          );
      }
      
      return $print;
   }
    //*
    //* 
    //*

    function MyMod_Handle_Search_Generate_DIV($edit,$table)
    {
        return
            $this->Htmls_DIV
            (
                $this->MyMod_Handle_Search_Generate_Form($edit,$table),
                array
                (
                    "ID" =>
                    $this->MyMod_Handle_Search_Results_Destination_ID("_Results"),
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Search_Generate_Form($edit,$table)
    {
        $edit=0;
        return
            $this->Htmls_Form
            (
                $edit,
                "Search_Items_".$this->MyActions_Detect(),
                  
                "",
                //$contents=
                $this->MyMod_Handle_Search_Generate_Contents($edit,$table),
                //$args=
                array
                (
                    "Hiddens" => $this->MyMod_Handle_Search_Hiddens_Hash
                    (
                        $edit
                    ),
                    "Anchor" => "EditListForm",
                    "CGI_Args" => array
                    (
                        "ModuleName" => $this->CGI_GET("ModuleName"),
                        "Action" => $this->MyActions_Detect(),
                          
                    ),
                    "Buttons" => $this->Buttons(),
                ),
                //$options=
                array
                (
                    "ID" => "EditListForm",
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Search_Generate_Contents($edit,$table)
    {
        return
            array
            (
                $this->MyMod_Handle_Search_Generate_Contents_Title(),
                $this->Htmls_Table
                (
                    "",
                    $table,
                    array("WIDTH" => '100%'),
                    array(),
                    array(),
                    True,True
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Search_Generate_Contents_Title()
    {
        $title="";
        if ($this->MyMod_Paging_N>1)
        {
            $titles=
                $this->H
                (
                    1,
                    $this->MyLanguage_GetMessage("Search").
                    " ".
                    $this->MyMod_ItemsName()
                );            
        }

        return $title;
    }
}

?>