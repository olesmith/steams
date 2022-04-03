<?php


trait MyMod_Item_POST
{
    //*
    //* Reads item from POST.
    //* Data values for data in $this->ItemData[ $data ],
    //* are taken directly from POST.
    //* Returns the item.
    //*

    function MyMod_Item_POST_Read($item=array())
    {
        foreach ($this->ItemData as $data => $value)
        {
            $rdata=$data;
            if (!empty($this->ItemData[ $data ][ "CGIName" ]))
            {
                $rdata=$this->ItemData[ $data ][ "CGIName" ];
            }

            if (!isset($_POST[ $rdata ])) { continue; }
           
            $newvalue=$this->CGI_POST($rdata);
            if (!empty($newvalue))
            {
                if ($this->MyMod_Data_Field_Is_Crypted($data) && !empty($newvalue))
                {
                    $newvalue=$this->MyMod_Data_Field_Crypt($data,$newvalue);
                }
            }

            if (!empty($this->ItemData[ $data ][ "IsDate" ]) && !empty($newvalue))
            {
                if (preg_match('/\//',$newvalue))
                {
                    $newvalue=$this->Date2Sort($newvalue);
                }
            }

            $item[ $data ]=$newvalue;
        }

        $this->ItemHash=$item;

        return $item;
    }
    
    //*
    //* Reads item from GET.
    //* Data values for data in $this->ItemData[ $data ],
    //* are taken directly from GET.
    //* Returns the item.
    //*

    function MyMod_Item_GET_Read($item=array())
    {
        foreach ($this->ItemData as $data => $value)
        {
            $rdata=$data;
            if (!empty($this->ItemData[ $data ][ "CGIName" ]))
            {
                $rdata=$this->ItemData[ $data ][ "CGIName" ];
            }

            if (!isset($_GET[ $rdata ])) { continue; }
           
            $item[ $data ]=$this->CGI_GET($rdata);
        }
        
        return $item;
    }
}

?>