<?php



trait MyMod_Unique
{
    var $UniqueKeys=array();
    
    //*
    //* Add item, if not added alredy.
    //* Uses 
    //*

    function MyMod_Unique_Add($hash)
    {
        $rwhere=array();
        foreach ($this->UniqueKeys as $key)
        {
            $rwhere[ $key ]=$hash[ $key ];
        }

        $ritem=
            $this->Sql_Select_Hash
            (
                $rwhere
            );
 
        if (empty($ritem))
        {
            $ritem=$hash;
            $res=$this->Sql_Insert_Item($ritem);
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                if (empty($ritem[ $key ])) { $ritem[ $key ]=$value; }
            }
        }

        return $ritem;
    }


}

?>