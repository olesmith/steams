<?php


trait MyMod_Search_Table_Titles
{
    //*
    //* function MyMod_Search_Table_Title, Parameter list: 
    //*
    //* Returns search table title
    //*

    function MyMod_Search_Table_Title($title)
    {
        $btitle=$this->GetMessage($this->MyMod_Search_Messages,"SearchButton");
        if (empty($title))
        {
            $title.=
                $btitle.
                " ".
                $this->MyMod_ItemsName();
        }

        return $title;        
    }
    
    //*
    //* function MyMod_Search_Table_Title_Row, Parameter list: 
    //*
    //* Returns search table title rows (matrix)
    //*

    function MyMod_Search_Table_Title_Row($title)
    {
        return
            array
            (
                $this->H
                (
                    1,
                    $this->MyMod_Search_Table_Title($title),
                    array("CLASS" => 'searchtabletitle')
                )
            );
    }
}

?>