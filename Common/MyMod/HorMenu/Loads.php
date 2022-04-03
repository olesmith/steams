<?php

trait MyMod_HorMenu_Loads
{
    //*
    //* Creates dynamic menu with links to Groups
    //*

    function MyMod_HorMenu_Loads($id,$item)
    {
        $current_action=$this->MyActions_Detect();

        $html=array();
        if ($this->MyMod_HorMenu_Dynamic_ByLoad)
        {
            $dest_id=
                $this->MyMod_HorMenu_Destination_ID
                (
                    $current_action
                );
                
        $html=
            $this->JS_Load_URL_2_Element
            (
                $this->MyMod_HorMenu_Entry_URL
                (
                    $current_action,$item,$dest_id
                ),
                $dest_id,
                "HorMenu"
            );

        /* var_dump($dest_id,$js); */
        /*     $html=array(); */
        /*         array */
        /*         ( */
        /*             $this->JS_Click_Element_By_ID */
        /*             ( */
        /*                 $this->MyMod_HorMenu_Entry_ID */
        /*                 ( */
        /*                     $current_action, */
        /*                     $id,$item */
        /*                 ). */
        /*                 "_Show" */
        /*             ), */
        /*         ); */
        }
            
        return $html;
    }

}

?>