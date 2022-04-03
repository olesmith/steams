<?php


class Permissions_Units extends Permissions_Access
{
    /* //\* */
    /* //\* Checks if $user has access a Permission entry to $unit. */
    /* //\* Empty user means current user. */
    /* //\* */

    /* function Permission_Unit_User_May_Edit($unit,$user=array(),$key="ID") */
    /* { */
    /*     $permissions=$this->Permissions_Friend_Get($user); */
    /*     foreach ($permissions as $permission) */
    /*     { */
    /*         if */
    /*             ( */
    /*                 $permission[ "Type" ]==$this->Permissions_Units_Edit_Type */
    /*             ) */
    /*         { */
    /*             $unit_id=$this->Unit("ID"); */
    /*             if (!empty($unit[ $key ])) */
    /*             { */
    /*                 $unit_id=$unit[ $key ]; */
                    
    /*             } */

    /*             if ($permission[ "Unit" ]==$unit_id) */
    /*             { */
    /*                 return True; */
    /*             } */
    /*         } */
    /*     } */

    /*     return False; */
    /* } */
    
    /* //\* */
    /* //\* Checks if $user has access a Permission entry to $item with $unit. */
    /* //\* Empty user means current user. */
    /* //\* */

    /* function Permission_Item_Unit_User_May_Edit($item,$user=array(),$key="Unit") */
    /* { */
    /*     return */
    /*         $this->Permission_Unit_User_May_Edit */
    /*         ( */
    /*             $item,$user,$key="Unit" */
    /*         ); */
    /* } */
}

?>