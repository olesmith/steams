<?php


class Permissions_Select extends Permissions_User
{
    //*
    //*
    //*

    function Permission_Select_Profile($data,$item,$edit,$rdata)
    {
        $trust=$this->Profile_Trust();

        $values=array(0);
        $valuenames=array("");
        $disableds=array("");
        /* var_dump($this->ItemData[ "Profile" ][ "Values" ], */
        /* $this->Permissions_Profile_Selects()); */
        

        foreach ($this->Permissions_Profile_Selects() as $n => $profile)
        {
            array_push($values,$n+1);
            array_push($valuenames,$profile);

            $disabled=True;
            if ($trust>$this->Profile_Trust($profile))
            {
                $disabled=False;
            }
            
            array_push($disableds,$disabled);
            
        }
        
        return
            $this->Htmls_Select
            (
                $rdata,
                $values,
                $valuenames,
                $selected=$item[ $data ],
                $args=array
                (
                    "Disableds" => $disableds,
                )
            );
    }

}

?>