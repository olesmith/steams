<?php

trait MyMod_Handle_Export_Form
{
    //*
    //* Fabricates the Export Form, possibly calling DoExport.
    //* $fields are the Export vars, if undef calls ReadExportCGI
    //* to get it.
    //*

    function MyMod_Handle_Export_Form()
    {  
        $this->MyMod_Handle_Export_Table_Data_Gather();

        if ($this->MyMod_Handle_Export_CGI_Type()=="HTML")
        {
            $this->ApplicationObj->MyApp_Interface_Head();
            $this->MyMod_HorMenu_Echo();

            $this->MyMod_Search_Post_Text=
                array
                (
                    $this->BR(),
                    $this->Htmls_Frame
                    (
                        array
                        (
                            $this->H
                            (
                                2,
                                $this->MyLanguage_GetMessage("Export_Form_Title").
                                " ".$this->MyMod_ItemsName(),
                                array("ID" => "_EXPORT")
                            ),
                            $this->Htmls_Table
                            (
                                array
                                (
                                    "",
                                    $this->MyLanguage_GetMessage("Export_Form_Include_Title"),
                                    $this->MyLanguage_GetMessage("Export_Form_Sort_Title"),
                                ),
                                array_merge
                                (
                                    $this->MyMod_Handle_Export_Datas_Table(),
                                    $this->MyMod_Handle_Export_Types_Table()
                                )
                            ),
                            $this->MakeHidden("Export",1),
                            $this->MakeHidden("Go",1),
                            $this->Buttons
                            (
                                $this->MyLanguage_GetMessage("Export_Form_Button_Title")
                            ),
                        ),
                        array("CLASS" => 'exportable')
                    ),
                    $this->BR(),
                );
            
            $action=$this->MyActions_Detect();
       
            echo
                $this->Htmls_Text
                (
                    array
                    (
                        $this->MyMod_Search_Form
                        (
                            array("DataGroups"),
                            "",
                            $action."#_EXPORT",
                            array(),
                            array(),
                            $this->ModuleName
                        ),
                        $this->BR(),
                    )
                );
         }


        if ($this->GetCGIVarValue("Go")==1)
        {
            $this->MyMod_Handle_Export_Do();
        }

        exit();

    }
}
?>