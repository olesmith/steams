<?php


trait MyMod_Search_Field_Method
{
    //*
    //* function MyMod_Search_Field_Method_Call, Parameter list: $data
    //*
    //* Call search field method.
    //*

    function MyMod_Search_Field_Method_Call($data,$fixedvalue,$rval="")
    {
        if ( !empty($this->ItemData[ $data ][ "SearchFieldMethod" ]) )
        {
            $method=$this->ItemData[ $data ][ "SearchFieldMethod" ];

            if (method_exists($this,$method))
            {
                $rval=$this->$method($data,$fixedvalue);
            }
            else
            {
                $this->ApplicationObj()->MyApp_Interface_Message_Add
                (
                    $this->ModuleName.", $data: Empty SearchFieldMethod"
                );
            }
        }
        else
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
                $this->ModuleName.", $data: Empty SearchFieldMethod"
            );
        }

        return $rval;
    }
}

?>