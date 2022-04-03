<?php

trait MyMod_Handle_Info_Menu_Entries
{
    //*
    //* Generates menu entries
    //*

    function MyMod_Handle_Info_Menu_Entries($hash)
    {
        $entries=array();
        foreach ($hash as $type => $name) 
        {
            $entries[ $type ]=
                $this->MyMod_Handle_Info_Menu_Entry
                (
                    $hash,$type,$name
                );
        }
        
        return $entries;
    }
    
    /* //\* */
    /* //\* Generates menu entries */
    /* //\* */

    /* function MyMod_Handle_Info_Menu_Entries_old($hash,$args) */
    /* { */
    /*     $hrefs=array(); */
    /*     foreach ($hash as $type => $name)  */
    /*     { */
    /*         array_push */
    /*         ( */
    /*             $hrefs, */
    /*             $this->MyMod_Handle_Info_Menu_Entry($hash,$args,$type,$name), */
    /*             "|" */
    /*         ); */
    /*     } */

    /*     array_pop($hrefs); */

    /*     return */
    /*         $this->Htmls_Center */
    /*         ( */
    /*             array */
    /*             ( */
    /*                 "[ ", */
    /*                 $hrefs, */
    /*                 " ]", */
    /*             ), */
    /*             array("ID" => "TypesMenu") */
    /*         ); */
    /* } */
    
}

?>