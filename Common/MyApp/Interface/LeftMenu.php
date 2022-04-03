<?php


include_once("LeftMenu/Dynamic.php");
include_once("LeftMenu/Generate.php");
include_once("LeftMenu/Language.php");
include_once("LeftMenu/Top.php");
include_once("LeftMenu/Profile.php");
include_once("LeftMenu/Handle.php");

trait MyApp_Interface_LeftMenu
{
    use
        MyApp_Interface_LeftMenu_Dynamic,
        MyApp_Interface_LeftMenu_Generate,
        MyApp_Interface_LeftMenu_Language,
        MyApp_Interface_LeftMenu_Top,
        MyApp_Interface_LeftMenu_Profile,
        MyApp_Interface_LeftMenu_Handle;

    
    //*
    //* Creates the left menu (modules/system navigation)
    //*

    function MyApp_Interface_LeftMenu()
    {
        if ($this->MyApp_Interface_Mobile_Is())
        {
            return array();
        }
        
        return
            array
            (
                $this->Htmls_Comment_Section
                (
                    "Left Menu Start",
                    $this->Htmls_Tag
                    (
                        "ASIDE",
                        array
                        (
                            $this->MyApp_Interface_LeftMenu_Top_Welcome(),
                            $this->MyApp_Interface_LeftMenu_Top_Period(),
                            $this->MyApp_Interface_LeftMenu_Top_UserInfo(),
                            $this->MyApp_Interface_LeftMenu_Top_ReadOnlyMessage(),
                            $this->MyApp_Interface_LeftMenu_Top_AdminInfo(),
                            $this->MyApp_Interface_LeftMenu_Generate()
                        ) ,
                        array
                        (
                            "CLASS" => "menu",
                        )                  
                    )
                ),
            );
    }

    //*
    //* Returns name of file with Left Menu. 
    //*

    function MyApp_Setup_LeftMenu_DataFiles()
    {
        return
            $this->MyFile_Paths_Existent
            (
                $this->MyApp_Setup_Path(),
                $this->LeftMenuFile
            );
    }


    //*
    //* Reads the menus pertaining to profile $this->Profile.
    //* If $this->Profile is empty, return Public menus.
    //*

    function MyApp_Interface_LeftMenu_Read()
    {
        return 
            $this->MyApp_Setup_Files2Hash
            (
                $this->MyApp_Setup_Path(),
                $this->LeftMenuFile
            );
    }


    //*
    //* Returns submenu bullet.
    //*

    function MyApp_Interface_LeftMenu_Bullet($bullet)
    {
        $icon="fas fa-plus fa-xs";
        if ($bullet=="-")
        {
            $icon="fas fa-minus fa-xs";
        }
        
        return $this->MyMod_Interface_Icon($icon,array(),1);
    }
    


}

?>