<?php

trait MyMod_Handle_Add_Html
{
    //* 
    //* 
    //*

    function MyMod_Handle_Add_Html($title)
    {
        $this->Singular=TRUE;
        $datas=$this->MyMod_Handle_Add_Datas();
        $this->MyMod_Data_Add_Default_Init();

        foreach (array_keys($this->ItemData) as $data)
        {
            $rdata=$data;
            if (!empty($this->ItemData[ $data ][ "GETSearchVarName" ]))
            {
                $rdata=$this->ItemData[ $data ][ "GETSearchVarName" ];
            }
            
            $get=$this->CGI_GET($rdata);
            if (!empty($get))
            {
                $this->AddDefaults[ $data ]=$get;
            }
        }

        $this->AddDefaults=$this->PostProcess($this->AddDefaults);

        if (empty($title)) { $title=$this->MyActions_Entry_Title("Add"); }

        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->MyActions_Entry_Title()
                ),
                $this->MyMod_Handle_Add_Form_Text_Pre(),
                $this->MyMod_Handle_Add_Form_Uploads_Message(),
                $this->MyMod_Handle_Message,
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Handle_Add_Table
                    (
                        $datas,"Add",$title
                    )
                ),
                $this->MyMod_Handle_Add_Form_Text_Post(),
            );
    }
}

?>