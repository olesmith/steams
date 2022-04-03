<?php

trait MyMod_Handle_Info_Rows_Profiles
{
    //*
    //* 
    //*

    function MyMod_Handle_Info_Profiles_FHash_Take($key,$fhash,&$message)
    {
        if (empty($message[ "ID" ])) { return; }
        
        $updatedatas=array();
        foreach ($this->MyMod_Handle_Info_Profile_Datas() as $profile)
        {
            if
                (
                    !empty($fhash[ $key ][ $profile ])
                    &&
                    (
                        empty($message[ $profile ])
                        ||
                        $message[ $profile ]!=$fhash[ $key ][ $profile ]
                    )
                )
            {
                $message[ $profile ]=$fhash[ $key ][ $profile ];
                array_push($updatedatas,$profile);
            }
        }

        
        if (count($updatedatas)>0)
        {
            $this->LanguagesObj()->Sql_Update_Item_Values_Set($updatedatas,$message);
        }
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Info_Row_Profiles($edit,$n,$key,$fhash,&$message)
    {
        $this->MyMod_Handle_Info_Profiles_FHash_Take($key,$fhash,$message);
        
        $tabindex=1;
        $row=array();
        foreach ($this->MyMod_Handle_Info_Profile_Datas() as $profile)
        {
            array_push
            (
                $row,
                $this->MyMod_Data_Info_Row_Profile_Field
                (
                    $edit,
                    $key,
                    $message,
                    $profile,
                    $tabindex++,
                    $fhash
                )
            );
        }

        return $row;
    }

    //*
    //* Creates $profile field.
    //*

    function MyMod_Data_Info_Row_Profile_Field($edit,$data,$message,$profile,$tabindex,$fhash)
    {
        $field=
            array
            (
                $this->LanguagesObj()->MyMod_Data_Field
                (
                    $edit,
                    $message,
                    $profile,
                    $plural=True,
                    $tabindex
                ),
                /* $this->MyMod_Data_Info_Row_Profile_Field_Info */
                /* ( */
                /*     $edit, */
                /*     $data, */
                /*     $message, */
                /*     $profile, */
                /*     $fhash */
                /* ) */
            );

        return $field;
    }
    
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Info_Row_Profile_Field_Info($edit,$data,$message,$profile,$fhash)
    {
        if (empty($fhash[ $data ]))
        {
            return
                $this->Htmls_Span
                (
                    $this->BR().
                    "No ItemData: '".$data."'",
                    array("CLASS" => 'error')
                );
        }
        
        if (empty($fhash[ $data ][ $profile ]))
        {
            return 
                $this->Htmls_Span
                (
                    "-",
                    array("CLASS" => 'success')
                );
        }

        if
            (
                empty($fhash[ $data ][ $profile ])
                ||
                $fhash[ $data ][ $profile ]!=$message[ $profile ]
            )
        {
            return
                $this->Htmls_Span
                (
                    "!=!",
                    array("CLASS" => 'warning')
                );
        }

        return
            $this->Htmls_Span
            (
                "=",
                array("CLASS" => 'success')
            );
    }
}

?>