<?php


include_once("Item/Form.php");
include_once("Item/Update.php");
include_once("Item/Group.php");
include_once("Item/SGroup.php");
include_once("Item/SGroups.php");
include_once("Item/Html.php");
include_once("Item/Table.php");
include_once("Item/Row.php");
include_once("Item/PreKey.php");
include_once("Item/Cells.php");
include_once("Item/Read.php");
include_once("Item/Data.php");
include_once("Item/Test.php");
include_once("Item/Children.php");
include_once("Item/Language.php");
include_once("Item/PostProcess.php");
include_once("Item/Latex.php");
include_once("Item/Print.php");
include_once("Item/Unique.php");
include_once("Item/Rows.php");
include_once("Item/Trim.php");
include_once("Item/Empty.php");
include_once("Item/POST.php");

trait MyMod_Item
{
    use
        MyMod_Item_Form,
        MyMod_Item_Update,
        MyMod_Item_Group,
        MyMod_Item_SGroup,
        MyMod_Item_SGroups,
        MyMod_Item_Html,
        MyMod_Item_Table,
        MyMod_Item_Row,
        MyMod_Item_PreKey,
        MyMod_Item_Cells,
        MyMod_Item_Read,
        MyMod_Item_Data,
        MyMod_Item_Test,
        MyMod_Item_Children,
        MyMod_Item_Language,
        MyMod_Item_PostProcess,
        MyMod_Item_Latex,
        MyMod_Item_Print,
        MyMod_Item_Unique,
        MyMod_Item_Rows,
        MyMod_Item_Trim,
        MyMod_Item_Empty,
        MyMod_Item_POST;
        
    //*
    //* Creates row with item titles.
    //*

    function MyMod_Item_Titles($datas)
    {
        $row=array();
        foreach ($datas as $data)
        {
            if (!is_array($data)) { $data=array($data); }
            
            $cells=array();
            foreach ($data as $rdata)
            {
                array_push
                (
                   $cells,
                   $this->MyMod_Item_Cell_Title($rdata)
                );

                //Take only one title, the first
                break;
            }

            $row=
                array_merge
                (
                    $row,
                    $cells //join($this->BR(),$cells)
                );
        }

        return $row;
    }
    
    //*
    //* function Item_Existence_Message_Other_Module, Parameter list: $message,$where=array()
    //*
    //* 
    //*

    function Item_Existence_Message_Generate_Other_Module(&$othermodule)
    {
        $obj=$this;
        if (!empty($othermodule))
        {
            $tmp=$othermodule."Obj";
            
            $obj=$this->$tmp();
        }
        else
        {
            $othermodule=$this->ModuleName;
        }

        return $obj;
    }

    
    //*
    //* function Item_Existence_Message_Generate, Parameter list: $message,$where=array()
    //*
    //* Prints informing $message, if no item exists in sql table.
    //* Default $where=$this->UnitEventWhere().
    //*

    function Item_Existence_Message_Generate($othermodule="",$where=array())
    {
        if (!preg_match('/^(Coordinator|Admin)$/',$this->Profile())) return;
            
        if (empty($where)) $where=$this->UnitEventWhere();

        $obj=$this->Item_Existence_Message_Generate_Other_Module($othermodule);
        
        $message=$this->MyLanguage_GetMessage("No_Items_Defined_Message");

        $message=preg_replace('/#ItemName/',$obj->MyMod_ItemName(),$message);
        $message=preg_replace('/#ItemsName/',$obj->MyMod_ItemName("ItemsName"),$message);


        if (
              !$obj->Sql_Table_Exists()
              ||
              $obj->Sql_Select_NHashes($this->UnitEventWhere($where))==0
           )
        {
            return
                array
                (
                    $this->Htmls_DIV
                    (
                        $this->Htmls_DIV
                        (
                            array
                            (
                                $message.": ",
                                $this->Href
                                (
                                    "?".$this->CGI_Hash2URI
                                    (
                                        array
                                        (
                                            "Unit" => $this->Unit("ID"),
                                            "Event" => $this->Event("ID"),
                                            "ModuleName" => $othermodule,
                                            "Action" => "Add",
                                        )                         
                                    ),
                                    $this->MyLanguage_GetMessage("Add_Action_Name")." ".
                                    $obj->MyMod_ItemName(),
                            
                                    "","","",$noqueryargs=FALSE,$options=array(),"HorMenu"
                                ),
                            ),
                            array("CLASS" => 'message-body')
                        ),
                        array("CLASS" => 'warning message is-warning')
                    ),
                    $this->BR()
                );

            return "";
        }

        return "";
    }
    //*
    //* function Item_Existence_Message, Parameter list: $message,$where=array()
    //*
    //* Prints informing $message, if no item exists in sql table.
    //* Default $where=$this->UnitEventWhere().
    //*

    function Item_Existence_Message($othermodule="",$where=array())
    {
        echo
            $this->Htmls_Text
            (
                $this->Item_Existence_Message_Generate($othermodule,$where)
            );
        
        $obj=$this->Item_Existence_Message_Generate_Other_Module($othermodule);
        
        if (
              !$obj->Sql_Table_Exists()
              ||
              $obj->Sql_Select_NHashes($this->UnitEventWhere($where))==0
           )
        {
            return True;
        }

        return False;
     }
    
    //*
    //* Returns item name.
    //*

    function MyMod_Item_Name_Get($item=array(),$datas=array())
    {
        if (empty($datas)) { $datas=$this->ItemNamer; }
        if (!is_array($datas)) { $datas=array($datas); }
        
        if (!is_array($item) && preg_match('/^\d+$/',$item))
        {
            $item=$this->MyMod_Item_Read($item,$datas);
        }
        elseif (count($item)==0)
        {
            $item=$this->ItemHash;
        }

        
        $name="";        
        if (!empty($this->ItemNamer))
        {
            if (preg_match('/#/',$this->ItemNamer))
            {
                
                $name=$this->Filter($this->ItemNamer,$item);
            }
            else
            {
                if (count($item)>0)
                {
                    $namer=$this->ItemNamer;

                    if (method_exists($this,$namer))
                    {
                        $name=$this->$namer($item);
                    }
                    elseif (isset($item[ $namer ]))
                    {
                        $data=$this->ItemNamer;
                        if (!empty($item[ $data ]))
                        {
                            if ($this->MyMod_Data_Field_Is_Sql($data))
                            {
                                $obj=$this->MyMod_Data_Module_Object($data);                                
                                $name=
                                    $obj->Sql_Select_Hash_Value
                                    (
                                        $item[ $data ],
                                        $obj->ItemNamer
                                    );
                            }
                            else
                            {
                                $name=$item[ $this->ItemNamer ];
                            }
                        }
                        elseif (!empty($item[ "Name" ]))
                        {
                            $name=$item[ "Name" ];
                        }
                    }
                }
            }
        }

        return $name;
    }
    //*
    //* 
    //*

    function MyMod_Item_Anchor($item=array(),$anchor="",$text="")
    {
        if ($this->LatexMode) { return ""; }
        if (count($item)==0)
        {
            $item=$this->ItemHash;
        }

        if ($anchor=="" && isset($item[ "ID" ]))
        {
            $anchor=$this->ModuleName."_".$item[ "ID" ];
        }

        return $this->Span($text,array("ID" => $anchor));
    }

    //*
    //* 
    //*

    function MyMod_Item_User_Owner_Is($item,$user,$ownerkey="Friend",$idkey="ID")
    {
        $res=False;
        if (isset($item[ $ownerkey ]) && intval($item[ $ownerkey ])==intval($user[ $idkey ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Current_User_Owner_Is($item,$ownerkey="Friend",$idkey="ID")
    {
        return $this->MyMod_Item_User_Owner_Is($item,$this->LoginData(),$ownerkey,$idkey);
    }
    
    //*
    //* function MyMod_ItemName, Parameter list: $key="ItemName"
    //*
    //* Returns item name, according to active language.
    //*

    function MyMod_ItemName($append="",$msg_key="Name",$lang="")
    {
        return
            $this->LanguagesObj()->Language_Module_ItemName($this,"ItemName",$lang,$msg_key).
            $append;
    }

    //*
    //* function MyMod_ItemsName, Parameter list: $key="ItemsName"
    //*
    //* Returns items name, according to active language.
    //*

    function MyMod_ItemsName($append="",$msg_key="Name",$lang="")
    {
        return
            $this->LanguagesObj()->Language_Module_ItemsName($this,"ItemsName",$lang,$msg_key).
            $append;
    }
    
    //*
    //* Returns items name, according to active language.
    //*

    function MyMod_ItemHash($key="ItemsName",$msg_key="Name",$lang="")
    {
        return
            $this->LanguagesObj()->Language_Module_ItemHash($this,$key,$lang,$msg_key);            
    }
}

?>