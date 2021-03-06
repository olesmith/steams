<?php


trait MyApp_Interface_LeftMenu_Top
{
    //*
    //* function MyApp_Interface_LeftMenu_Top_Welcome, Parameter list:
    //*
    //* Retrusn welcome message.
    //*

    function MyApp_Interface_LeftMenu_Top_Welcome()
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyLanguage_GetMessage("LMWelcomeMessage").": ",
                        preg_replace
                        (
                            '/\s*:\s*/',
                            $this->BR(),
                            $this->MyApp_Title().
                            " ".
                            $this->MyApp_Version().
                            "."
                        ),
                    ),
                    array("CLASS" => "welcomemessage")
                )
            );
    }

    //*
    //* function MyApp_Interface_LeftMenu_Top_UserInfo, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_UserInfo()
    {
        if (is_array($this->LoginData) && $this->LoginData[ "Name" ]!="")
        {
           return
                $this->Htmls_Table
                (
                    "",
                    array
                    (
                        array
                        (
                            $this->B
                            (
                                $this->MyLanguage_GetMessage
                                (
                                    "LM_Login_Title",
                                    $subkey="Name",$langkey="",$add=":"
                                ).":"
                            ),
                            array
                            (
                                $this->FriendsObj()->MyMod_Data_Field
                                (
                                    0,
                                    $this->LoginData,
                                    "Email"
                                ),
                                " (".
                                $this->LoginData[ "ID" ].
                                ")"
                            ),
                        ),
                        array
                        (
                            $this->B
                            (
                                $this->MyLanguage_GetMessage
                                (
                                    "LM_Alias"
                                ).
                                ": "
                            ),
                            $this->LoginData[ "Name" ],
                        ),
                        array
                        (
                            $this->B
                            (
                                $this->MyLanguage_GetMessage
                                (
                                    "LM_Profile"
                                ).
                                ": "
                            ),
                            $this->LanguagesObj()->Message_Debug_Pre
                            (
                                $this->LanguagesObj()->Language_Profile_Type,
                                $this->Profile()
                            ),
                            $this->MyApp_Profile_Name
                            (
                                $this->Profile(),
                                $plural=False
                            ),
                        ),
                    ),
                    array("CLASS" => 'userinfotable')
                );

        }
        else
        {
            return
                $this->Htmls_DIV
                (
                    $this->MyLanguage_GetMessage("LMAnonymousAccessMessage"),
                    array("CLASS" => 'anonymous')
                );
        }
    }

    //*
    //* function MyApp_Interface_LeftMenu_Top_ReadOnlyMessage, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_ReadOnlyMessage()
    {
        $html=array();
        if (is_array($this->LoginData) && $this->LoginData[ "Name" ]!="")
        {
            if ($this->ReadOnly && $this->LoginType!="Public")
            {
                array_push
                (
                    $html,
                    $this->H
                    (
                        5,
                        $this->MyLanguage_GetMessage("LM_Read_Only_Notice")
                    )
                );
            }
            else
            {
                array_push
                (
                    $html,
                    $this->BR()
                );
            }
        }

        return $html;
    }


    //*
    //* function MyApp_Interface_LeftMenu_Top_AdminInfo, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_AdminInfo()
    {
        $html=array();
        if ($this->Profile()=="Admin")
        {
            array_push
            (
                $html,
                $this->DIV
                (
                    $this->MyLanguage_GetMessage("LM_Admin_Notice"),
                    array("CLASS" => 'adminnotice tag is-danger is-flex')
                ),
                $this->BR()
            );
        }

        return $html;
    }
    //*
    //* function MyApp_Interface_LeftMenu_Period, Parameter list:
    //*
    //* Creates period message. Should be moved to overriden function in sids apps.
    //*

    function MyApp_Interface_LeftMenu_Top_Period()
    {
        //Should be included in overriding header, somewhere in SiDS.
        $html=array();
        if (!empty($this->Period))
        {
            $title=$this->Period[ "Name" ];
            if (!empty($this->Period[ "Title" ])) { $title=$this->Period[ "Title" ]; }
            
            $per="";
            if (is_array($this->Period))
            {
                $per=$title;
            }
            else
            {
                $per=$this->Period;
            }

            $per=
                $this->MyLanguage_GetMessage("LM_Period_Title").
                " ".
                $per;
            
            array_push
            (
                $html,
                $this->DIV
                (
                    $per,
                    array
                    (
                        "CLASS" => "periodtitle",
                    )
                )
            );
        }

        return $html;
    }
}

?>