<?php

trait MyMod_Handle_Email_Table
{
 
    //*
    //* function MyMod_Handle_Emails_Table, Parameter list: $edit,$emails,$ncols,$selected=FALSE,$disabled=FALS,$nemailsperline=2E
    //*
    //* Creates table with checkboxes and emails.
    //*

    function MyMod_Handle_Emails_Table($edit,$emails,$ncols,$selected=FALSE,$disabled=FALSE,$nemailsperline=2)
    {
        if (count($emails)<-2)
        {
            $selected=True;
        }
        
        $table=array();
        foreach ($this->PageArray($emails,$nemailsperline) as $remails)
        {
            $row=array();
            foreach ($remails as $email)
            {
                array_push
                (
                   $row,
                   $this->MyMod_Handle_Email_Cell($edit,$email,$selected,$disabled)
                );
            }

            array_push($row,"");
            array_push($table,$row);
        }

        if ($edit==1 && count($emails)>2)
        {
            array_unshift
            (
                $table,
                array
                (
                    $this->B("Incluir Todas: "),
                    $this->MakeCheckBox("Inc_All",1,$selected,$disabled),
                )
            );
        }



        return $table;
    }
}

?>