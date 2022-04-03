<?php


trait MyMod_Item_Group_CGI
{
    //*
    //* Updates $item for data in $groups. Returns datas altered.
    //*

    function MyMod_Item_Groups_CGI2Item($groups,&$item,$plural=FALSE)
    {
        $updatedata=array();
        foreach ($groups as $group)
        {
            $updatedata=array_merge
            (
                $updatedata,
                $this->MyMod_Item_Group_CGI2Item($group,$item,$plural)
            );
        }

        return $updatedata;
    }

    
    //*
    //* Updates $item for data in $group. Returns datas altered.
    //*

    function MyMod_Item_Group_CGI2Item($group,&$item,$plural=FALSE,$precgikey="")
    {
        $datas=$this->MyMod_Item_Group_Data($group,TRUE);
        $updatedata=$this->MyMod_Item_Datas_CGI2Item($datas,$item,$plural,$precgikey);

        return $updatedata;
    }

    //*
    //* Updates $item for data in $group. Returns datas altered.
    //*

    function MyMod_Item_Datas_CGI2Item($datas,&$item,$plural=FALSE,$precgikey="")
    {
        $updatedata=array();
        foreach ($datas as $data)
        {
            if ($this->MyMod_Data_Access($data,$item)>=2)
            {
                 $rdata=$data;
                 if ($plural)
                 {
                     $rdata=$item[ "ID" ]."_".$data;
                 }
                 if ($precgikey)
                 {
                     $rdata=$precgikey.$rdata;
                 }
                    
                 if (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ]))
                 {
                     $this->MyMod_Data_Fields_File_Update($data,$item,$rdata);
                     array_push($updatedata,$data);
                 }
                 else
                 {
                     $rdata=$data;
                     if ($plural)
                     {
                         $rdata=$item[ "ID" ]."_".$data;
                     }
                    
                      if (
                           preg_match('/^ENUM$/',$this->ItemData[ $data ][ "Sql" ])
                           &&
                           $this->ItemData[ $data ][ "SelectCheckBoxes" ]==3
                         )
                     {
                         if (!isset($_POST[ $rdata ]))
                         {
                             $value=1;
                         }
                         else
                         {
                             $value=2;
                         }
                     }
                     else
                     {
                         $value=$this->CGI_POST($rdata);
                     }
                     
                     if (empty($item[ $data ]) || $item[ $data ]!=$value)
                     {
                         $item[ $data ]=$value;
                         array_push($updatedata,$data);
                     }

                 }
            }
        }

        return $updatedata;
    }
    
}

?>