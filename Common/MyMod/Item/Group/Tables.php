<?php


trait MyMod_Item_Group_Tables
{
    //*
    //* Create item Group tables. Returns row list.
    //*

    function MyMod_Item_Group_Tables($redit,$groupdefs,$item,$buttons="",$plural=FALSE,$prekey="")
    {
        $tables=array();
        foreach ($groupdefs as $groupdef)
        {
            $row=array();
            foreach ($groupdef as $group => $gedit)
            {
                $gredit=$this->Min($gedit,$redit);

                $res=False;
                if (!empty($this->ItemDataSGroups[ $group ]))
                {
                    $res=$this->MyMod_Group_Allowed
                    (
                        $this->ItemDataSGroups[ $group ],
                        $item
                    );
                }                
                else
                {
                    $msg="Warning! Invalid SGroup: ".$group." - ignored";
                    array_push($row,$msg);
                }

                if ($res)
                {
                   array_push
                    (
                       $row,
                       $this->Htmls_Comment_Section
                       (
                           "Item Group Table: ".$group,
                           $this->MyMod_Item_Group_Table_HTML
                           (
                               $gredit,
                               $group,
                               $item,
                               $plural,
                               $prekey,
                               array
                               (
                                   "WIDTH" => '100%'
                               )
                           )
                       )
                    );
                }
            }

            if (!empty($row))
            {
                array_push($tables,$row);
            }
        }
        
        if ($redit==1 && !empty($buttons))
        {
            array_push($tables,$buttons);
        }


        return $tables;
    }
}

?>