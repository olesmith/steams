<?php

include_once("Handle/Help.php");
include_once("Handle/Add.php");
include_once("Handle/Show.php");
include_once("Handle/Edit.php");
include_once("Handle/Copy.php");
include_once("Handle/Delete.php");
include_once("Handle/Search.php");
include_once("Handle/Print.php");
include_once("Handle/Prints.php");
include_once("Handle/Files.php");
include_once("Handle/Info.php");
include_once("Handle/Download.php");
include_once("Handle/Unlink.php");
include_once("Handle/Zip.php");
include_once("Handle/Export.php");
include_once("Handle/Import.php");
include_once("Handle/Process.php");
include_once("Handle/Email.php");
include_once("Handle/Test.php");
include_once("Handle/Latex.php");

//trait Students_History_Update

trait MyMod_Handle
{
    use
        MyMod_Handle_Help,
        MyMod_Handle_Add,
        MyMod_Handle_Show,
        MyMod_Handle_Edit,
        MyMod_Handle_Copy,
        MyMod_Handle_Delete,
        MyMod_Handle_Search,
        MyMod_Handle_Print,
        MyMod_Handle_Prints,
        MyMod_Handle_Files,
        MyMod_Handle_Info,
        MyMod_Handle_Zip,
        MyMod_Handle_Download,
        MyMod_Handle_Unlink,
        MyMod_Handle_Export,
        MyMod_Handle_Import,
        MyMod_Handle_Process,
        MyMod_Handle_Email,
        MyMod_Handle_Test,
        MyMod_Handle_Latex;


    
    //*
    //* Read Item based on CGI, if CGI parms specified.
    //*

    function MyMod_Handle_Item_ID_CGI()
    {
        //Do we need to read an item?
        $id=0;
        if ($this->IDGETVar)
        {
            $id=$this->CGI_GETOrPOSTint($this->IDGETVar);
        }

        if (empty($id))
        {
            $id=$this->CGI_GETOrPOSTint("ID");
        }

        return $id;
    }
    
    //*
    //* Read Item based on CGI, if CGI parms specified.
    //*

    function MyMod_Handle_Item_Read()
    {
        if (empty($this->ItemHash))
        {
            $this->MyMod_Item_Read
            (
                $this->MyMod_Handle_Item_ID_CGI()
            );
        }

        $this->ItemHash[ "ModuleName" ]=$this->ModuleName;
        if (empty($this->ItemHash))
        {
            $this->DoDie
            (
                "Table::Handle ".$this->ModuleName.
                ": Not found or not allowed... (".$id.") - bye-bye.."
            );
        }
    }
    
    //*
    //* The main MyMod handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyMod_Handle($args=array())
    {
        $action=$this->CGI_Get("Action");
        if (!empty($args[ "Action" ]))
        {
            $action=$args[ "Action" ];
            $this->__Force_Action__=$action;
        }
        
        if (empty($action)) { $action=$this->DefaultAction; }
        //Removed, 20211023
        //$this->ModuleName=$this->CGI_Get("ModuleName");

        //Load actions if necessary
        $this->Actions();
        
        if (!empty($this->Actions[ $action ]))
        {
            $item=array();
            if (!empty($this->Actions[ $action ][ "Singular" ]))
            {
                $this->MyMod_Handle_Item_Read();
                $item=$this->ItemHash;
            }

            
            $res=$this->MyAction_Allowed($action,$item);
            if (!$res)
            {
                if (!empty($this->Actions[ $action ][ "AltAction" ]))
                {
                    $action=$this->Actions[ $action ][ "AltAction" ];
                    $res=$this->MyAction_Allowed($action,$item);
                }
            }

            
            if ($res)
            {
                if (empty($this->Actions[ $action ][ "NoLogging" ]))
                {
                    $this->ApplicationObj()->LogMessage($action,"MyMod_Handle");
                }

                $this->Handle($action);
            }
            else
            {
                $this->DoDie
                (
                    "Action not allowed",
                    $this->ModuleName,$action,
                    $this->Actions[ $action ],
                    $this->MyAction_Allowed_Permissions_Get($action)
                );
            }
        }
        else
        {
            $this->DoDie("Action inexistent",$this->ModuleName,$action,$this->Actions);
        }
    }


    //*
    //* ModuleHandler
    //*

    function Handle($action="")
    {
        if ($this->NoHandle!=0) { return; }
        
        $this->ItemData();
        $this->Actions();
        $this->ItemDataGroups();

        $item=$this->ItemHash;

        //Do we have a suitable action?
        if (empty($action))
        {
            $action=$this->MyActions_Detect();
        }
        
        if (empty($action))
        {
            $this->DoDie
            (
                "Table::Handle ".
                $this->ModuleName.
                ": Undefined action '$action' - redirect\n"
            );

            $this->Redirect();
            $this->DoExit();
        }

        $res=
            $this->MyAction_Allowed($action);
        
        if (!$res)
        {
            $this->Redirect();
            $this->DoExit();
        }


        if (empty($this->Actions[ $action ][ "Handler" ]))
        {
            var_dump($_GET);
            var_dump("Empty handler",$action,$this->Actions[ $action ]);            
            exit();
        }
        
        $handler=$this->Actions[ $action ][ "Handler" ];
        if ($handler=="")
        {
            $handler="Handle".$action;
        }

        if (!empty($this->Actions[ $action ][ "Singular" ])) { $this->Singular=TRUE; }

        if (!method_exists($this,$handler))
        {
            echo 
                $this->ModuleName.
                ": Undefined handler, action $action (".
                $this->Actions[ $action ][ "Handler" ].
                "), $handler\n";

            //$this->CGI_Redirect();
            $this->DoExit();
        }

        $this->ApplicationObj()->MyApp_Module=$this->ModuleName;
        $this->ApplicationObj()->MyApp_Handler=$handler;

        $this->MyMod_Handle_DocHeads();

        $id="";
        if (!empty($item[ "ID" ]))
        {
            $id=$item[ "ID" ];
        }
        
        //$this->MyMod_Handle_Scripts_Pre($action,$id,$item);

        
        $this->Sql_Tables_Structure_Default_Items_Add();
        
        $this->ItemHash=$item;
        if (method_exists($this,"PreHandle"))
        {
            $this->PreHandle();
        }

        $this->MyMod_Handle_Scripts_Run($action);

        if (method_exists($this,"PostHandle"))
        {
            $this->PostHandle();
        }

        $this->MyMod_Handle_Scripts_Post($action,$id,$item);

     }

    
    //*
    //* Terminate div from MyMod_Handle_Scripts_Pre
    //*

    function MyMod_Handle_Scripts_Run($action)
    {
        $handler=$this->Actions[ $action ][ "Handler" ];
        if ($handler=="")
        {
            $handler="Handle".$action;
        }
        $this->MyMod_Handle_Messages($action);
        //$this->MyMod_Handle_Scripts_Pre($action);
        $this->$handler();
        //$this->MyMod_Handle_Scripts_Post($action);
    }
    
    //*
    //* Include Module/Action messages.
    //*

    function MyMod_Handle_Messages($action)
    {
        $messages=
            $this->LanguagesObj()->Sql_Select_Hashes
            (
                array
                (
                    "Message_Type" => $this->LanguagesObj()->Language_Help_Type,
                    "Module"       => $this->ModuleName,
                    "Message_Key"  => $action,
                ),
                array
                (
                    
                )
            );

        $language=$this->MyLanguage_Get();
        $table=array();

        foreach ($messages as $message)
        {
            $row=
                array
                (
                    $this->Htmls_DIV
                    (
                        array
                        (
                            $this->Htmls_Tag
                            (
                                "U",
                                $message[ "Name_".$language ].":"
                            ),
                            $message[ "Title_".$language ]
                        ),
                        array
                        (
                            "CLASS" => "messages"
                        )
                    ),
                );
            
            array_push($table,$row);
        }
       
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Table
                (
                    "",
                    $table
                )
            )
        );

        return array();
    }
    
    //*
    //* Terminate div from MyMod_Handle_Scripts_Pre
    //*

    function MyMod_Handle_Scripts_Pre($action)
    {
        if (!$this->MyMod_RAW_Is())
        {
            $this->Htmls_Echo
            (
                array
                (
                    "<!--MyMod_Handle_Scripts_Pre Start ->",
                    $this->Htmls_Tag_Start
                    (
                        "DIV",
                        "",
                        array
                        (
                            "ID" => $this->MyMod_HorMenu_Destination_ID($action),
                        )
                    ),
                    "<!--MyMod_Handle_Scripts_Pre End ->",
                )
            );
        }
    }
    
    //*
    //* Div 
    //*

    function MyMod_Handle_Scripts_Post($action)
    {
        if (!$this->Doc_Heads_Send) { return; }
        //Send ending div - removed: Load current action
        if (!$this->MyMod_RAW_Is())
        {
            $this->Htmls_Echo
            (
                array
                (
                    $this->Htmls_Tag_Close("DIV","MyMod_Handle_Scripts_Post"),
                )
                
            );
        }
    }

    var $Doc_Heads_Send=False;
    
    //*
    //* Print the doc headers.
    //*

    function MyMod_Handle_DocHeads($force=FALSE)
    {
        if ($this->Doc_Heads_Send) { return; }
        
        $latex=0;
        $latex=$this->CGI_GETOrPOSTint("Latex");
        if ($latex>=1)
        {
            $this->ApplicationObj()->SetLatexMode();
            return;
        }

        $zip=0;
        $zip=$this->CGI_GETOrPOSTint("ZIP");

        if ($zip==1) { return; }

        $latexdoc=$this->CGI_GETOrPOSTint("LatexDoc");
        if (empty($latexdoc)) { $latexdoc=0; }
        if (empty($latexdoc)) { $latexdoc=0; }
        if ($latexdoc==0 || $force)
        {
            $action=$this->MyActions_Detect();
            if
                (
                    empty($this->Actions[ $action ][ "NoHeads" ])
                    ||
                    $this->Actions[ $action ][ "NoHeads" ]!=1
                    ||
                    $force
                )
            {

                $this->ApplicationObj()->MyApp_Interface_Head();
                
                if (method_exists($this,"MyMod_Handle_Pre"))
                {
                    $this->MyMod_Handle_Pre();
                }

                if
                    (
                        !isset($this->Actions[ $action ][ "NoInterfaceMenu" ])
                        ||
                        $this->Actions[ $action ][ "NoInterfaceMenu" ]!=1
                        ||
                        $force
                  )
                {
                      if (empty($this->Actions[ $action ][ "NoInterfaceMenu" ]))
                      {
                          $singular=FALSE;
                          if (isset($this->Actions[ $action ][ "Singular" ]))
                          {
                              $singular=!$this->Actions[ $action ][ "Singular" ];
                          }
                          
                          $this->MyMod_HorMenu_Echo($singular);
                      }
                }

                //SEARCH DID NOT LOAD CORRECTLY
                $this->MyMod_Handle_Scripts_Pre($action);

                $this->Doc_Heads_Send=True;

            }

        }
    }

    
}

?>