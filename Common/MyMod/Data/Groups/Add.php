<?php



trait MyMod_Data_Groups_Add
{
    //*
    //* function MyMod_Data_Groups_Files_Add_Files, Parameter list: $singular,$files
    //*
    //* Adds action files.
    //*

    function MyMod_Data_Groups_Files_Add_Files($singular,$files)
    {
        foreach ($files as $file)
        {
            $this->MyMod_Data_Groups_Files_Add_File($singular,$file);
        }
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_File, Parameter list: $singular,$file
    //*
    //* Adds actions
    //*

    function MyMod_Data_Groups_Files_Add_File($singular,$file)
    {
        $this->MyMod_Data_Groups_Files_Add_Groups
        (
            $singular,
            $this->ReadPHPArray($file),
            $file
        );
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_Groups, Parameter list: $singular,$groups,$file
    //*
    //* Adds actions
    //*

    function MyMod_Data_Groups_Files_Add_Groups($singular,$groups,$file)
    {
        //$this->MyMod_Data_Groups_Defaults_Take($groups);
        
        foreach (array_keys($groups) as $group)
        {
            if ($singular)
            {
                if (empty($this->ItemDataSGroups[ $group ]))
                {
                    $this->MyMod_Data_Group_Defaults_Take($this->ItemDataSGroups[ $group ]);
                }
            }
            else
            {
                if (empty($this->ItemDataGroups[ $group ]))
                {
                    $this->MyMod_Data_Group_Defaults_Take($this->ItemDataGroups[ $group ]);
                }
            }

            $rfile=$file;
            if (is_string($groups[ $group ]))
            {
                //var_dump($groups[ $group ]);
                $groups[ $group ]=$this->ReadPHPArray($groups[ $group ]);
                //var_dump($groups[ $group ]);
            }
                
            $groups[ $group ][ "File" ]=$rfile;
            if ($singular)
            { 
                $this->MyMod_Data_Groups_Files_Add_SGroup($group,$groups[ $group ],$rfile);
            }
            else
            {
                $this->MyMod_Data_Groups_Files_Add_Group($group,$groups[ $group ],$rfile);
            }
        }
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_Group, Parameter list: $group,$hash,$file
    //*
    //* Adds $group.
    //*

    function MyMod_Data_Groups_Files_Add_Group($group,$hash,$file)
    {        
        if (!isset($this->ItemDataGroups[ $group ]))
        {
            $this->ItemDataGroups[ $group ]=$hash;
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                $this->ItemDataGroups[ $group ][ $key ]=$value;
            }
        }

        array_push
        (
            $this->ItemDataGroups[ $group ][ "Files" ],
            $file
        );
        
        $this->ItemDataGroups[ $group ][ "__Key__" ]=$group;
        $this->ItemDataGroups[ $group ][ "Singular" ]=False;
        $this->ItemDataGroups[ $group ][ "__Name__" ]=$group;
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_SGroup, Parameter list: $group,$hash,$file
    //*
    //* Adds $group.
    //*

    function MyMod_Data_Groups_Files_Add_SGroup($group,$hash,$file)
    {
        if (!isset($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=$hash;
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                $this->ItemDataSGroups[ $group ][ $key ]=$value;
            }
        }
        
        array_push
        (
            $this->ItemDataSGroups[ $group ][ "Files" ],
            $file
        );
        
        $this->ItemDataSGroups[ $group ][ "__Key__" ]=$group;
        $this->ItemDataSGroups[ $group ][ "Singular" ]=True;
        $this->ItemDataSGroups[ $group ][ "__Name__" ]=$group;
    }


    //*
    //* function MyMod_Data_Group_TableWithAddRow, Parameter list: 
    //*
    //* Creates ItemTableDataGroup table with add row. Update and adding row called on the way.
    //*

    function MyMod_Data_Group_TableWithAddRow($title,$group,$cgiupdatevar,$cgiprekey,$newitem,$postmethod=FALSE,$updatekey="AddRow",$nempties=0)
    {
        $this->ItemData();
        $this->ItemDataGroups();
        var_dump($this->ModuleName,$group);
        $datas=$this->ItemDataGroups[ $group ][ "Data" ];
        $added=FALSE;
        if ($this->GetPOST($cgiupdatevar)==1 && $this->GetPOST($updatekey)==1)
        {
            $newitem=
                $this->UpdateAddRow($cgiprekey,$newitem,$datas,$updatekey);
        }

        $this->MyMod_Items_Read("",$datas,TRUE,FALSE,2);
 
        if ($postmethod)
        {
            $newitem=$this->$postmethod($newitem);
        }


        $table=$this->MyMod_Data_Group_Table
        (
           $title,
           1,
           $group,
           $this->ItemHashes,
           array(),
           $cgiupdatevar
        );

        array_push
        (
           $table,
           $this->AddRow($cgiprekey,$newitem,$datas,!$added,$nempties)
        );

        return $table;
    }
}

?>