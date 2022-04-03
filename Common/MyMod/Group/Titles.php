<?php

trait MyMod_Group_Titles
{
    //*
    //* function MyMod_Data_Group_Titles, Parameter list: 
    //*
    //* Creates plural group items table title row.
    //*

    function MyMod_Data_Group_Titles($group,$datas=array(),$titles=array())
    {
        if (empty($titles))
        {
            $titles=$datas;
        }

        if
            (
                isset($this->ItemDataGroups[ $group ][ "NoTitleRow" ])
                &&
                $this->ItemDataGroups[ $group ][ "NoTitleRow" ]
            )
        {
            $titles=array();
        }
        
        if ($this->MyMod_Language_Data_Tabled())
        {
            foreach (array_keys($titles) as $tid)
            {
                if ($this->MyMod_Data_Languaged_Is($titles[ $tid ]))
                {
                    $titles[ $tid ].=$this->MyLanguage_GetLanguageKey();
                }
            }
        }

        return $titles;
    }
    
    //*
    //* Returns data group name, call LanguagesObj.
    //*

    function MyMod_Data_Group_Name($group,$singular=False)
    {
        return
            $this->LanguagesObj()->Language_Group_Name_Get
            (
                $this,
                $group,
                $singular
            );     
    }
    
    //*
    //* Returns data group name, call LanguagesObj.
    //*

    function MyMod_Data_Group_Title($group,$singular=False)
    {
        return
            $this->LanguagesObj()->Language_Group_Title_Get
            (
                $this,
                $group,
                False
            );     
    }

    
    //*
    //* Returns data group name, call LanguagesObj.
    //*

    function MyMod_Data_SGroup_Name($group)
    {
        return $this->MyMod_Data_Group_Name($group,$singular=True);     
    }
    
    //*
    //* Returns data group name, call LanguagesObj.
    //*

    function MyMod_Data_SGroup_Title($group)
    {
        return $this->MyMod_Data_Group_Title($group,$singular=True);     
    }
}

?>