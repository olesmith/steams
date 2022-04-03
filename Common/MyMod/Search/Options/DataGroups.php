<?php


trait MyMod_Search_Options_DataGroups
{
    //*
    //* function MyMod_Search_Options_Show_All_Cells, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Data_Groups_Cells($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("Datagroups",$omitvars))
        {
            return array();
        }

        $row=array();
        if (!preg_grep('/^DataGroups/',$omitvars))
        {
            $field=$this->Search_Options_Data_Groups_Field();
            if (!empty($field))
            {
                array_push
                ( 
                   $row,
                   $this->Htmls_DIV
                   (
                       $this->MyLanguage_GetMessage("DataGroupsTitle").":",
                       array("CLASS" => 'searchtitle')
                   ),
                   $field
                );
            }
        }

        return $row;
    }
    
    //*
    //* function Search_Options_Data_Groups_Field, Parameter list: $data
    //*
    //* Creates select fields do choose data group
    //*

    function Search_Options_Data_Groups_Field()
    {
        $values=array(0);
        $names=array("");
        $titles=array("");

        foreach ($this->MyMod_Data_Groups_Get() as $groupid)
        {
            $group=$this->ItemDataGroups[ $groupid ];

            $name=
                $this->LanguagesObj()->Language_Group_Name_Get
                (
                    $this,
                    $groupid,
                    False
                );
            
            //Check if group allowed
            if
                (
                    $this->MyMod_Group_Allowed($group)
                    &&
                    !empty($name)
                )
            {
                if
                    (
                        isset($group[ "Visible" ])
                        &&
                        !$group[ "Visible" ]
                    )
                { continue; }
                
                array_push($values,$groupid);
                array_push
                (
                    $names,
                    $name
                );
                
                array_push
                (
                    $titles,
                    $this->LanguagesObj()->Language_Group_Title_Get($this,$groupid,False)
                );
            }
        }

        if (count($values)==0) { return ""; }

        return
            $this->Htmls_Select
            (
               $this->ModuleName."_GroupName",
               $values,
               $names,
               $this->MyMod_Data_Group_Actual_Get(),
               array
               (
                   "Disableds" => array(),
                   "Titles" => $titles,
                   "Title" => $this->MyLanguage_GetMessage
                   (
                       "DataGroupsTitle",
                       "Title"
                   ),
                   "MaxLen" => 0,
                   "ExcludeDisableds" => False,
                   "Multiple" => False,
                   "OnChange" => Null,
               )
            );
    }  
}

?>