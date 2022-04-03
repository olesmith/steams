<?php

class Language_Messages_Group extends Language_Messages_Datas
{
    var $Language_Message_Group_Fields=array();
    
    //*
    //*
    //* 

    function Language_Message_Group_Field($data,$item,$edit,$rdata)
    {
        //DataType has group element

        $subtype=0;
        $module="";
        $title="";
        if ($item[ "Message_Type" ]==$this->Language_Data_Type)
        {
            $subtype=$this->Language_Group_Type;
            $module=$item[ "Module" ];
            $title="Data Group";
        }
        elseif ($item[ "Message_Type" ]==$this->Language_MenuItem_Type)
        {
            $subtype=$this->Language_LeftMenu_Type;
            $title="Left Menu";
        }

        if ($subtype>0)
        {
            return
                $this->Language_Message_Group_Type_Field
                (
                    $subtype,$module,$title,
                    $data,$item,$edit,$rdata
                );
        }

        return array("----");
    }
    
    //*
    //*
    //* 

    function Language_Message_Group_Type_Field($subtype,$module,$title,$data,$item,$edit,$rdata)
    {
        $where=
            array
            (
                "Message_Type" => $subtype,
            );

        if (!empty($module)) { $where[ "Module" ]=$module; }
        
        if (empty($this->Language_Message_Group_Fields[ $subtype ]))
        {
            $this->Language_Message_Group_Fields[ $subtype ]=array();
        }
            
        if (empty($this->Language_Message_Group_Fields[ $subtype ][ $module ]))
        {
            $this->Language_Message_Group_Fields[ $subtype ][ $module ]=
                $this->Sql_Select_Hashes
                (
                    $where,
                    array("ID","Message_Type","Message_Key","Module"),
                    "Message_Key"
                );
        }

        return
            $this->Htmls_DIV
            (
                $this->Htmls_Select_Hashes_Field
                (
                    $rdata,
                    $this->Language_Message_Group_Fields[ $subtype ][ $module ],
                    $args=array
                    (
                        "Selected" => $item[ "Message_Group" ],
                        "Name_Key" => "Message_Key",
                        "Title_Key" => "#Module: #Message_Type",
                    ),
                    $selectoptions=
                    array
                    (
                        "TITLE" => $title,
                    ),
                    $optionsoptions=array()
                ),
                array("CLASS" => 'searchdata select')
            );
    }
}
?>