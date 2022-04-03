<?php

trait MyMod_Handle_Add_Form
{
    //*
    //* Creates form for adding an item. If $_POST[ "Update" ]==1,
    //* calls Add.
    //* $addedtitle deprecated due to redirect.
    //*

    function MyMod_Handle_Add_Form($title,$addedtitle,$echo=TRUE,$redirect=TRUE)
    {
        $this->Singular=TRUE;
        $rdatas=$this->MyMod_Data_Allowed_Get(0);
        
        $datas=$this->MyMod_Handle_Add_Datas();
        $this->MyMod_Data_Add_Default_Init();
        
        $this->AddDefaults=$this->PostProcess($this->AddDefaults);
            
        $action=$this->MyActions_Detect();
        if ($this->CGI_POSTint("Add")==1)
        {
            //If sucees, we shouldn't come back
            $res=$this->MyMod_Handle_Add_Update($redirect);
        }


        $this->ApplicationObj->MyApp_Interface_Head();
        
        $html=
            $this->Htmls_Form
            (
                1,
                "Add_Form",
                $action,

                $this->MyMod_Handle_Add_Html($title),
                $args=array
                (
                    "Hiddens" => array
                    (
                        "Add" => 1,
                    ),
                    "Anchor" => "HorMenu",
                    "Buttons" => $this->Buttons
                    (
                        $this->MyLanguage_GetMessage("Add_Button_Title").
                        " ".
                        $this->MyMod_ItemName()
                    ),
                ),
                $options=array
                (
                    "ID" => "Add_Form",
                    "Anchor" => "HorMenu",
                )
                
            );

        if ($echo)
        {
            $this->MyMod_HorMenu_Echo(TRUE);
            $this->Htmls_Echo($html);
            
            return "";
        }
        else
        {
            return $html;
        }
    }
    
    //*
    //* Pretext function. Returns empty string, supposed to be overridden.
    //*

    function MyMod_Handle_Add_Form_Uploads_Message()
    {
        $text=array();
        if (count($this->MyMod_Data_Field_Files_Get())>0)
        {
            $text=
                $this->Htmls_DIVS_Message
                (
                    $this->MyLanguage_GetMessage("File_Add_Message"),
                    'center'
                );
        }

        return $text;
    }
    //*
    //* Pretext function. Returns empty string, supposed to be overridden.
    //*

    function MyMod_Handle_Add_Form_Text_Pre()
    {
        return "";
    }

    //*
    //* Posttext function. Returns empty string, supposed to be overridden.
    //*

    function MyMod_Handle_Add_Form_Text_Post()
    {
        return "";
    }
}

?>