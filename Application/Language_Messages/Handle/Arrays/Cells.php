<?php

class Language_Messages_Handle_Arrays_Cells extends Language_Messages_Handle_Arrays_Read
{
    //*
    //* Creates $ritem $lang $data cell.
    //*

    function Language_Messages_Handle_Array_Language_Data_Cell_Classes($lang,$data)
    {
        return array($data);
    }
    

    
    //*
    //* Visible/Hidden Data title cell.
    //*

    function Language_Messages_Handle_Array_Cell_Data_Title($data,$lang)
    {
        $cell=
            array
            (
                "Class" => $this->Language_Messages_Handle_Array_Language_Data_Cell_Classes($lang,$data),
                "Cell" => $data,
            );

        if ($this->Language_Messages_Handle_Array_Hide_Data_Should($data))
        {
            $cell[ "Style" ]="display: none;";
        }

        return $cell;                
    }
    
}
?>