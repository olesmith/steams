<?php

include_once("Rows/Profiles.php");
include_once("Rows/Messages.php");
include_once("Rows/File.php");

trait MyMod_Handle_Info_Rows
{
    use
        MyMod_Handle_Info_Rows_Profiles,
        MyMod_Handle_Info_Rows_Messages,
        MyMod_Handle_Info_Rows_File;
    
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Rows($edit,$groupno,$n,$key,$fhash,$type)
    {
        if (!empty($fhash[ $key ][ "No_DB_Messages" ]))
        {
            return array($key);
        }
        
        $message=
            $this->MyMod_Handle_Info_Message_Read($edit,$key,$type);
        
        if (empty($message))
        {
            $file="";
            if (!empty($fhash[ "File" ])) { $file=$fhash[ "File" ]; }
            
            $this->LanguagesObj()->Language_Module_Item_Update_Rows
            (
                $this->ModuleName,
                $file,
                $key,
                $fhash,
                $type,
                $force=True,$updateperms=True
            );
            
            $message=
                $this->MyMod_Handle_Info_Message_Read($edit,$key,$type);

        }
        else
        {
            $this->Languagesobj()->Language_Message_DB_Take
            (
                $fhash[ $key ],
                $message
            );
        }
        
        $row=
            $this->MyMod_Handle_Info_Row
            (
                $edit,
                $n,
                $key,
                $fhash,
                $type,
                $message
            );

        return
            array_merge
            (
                array($row),
                $this->Htmls_Table_Row_With_Options
                (
                    array
                    (
                        "",
                        $this->MyMod_Handle_Info_Rows_Message_Table
                        (
                            $edit,$groupno,$key,
                            $message
                        ),
                    ),
                    $this->MyMod_Handle_Info_Rows_Message_Options
                    (
                        $edit,$groupno,$key,
                        $message
                    )
                )
            );
    }
    
    //*
    //* Messages table options.
    //*

    function MyMod_Handle_Info_Rows_Message_Options($edit,$groupno,$key,$message)
    {
        $display="none";
        if
            (
                $this->MyMod_Handle_Info_CGI_Language_Display_Should
                (
                    $groupno,$message
                )
            )
        {
            $display="table-row";            
        }
        
        return
            array
            (
                "CLASS" => "Language_".$groupno,
                "STYLE" => "display: ".$display.";",
            );
    }
}

?>