<?php

trait MyMod_Handle_Copy
{
    //*
    //* function MyMod_Handle_Copy, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Copy()
    {
        $title=$this->GetRealNameKey($this->Actions[ "Copy" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Copy" ],"PName");

        $this->MyMod_Handle_Copy_Form($title,$ptitle);
    }
    
    //*
    //* Postprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Pre_Process(&$item)
    {
    }
    
    //*
    //* Postprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Post_Process(&$item)
    {
    }
    
    //*
    //* Creates form for copying an item. If $_POST[ "Update" ]==1,
    //* calls Copy.
    //*

    function MyMod_Handle_Copy_Form($title,$copiedtitle)
    {
        $this->Singular=TRUE;
        $this->NoFieldComments=TRUE;

        $item=$this->ItemHash;
        $this->MyMod_Handle_Copy_Pre_Process($item);
        
        $this->MyMod_Data_Add_Default_Init($item);

        $action="Copy";
        $msg="";
        if ($this->CGI_POSTint("Copy")==1)
        {
            $res=$this->MyMod_Handle_Copy_Do($item,$msg);
            if ($res)
            {
                $this->MyMod_Handle_Copy_Redirect($item);
            }
        }

        #Send headers and leading html.
        //$this->ApplicationObj->MyApp_Interface_Head();

        foreach ($this->AddDefaults as $data => $value)
        {
            if (empty($item[ $data ]))
            {
                $item[ $data ]=$value;
                $item[ $data."_Value" ]=$value;
            }
        }
        
        $this->MyMod_Handle_Copy_Post_Process($item);
        $this->AddDefaults=$item;

        
        //$this->MyMod_HorMenu_Echo(TRUE,$this->CGI_GET("ID"));

        
        $this->Htmls_Echo
        (
            $this->Htmls_Form
            (
                1,
                "Copy_Form",
                $action,
                array
                (
                    $this->H(2,$title),
                    $msg,
                    $this->H(3,$this->MyMod_Item_Name_Get($item)),
                    $this->MyMod_Handle_Add_Table
                    (
                        $this->MyMod_Data_Writeable(),
                        "Copy"
                    ),
                ),
                $args=array
                (
                    "JS_Static" => True,
                    "Hiddens" => array
                    (
                        "Copy" => 1,
                    ),
                    "Anchor" => "HorMenu",
                    "Buttons" => $this->Buttons
                    (
                        $this->MyLanguage_GetMessage("Copy_Button_Title").
                        " ".
                        $this->MyMod_ItemName()
                    ),
                ),
                $options=array
                (
                    "ID" => "Copy_Form",
                )
            )
        );
    }

    
    //*
    //* Relocates after finished copying.
    //*

    function MyMod_Handle_Copy_Redirect($item)
    {
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);

        #Send headers and leading html.
        //$this->ApplicationObj->MyApp_Interface_Head();

        $id="ID_".time();
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_DIV
                (
                    "",
                    array
                    (
                        "ID" => $id,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        "Click_Above('".$id."','".$args[ "Dest" ]."','".$item[ "ID" ]."');",
                    )
                )
            )
        );

        //var_dump($args);
        exit();

        $action=$this->MyActions_Detect();

        $this->CGI_CommonArgs_Add($args);
        $args[ "Action" ]=$this->MyActions_Detect();
        if ($args[ "Action" ]=="Copy")
        {
            $args[ "Action" ]=$this->MyMod_Add_Reload_Action;
        }

        $args[ "ID" ]=$this->ItemHash[ "ID" ];
        $args[ "Reload_Parent" ]=1;
        $var=$this->IDGETVar;
        if
            (
                !empty($var)
                &&
                !empty($args[ $var ])
            )
        {
            unset($args[ $var ]);
        }

        $this->ApplicationObj->LogMessage("Copy","Item Copied");
                
        //Now added, reload as edit, preventing multiple copies,
        //the user reloading the page.

        
        $this->CGI_Redirect($args);
        exit();
    }

    
    //*
    //* Copy item to DB.
    //*


    function MyMod_Handle_Copy_Do(&$item,&$msg)
    {
        $mtime=time();
        $item=
            array_merge
            (
                $item,
                $this->MyMod_Item_POST_Read(),
                $this->MyMod_Handle_Add_Fixed(),
                array
                (
                    "ATime" => $mtime,
                    "MTime" => $mtime,
                    "CTime" => $mtime,
                )
            );

        if ($this->MyMod_Item_Unique_Is($item))
        {
            foreach (array_keys($item) as $id => $data)
            {
                if
                    (
                        empty($this->ItemData[ $data ])
                        ||
                        $this->ItemData[ $data ][ "Derived" ]
                    )
                {
                    unset($item[ $data ]);
                }
            }


            if (isset($this->ItemData[ $this->CreatorField ]))
            {
                $item[ $this->CreatorField ]=$this->LoginData[ "ID" ];
            }

            $item=$this->SetItemTimes($item);
            if (!empty($item[ "ID" ])) { unset($item[ "ID" ]); }

            $res=$this->Sql_Insert_Item($item);

            $item=$this->MyMod_Item_Derived_Data_Read($item);
            $item=$this->MyMod_Item_PostProcess($item);
            $this->ApplicationObj->LogMessage("Item Copied");

            $this->ItemHash=$item;

            //var_dump($item);

            return TRUE;
        }
        else
        {
          
            $msg=
               $this->H
               (
                    4,
                    $this->ItemName.
                    " ".
                    $this->MyLanguage_GetMessage
                    (
                        array("not","Copied")
                    )
               );
                    
            $this->ItemHash=$item;
            return FALSE;
        }
    }
}

?>