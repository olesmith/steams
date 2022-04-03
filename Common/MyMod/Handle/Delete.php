<?php

trait MyMod_Handle_Delete
{
    //*
    //* function MyMod_Handle_Delete_Confirm_Message, Parameter list: 
    //*
    //* Called from delete MyAction_Entry, to add confirm messages on icon.
    //* Based on:
    //*
    //* $this->Actions[ "Delete" ][ "Confirm" ]
    //* and
    //* $this->Actions[ "Delete" ][ "ConfirmTitle" ],
    //*
    //* the latter being this method.
    //*

    function MyMod_Handle_Delete_Confirm_Message($item)
    {
        $msgs=
            array
            (
                $this->MyLanguage_GetMessage("Delete_Confirm_Message"),
                $this->MyMod_ItemName(),
            );

        if (!empty($item[ $this->ItemNamer ]))
        {
            array_push
            (
                $msgs,
                $item[ $this->ItemNamer ]
            );    
        }

        array_push
        (
            $msgs,
            ", ID: ".$item[ "ID" ]
        );

        
        return join(" ",$msgs)."?";
        
    }
    
    //*
    //* function MyMod_Handle_Delete_Redirect_URI, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Delete_Redirect_URI()
    {
          $referer=$this->CGI_URI2Hash($_SERVER[ "HTTP_REFERER" ]);

          #Avoid trying to reload as singular instance of same ID - raises error.

          $uri=$_SERVER[ "HTTP_REFERER" ];
          if
              (
                  !empty($referer[ "ModuleName" ])
                  &&
                  $referer[ "ModuleName" ]==$this->ModuleName
                  &&
                  !empty($referer[ "ID" ])
                  //&&
                  //$referer[ "ID" ]==$this->ItemHash[ "ID" ]
              )
          {
              $referer[ "Action" ]="Search";
              unset($referer[ "ID" ]);

              $uri="?".$this->CGI_Hash2URI($referer);
          }

          return $uri."#Search_Items";
    }
  
    //*
    //* function MyMod_Handle_Delete, Parameter list: 
    //*

    function MyMod_Handle_Delete($echo=TRUE,$actionname="Delete",$formurl="?Action=Delete",$idvar="ID")
    {
        if ($this->MyAction_Allowed($actionname))
        {
            return
                $this->MyMod_Handle_Delete_Form
                (
                    array(),$echo,$formurl,$idvar
                );
        }
        else { $this->DoDie("Deletar não permitido"); }
    }

  
    //*
    //* Creates form for deleting an item. If $_POST[ "Delete" ] is 1,
    //* calls Delete for actual deletion.
    //*

    function MyMod_Handle_Delete_Form($item=array(),$echo=TRUE,$formurl="?Action=Delete",$idvar="ID")
    {
        if (!is_array($item) || count($item)==0) { $item=$this->ItemHash; }
        
         
        $html=array();
        if ($this->CGI_POSTint("Delete")==1)
        {
            $this->MyMod_Handle_Delete_Do($item,$echo);
            $html=
                $this->MyMod_Handle_Delete_Html
                (
                    $this->MyLanguage_GetMessage("Delete_Confirmed_Message"),
                    $item
              );
        }
        else
        {
            array_push
            (
                $html,
                $this->Htmls_Form
                (
                    1,
                    "Delete_".$this->ModuleName."_".$item[ "ID" ],
                    "",

                    //$contents=

                    $this->MyMod_Handle_Delete_Html
                    (
                        $this->MyLanguage_GetMessage("Delete_Confirm_Message"),
                        $item
                    ),
                    
                    //$args=
                    array
                    (
                        "Hiddens" => array
                        (
                            $idvar => $item[ "ID" ],
                            "Delete" => 1,

                            //"Referer" => $_SERVER[ "HTTP_REFERER" ],
                        ),
                        "Buttons" => $this->MakeButton
                        (
                            "submit",
                            ">>".
                            $this->MyLanguage_GetMessage("DeleteButtonTitle").
                            "<<"
                        ),
                    )
                )
                
            );
        }

        if ($echo)
        {
            $this->Htmls_Echo($html);
            return $item;
        }
        else
        {
            return $html;
        }
    }
    
    
    //*
    //* Deletes item from DB.
    //*

    function MyMod_Handle_Delete_Html($title,$item)
    {
        return
            array
            (
                $this->H
                (
                    1,
                    $title
                ),
                $this->H
                (
                    2,
                    $this->MyMod_ItemName(": ").
                    $this->GetRealNameKey($item,$this->ItemNamer)
                ),
                $this->MyMod_Item_SGroup_Html
                (
                    0,
                    $item,
                    $this->MyMod_Handle_Show_SGroup_CGI()
                ),
            );
         
    }
    
    //*
    //* Deletes item from DB.
    //*

    function MyMod_Handle_Delete_Do($item=array(),$echo=TRUE)
    {
        if (count($item)>0) {} else { $item=$this->ItemHash; }

        $this->ApplicationObj->LogMessage
        (
            "Item Deleted",
            $item[ "ID" ].
            ": ".
            $this->MyMod_Item_Name_Get($item)
        );
        
        $this->Sql_Delete_Item($item[ "ID" ],"ID",$this->SqlTableName());

        return $item;
    }

}

?>