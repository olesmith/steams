<?php



trait MyMod_Data_Groups_Time
{
    //use MyMod_Data_Defaults,MyMod_Data_Groups;

    //*
    //* function MyMod_Groups_Time_AddGroups, Parameter list:
    //*
    //* Returns default time groups.
    //*

    function MyMod_Groups_Time_AddGroups()
    {
        $this->ItemDataGroups=
            array_merge
            (
                $this->ItemDataGroups,
                $this->ReadPHPArray
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Common/System/Groups.Time.php"
                )
            );
        
        $this->ItemDataSGroups=
            array_merge
            (
                $this->ItemDataSGroups,
                $this->ReadPHPArray
                (
                    $this->ApplicationObj()->MyApp_Setup_Root().
                    "/Common/System/SGroups.Time.php"
                )
            );
     }

}

?>