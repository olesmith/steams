<?php

include_once("Info/CGI.php");
include_once("Info/Datas.php");
include_once("Info/Titles.php");
include_once("Info/Read.php");
include_once("Info/Row.php");
include_once("Info/Rows.php");
include_once("Info/Table.php");
include_once("Info/Update.php");
include_once("Info/Form.php");
include_once("Info/Menu.php");

trait MyMod_Handle_Info
{
    use
        MyMod_Handle_Info_CGI,
        MyMod_Handle_Info_Datas,
        MyMod_Handle_Info_Titles,
        MyMod_Handle_Info_Read,
        MyMod_Handle_Info_Row,
        MyMod_Handle_Info_Rows,
        MyMod_Handle_Info_Table,
        MyMod_Handle_Info_Update,
        MyMod_Handle_Info_Form,
        MyMod_Handle_Info_Menu;
    
    var $Info_Menu_Class="InfoMenu";
    
    var $Messages_Hide=True;
    var $Messages_Titles_Every=5;
    
    //*
    //* Initializes: if POST Module is set, reloads as that module.
    //*

    function MyMod_Handle_Info_Init()
    {
        $module=$this->CGI_POST("Module");
        if (!empty($module))
        {
            $args=$this->CGI_URI2Hash();
            $args[ "ModuleName" ]=$module;

            $this->CGI_Redirect
            (
                "?".
                $this->CGI_Hash2URI($args)
            );
        }
        
        $type=$this->CGI_GET("Type");
        if (empty($type))
        {
            $this->MyMod_Handle_DocHeads($force=True);
        }
    }
    
    //*
    //* Handles module object info.
    //*

    function MyMod_Handle_Info()
    {
        $this->MyMod_Handle_Info_Init();
        
        $this->LanguagesObj()->Actions();
        $this->LanguagesObj()->Actions[ "Edit" ][ "Target" ]="Messages";

        $this->LanguagesObj()->Language_Module_Update
        (
            $this->ModuleName,
            array(),
            $force=True
        );
        
        $head=$this->MyMod_Handle_Info_Head();
        if (empty($_GET[ "Type" ] ))
        {
             $head=$this->Htmls_Text($head);
        }

        
        $this->MyMod_Handle_Info_Type($head);
    }

    //*
    //* Generates module with sql tables info.
    //*

    function MyMod_Handle_Info_Message_Hide_Should($groupno)
    {
        if
            (
                $this->MyMod_Handle_Info_CGI_Language_Edit_Value($groupno)
                ==1
            )
        {
            return False;
        }
        
        return $this->Messages_Hide;
    }
    
    //*
    //* Handles module object info.
    //*

    function MyMod_Handle_Info_Head()
    {
        $table=
            array
            (
               array
               (
                   "",
                  $this->B("Module:"),
                  $this->ApplicationObj()->MyApp_Module_Select
                  (
                      $this->ModuleName
                  ),
                  "",
               ),
               array
               (
                  $this->B("SqlClass:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlClass" ],
                  $this->B("SqlFile:"),
                  $this->ApplicationObj()->SubModulesVars
                  [ $this->ModuleName ][ "SqlFile" ],
               ),
                array
               (
                  $this->B("SqlFilter:"),
                  $this->ApplicationObj()->SubModulesVars
                  [ $this->ModuleName ][ "SqlFilter" ],
                  $this->B("SqlDerivedData:"),
                  $this->ApplicationObj()->SubModulesVars
                  [ $this->ModuleName ][ "SqlDerivedData" ],
               ),
               array
               (
                  $this->B("Item Name:"),
                  $this->MyMod_ItemName(),
                  $this->MyMod_Handle_Message_Edit_Action
                  (
                      array
                      (
                          "Message_Type" => $this->LanguagesObj()->Language_Module_Type,
                          "Message_Key"  => "ItemName",
                          "Module" => $this->ModuleName,
                      ),
                      "Edit",
                      $this->MyMod_ItemHash("ItemName")
                  ),
               ),
               array
               (
                  $this->B("Items Name:"),
                  $this->MyMod_ItemsName(),
                  $this->MyMod_Handle_Message_Edit_Action
                  (
                      array
                      (
                          "Message_Type" => $this->LanguagesObj()->Language_Module_Type,
                          "Message_Key"  => "ItemsName",
                          "Module"       => $this->ModuleName,
                      ),
                      "Edit",
                      $this->MyMod_ItemHash("ItemsName")
                  ),
               ),
               array
               (
                  $this->B("Item Namer:"),
                  $this->ItemNamer,
               ),
            );
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->H(1,"Module Info"),
                        $this->Htmls_Table("",$table),
                        $this->MyMod_Handle_Info_Tables(),
                        $this->MyMod_Handle_Info_Menu(),
                    ),
                    array
                    (
                        "ID" => "Module_Info_Field",
                    )
                ),
            );
    }
    
    //*
    //* Handles module object info.
    //*

    function MyMod_Handle_Info_Type($head)
    {
        $type=$this->MyMod_Handle_Info_CGI_Type_Value();
        
        $html=array($head);
        if ($type=="Data")
        {
            $html=$this->MyMod_Data_Info_Form(1);
        }
        elseif ($type=="Actions")
        {
            $html=$this->MyMod_Actions_Info_Form(1);
        }
        elseif ($type=="Groups")
        {
            $html=$this->MyMod_Data_Groups_Info_Form(1,False);
        }
        elseif ($type=="SGroups")
        {
            $html=$this->MyMod_Data_Groups_Info_Form(1,TRUE);
        }        
        elseif ($type=="HorMenu")
        {
            $html=$this->MyMod_HorMenu_Info(TRUE);
        }

        $this->Htmls_Echo
        (
            $this->Htmls_DIV
            (
                $html,
                array("ID" => "Languages_Info_Field")
            )
        );
    }
    
    //*
    //* Generates module with sql tables info.
    //*

    function MyMod_Handle_Info_Tables()
    {
        $this->LanguagesObj()->ItemData();

        $tablename=$this->SqlTableName();

        $regex='^\d+__';
        
        $tablename=preg_replace('/'.$regex.'/',$this->Unit("ID")."__",$tablename);
        $regex='_\d+_';
        $tablename=preg_replace('/'.$regex.'/','_\d+_',$tablename);

        $leading="^";
        $sqltables=$this->Sql_Table_Names($leading.$tablename.'$');

        sort($sqltables);
        $table=array();
        $n=1;
        $nitems=0;
        foreach ($sqltables as $sqltable)
        {
            $mtime=$this->Sql_Select_Hash_Value($sqltable,"Time","Name",FALSE,"__Table__");
            $nitem=$this->Sql_Select_NHashes("",$sqltable);
            $nitems+=$nitem;
            $row=
                array
                (
                   $this->B($n++).":",
                   $sqltable,
                   $this->TimeStamp2Text($mtime),
                   $this->Sql_Select_NHashes("",$sqltable),
                );

            array_push($table,$row);
        }

        array_push
        (
            $table,
            array(),
            array
            (
                "","",
                $this->B($this->ApplicationObj()->Sigma.":"),$nitems
            )
        );
        
        return
            array
            (
                //Edit destination
                $this->Htmls_DIV
                (
                    "...",
                    array
                    (
                        "ID" => $this->ModuleName."_Edit",
                        "STYLE" => array
                        (
                            "display" => 'none',
                            "width"   => '75%',
                            "max-width"   => '75%',
                        ),
                    )
                ),
                $this->H(2,"SQL Tables"),
                $this->Htmls_Table
                (
                    array("No.","SQL Table","Last Struct. Update","No. Items"),
                    $table
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Message_Edit_Action($where,$action="Edit",$hash=array())
    {
        $where[ "Module" ]=$this->ModuleName;
        $msg=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        if (!empty($hash))
        {
            if (!empty($msg))
            {
                $file="";
                if (!empty($hash[ "File" ]))
                {
                    $file=$hash[ "File" ];
                }

                /* //??? */
                /* $this->LanguagesObj()->Language_Module_Item_Update_Do */
                /* ( */
                /*     $this->ModuleName, */
                /*     $file, */
                /*     $where[ "Message_Key" ], */
                /*     $hash, */
                /*     $where[ "Message_Type" ], */
                /*     $force=True */
                /* ); */
            }
            else
            {
                $action="Add";
                $this->LanguagesObj()->Actions[ "Add" ][ "Target" ]="Languages";
                $msg=array();
            }
        }
        
        return 
            $this->LanguagesObj()->MyActions_Entry_Button
            (
                array
                (
                    "Tag" => "SPAN",
                    "ID" => $where[ "Message_Key" ],
                    "Destination" => $this->ModuleName."_Edit",
                ),
                $action,
                $msg
            );
        return 
            $this->LanguagesObj()->MyActions_Entry
            (
                $action,
                $msg
            );
    }

    

    
}

?>