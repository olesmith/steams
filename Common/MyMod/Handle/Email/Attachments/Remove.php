<?php

trait MyMod_Handle_Email_Attachments_Remove
{
   //*
    //* function MyMod_Handle_Email_Attachments_Remove, Parameter list: &$attachments
    //*
    //* Deletes attachments according to CGI
    //*

    function MyMod_Handle_Email_Attachments_Remove(&$attachments=array())
    {
        $rattachments=array();

        $deleted=FALSE;
        foreach (array_keys($attachments) as $n)
        {
            if ($this->GetPOSTint("Delete_".$n)==1)
            {
                $file=
                    sys_get_temp_dir().
                    "/".
                    $attachments[ $n ][ "Attachment" ];

                if (
                      file_exists($file)
                      &&
                      !empty($attachments[ $n ][ "Attachment" ])
                   ) { unlink($file); }
                $deleted=FALSE;
            }
            else
            {
                array_push($rattachments,$attachments[ $n ]);
            }
        }

        $attachments=$rattachments;

        return $deleted;
    }
}

?>