<?php

include_once("Types/Rows.php");
include_once("Types/Table.php");
include_once("Types/Html.php");
include_once("Types/Update.php");
include_once("Types/Form.php");

class Language_Messages_Types extends Language_Messages_Types_Form
{
    var $Types=array();
    
    function Language_Messages_Types_Get()
    {
        return
            array
            (
                $this->Language_Message_Type => array
                (
                    "Name" => "Messages",
                    "Method" => "Messages",
                    "PT" => "Mensagens",
                    "UK" => "Messages",
                    "ES" => "Mensajes",
                ),
                $this->Language_Array_Type => array
                (
                    "Name" => "Message, Arrays",
                    "PT" => "Listas",
                    "UK" => "Lists",
                    "ES" => "Listas",
                  ),
                $this->Language_Profile_Type => array
                (
                    "Name" => "Profiles",
                    "Method" => "Profiles",
                    "PT" => "Perfis",
                    "UK" => "Profiles",
                    "ES" => "Perfiles",
                ),
                $this->Language_LeftMenu_Type => array
                (
                    "Name" => "Left Menues",
                    "Method" => "LeftMenues",
                    "PT" => "Menus de Esquerda",
                    "UK" => "Left Menues",
                    "ES" => "Menús Izquierda",
                ),
                $this->Language_MenuItem_Type => array
                (
                    "Name" => "LeftMenues",
                    "PT" => "Itens de Menu",
                    "UK" => "Menu Items",
                    "ES" => "Itens de Menú",
                ),
                $this->Language_Module_Type => array
                (
                    "Name" => "Modules",
                    "Method" => "Modules",
                    "PT" => "Módulos",
                    "UK" => "Modules",
                    "ES" => "Módulos",
                ),
                $this->Language_Action_Type => array
                (
                    "Name" => "Actions",
                    "Method" => "Actions",
                    "PT" => "Ações",
                    "UK" => "Actions",
                    "ES" => "Aciónes",
                ),
                $this->Language_Data_Type => array
                (
                    "Name" => "Datas",
                    "Method" => "Datas",
                    "PT" => "Dados",
                    "UK" => "Datas",
                    "ES" => "Datos",
                ),
                $this->Language_Group_Type => array
                (
                    "Name" => "Groups",
                    "Method" => "Groups",
                    "PT" => "Grupos Plurais",
                    "UK" => "Plutal Groups",
                    "ES" => "Grupos Plurales",
                ),
                $this->Language_SGroup_Type => array
                (
                    "Name" => "SGroups",
                    "PT" => "Grupos Singulares",
                    "UK" => "Singular Groups",
                    "ES" => "Grupos Singulares",
                ),
                $this->Language_Help_Type => array
                (
                    "Name" => "Help",
                    "PT" => "Ajuda",
                    "UK" => "Help",
                    "ES" => "Ajuda",
                ),
                $this->Language_Mail_Type => array
                (
                    "Name" => "Email",
                    "PT" => "Textos de Email",
                    "UK" => "Email Texts",
                    "ES" => "Textos de Email",
                ),
            );
        
    }

    
    function Language_Messages_Type_Values_Read($language="")
    {
        if (empty($language)) { $language=$this->ApplicationObj()->Language; }

        if (empty($this->Types[$language ]))
        {
            $this->Types[$language ]=array();
            foreach ($this->Language_Messages_Types_Get() as $type => $hash)
            {
                $this->Types[$language ][ $type-1 ]=$hash[ $language ];
            }
        }

        return $this->Types[$language ];
    }
}
?>