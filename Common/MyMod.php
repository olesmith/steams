<?php

include_once("CSS.php");
include_once("JS.php");
include_once("MyFile.php");
include_once("MakeLatex.php");
include_once("MyDir.php");
include_once("MySort.php");
include_once("MyList.php");
include_once("MyHash.php");
include_once("Common/Accessor.php");
include_once("MyActions.php");
include_once("Sql.php");
include_once("MyDB.php");
include_once("CallStack.php");

include_once("MyMod/Handle.php");
include_once("MyMod/HorMenu.php");
include_once("MyMod/Module.php");
include_once("MyMod/Modules.php");
include_once("MyMod/SubModules.php");
include_once("MyMod/Actions.php");
include_once("MyMod/Data.php");
include_once("MyMod/Datas.php");
include_once("MyMod/Group.php");
include_once("MyMod/Item.php");
include_once("MyMod/Items.php");
include_once("MyMod/Search.php");
include_once("MyMod/Paging.php");
include_once("MyMod/Access.php");
include_once("MyMod/Profiles.php");
include_once("MyMod/Setup.php");
include_once("MyMod/Sort.php");
include_once("MyMod/Globals.php");
include_once("MyMod/Latex.php");
include_once("MyMod/Language.php");
include_once("MyMod/Mail.php");
include_once("MyMod/Messages.php");
include_once("MyMod/Icons.php");
include_once("MyMod/JS.php");
include_once("MyMod/CSS.php");
include_once("MyMod/Unique.php");
include_once("MyMod/Sql.php");
include_once("MyMod/API.php");

trait MyMod
{    
    use 
        _accessor_, //see #SystemRoot#/index.php
        CSS,
        JS,
        MyFile,
        MySort,
        MakeLatex,
        MyDir,
        MyList,
        MyHash,
        Accessor,
        MyActions,
        Sql,
        MyDB,
        CallStack;

    use
        MyMod_Handle,MyMod_HorMenu,
        MyMod_Modules,MyMod_Module,MyMod_SubModules,
        MyMod_Actions,
        
        MyMod_Data,MyMod_Datas,
        
        MyMod_Group,MyMod_Item,
        MyMod_Access,MyMod_Mail,
        MyMod_Items,MyMod_Search,MyMod_Paging,
        MyMod_Latex,MyMod_Language,
        MyMod_Profiles,MyMod_Setup,MyMod_Sort,MyMod_Globals,
        MyMod_Messages,MyMod_Icons,MyMod_JS,
        MyMod_CSS,MyMod_Unique,MyMod_Sql,
        MyMod_API;

    var $Application="";
    
    //From Mysql2/Items.php
    var $ItemHashes=array();
    var $ActionButtons=FALSE;
    var $ActionButtonActions=array();

    var $ItemActions=array();
    var $ItemsActions=array();
    var $SumVars=array();
    var $ConditionalShow="";
    var $IncludeAll=0;
    var $IncludeAllDefault=TRUE;
    var $NoPaging=FALSE;
    var $NoSearches=FALSE;
    var $ShowAll=FALSE;
    var $AddCheckBox2ItemTable=FALSE;
    var $UniquenessData=array();
    var $LastWhereClause=NULL;

    var $ExtraData=array();
    var $ItemDataGroupsCommon=array();
    var $ItemDataGroupNames=array();

    var $ItemDataSGroupsCommon=array();
    var $ItemDataSGroupNames=array();

    var $MyMod_Add_Reload_Action="Edit";

    var $MyMod_Unicity_Fields=array();
    var $MyMod_Group_Default="Basic";
    var $MyMod_SGroup_Default="Basic";
    
    
    function MyMod_RAW_Is()
    {
        return $this->ApplicationObj()->MyApp_Interface_RAW_Is();
    }
    
    function MyMod_CGI_RAW($args,$dest_cell="")
    {
        $args[ "RAW" ]=1;
        if (!empty($dest_cell))
        {
            $args[ "Dest" ]=$dest_cell;
        }
        
        return $args;
    }

    
    
    function MyMod_Defaults()
    {
        return
            array
            (
                "IsMain" => FALSE,
                "UploadPath" => "Uploads4/#Module",

                "Mail" => FALSE,
                "Logging" => FALSE,

                "MessageFiles" => array
                (
                ),

                "DefaultAction" => "Search",
                "SubModules" => array(),
                //"SqlVars" => array(),
                "System" => "System",//remove??

                "ActionPaths" => array
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Common/System",
            
                    #$this->ApplicationObj()->MyApp_Setup_Path()
                ),
                "ActionFiles" => array("Actions.php"),
        
                "Actions" => array(), 

                "ItemDataPaths" => array
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Application/System",
            
                    $this->ApplicationObj()->MyApp_Setup_Path().
                    "/#Module",
                ),
        
                "ItemDataFiles" => array("Data.php"),

                "ItemData" => array(),  
                "ItemDerivers" => array(),  
                "ItemDerivedData" => array(),

                "ItemDataGroupPaths" => array
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Application/System",
            
                    $this->ApplicationObj()->MyApp_Setup_Path(),
                ),
                "ItemDataGroupFiles" => array("Groups.php"),
                "ItemDataSGroupFiles" => array("SGroups.php"),

                "ItemDataGroups" => array(),
                "ItemDataSGroups" => array(),
                "DataGroupsRead" => FALSE,
                "CurrentDataGroup" => "",
        
                "LatexPaths" => array
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Latex",
                    $this->ApplicationObj()->MyApp_Setup_Path(),
                ),
                "LatexFiles" => array("#System/#Module/Latex.Data.php"),
            );
    }

    //*
    //* Module initializer.
    //*

    function MyMod_Init($args=array())
    {
        $this->IsMain=FALSE;

        $this->MyHash_Args2Object
        (
            $this->MyMod_Defaults(),
            TRUE
        );

        $this->MyHash_Args2Object($args);

        foreach (array("ItemName","ItemsName","ItemNamer") as $attr)
        {
            foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
            {
                $rattr=$attr.$lkey;
            }
        }
    }

 
    //*
    //* function MyMod_Doc_Header_Send, Parameter list: 
    //*
    //* Sends the doc header.
    //*

    function MyMod_Doc_Header_Send($contenttype,$filename="",$charset="",$expiresin=0,$filemtime=0)
    {
        $contenttypes=
            array
            (
                "txt"  => "text/plain",
                "html" => "text/html",
                "tex"  =>  "application/x-tex",
                "sql"  => "text/plain",
                "csv"  => "application/vnd.ms-excel",
                "tex"  => "application/x-latex",
                "pdf"  => "application/pdf",
                "odt"  => "application/vnd.oasis.opendocument.text",
                "ods"  => "application/vnd.oasis.opendocument.spreadsheet",
                "doc"  => "application/vnd.msword",
                "xls"  => "application/vnd.ms-excel",
                "zip"  => "application/zip",
                "jpg"  => "image/jpeg",
                "png"  => "image/png",
                "svg"  => "image/svg+xml",
                "json" => "application/json",
            );

        if (!empty($contenttypes[ $contenttype ]))
        {
            $contenttype=$contenttypes[ $contenttype ];
        }

        if ($contenttype=="") { $contenttype="text/plain"; }

        if ($charset=="" && isset($this->HtmlSetupHash[ "CharSet"  ]))
        {
            $charset=$this->HtmlSetupHash[ "CharSet"  ];
        }
        else { $charset="utf=8"; }

        header('Content-type: '.$contenttype.'; charset='.$charset);

        if (!empty($filename))
        {
            header
            (
                'Content-Disposition: attachment;'.
                'filename="'.$filename.'"; charset='.$charset
            );             
        }
      
        if (!empty($expiresin))
        {
            $expires=gmdate('D, d M Y H:i:s \G\M\T', time() + $expiresin);
          
            header('Cache-Control: public, max-age='.$expires);
            header('Expires: '.$expires);
            header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T',$filemtime));
        }

    }
    
    //*
    //* function MyMod_EvenOdd_Class, Parameter list: $even
    //*
    //* Returns names of even, resp odd class (table rows/cells).
    //*

    function MyMod_EvenOdd_Class($even)
    {
        $class='odd';
        if ($even) { $class='even'; }

        return $class;
    }
    
    //*
    //*
    //*

    function MyMod_Permissions_Hash_Take(&$perms,$hash)
    {
        foreach (array($this->LoginType(),$this->Profile()) as $key)
        {
            if (empty($perms[ $key ])) { $perms[ $key ]=0; }
            
            $value=0;
            if (!empty($hash[ $key ])) { $value=$hash[ $key ]; }
            
            $perms[ $key ]=
                $this->Max
                (
                    $perms[ $key ],
                    $value
                );
        }
    }
    
    //*
    //* Call ApplicationObj method of same name.
    //*

    function UsersObj()
    {
        $usersobj=$this->ApplicationObj()->AuthHash[ "Object" ];
        if (empty($this->ApplicationObj()->$usersobj))
        {
            $objacessor=preg_replace('/Object$/',"Obj",$usersobj);
            
            return $this->ApplicationObj()->$objacessor();
        }

        return $this->ApplicationObj()->$usersobj;
        var_dump($this->ModuleName);
        return
            $this->ApplicationObj()->UsersObj();
    }
}

?>