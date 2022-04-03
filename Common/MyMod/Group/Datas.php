<?php

trait MyMod_Group_Datas
{
    //*
    //* Return $groupname hidden field.
    //*

    function MyMod_Group_Hidden($groupname="")
    {
        if (empty($groupname))
        {
            $groupname=$this->MyMod_Data_Group_Actual_Get();
        }

        return
            $this->MakeHidden
            (
                $this->MyMod_Groups_CGI_Key(),
                $groupname
            );
    }

    //*
    //* Return group edit hidden field.
    //*

    function MyMod_Group_Hidden_Edit($edit)
    {
        return
            $this->MakeHidden
            (
                $this->MyMod_Groups_CGI_Edit_Key(),
                2
            );
    }
    
    //*
    //* Return paging hidden field. Disabled!?
    //*

    function MyMod_Group_Hidden_Page($edit)
    {
        //Page var included in FROM URL.
        return "";

        /* return $this->MakeHidden */
        /* ( */
        /*    $this->GroupDataPageVar(), */
        /*    $this->GetGETOrPOST($this->GroupDataPageVar()) */
        /* ); */
    }


    //*
    //* Return object data group CGI Var var.
    //*

    function MyMod_Groups_CGI_Key()
    {
        return $this->ModuleName."_GroupName";
    }

    //*
    //* Return object data group CGI Var var.
    //*

    function MyMod_Groups_CGI_Edit_Key()
    {
        return $this->ModuleName."_Edit";
    }


    //*
    //* Returns list of data groups defs.
    //*

    function MyMod_Groups_Get()
    {
        if ($this->Singular)
        {
            return $this->ItemDataSGroupNames;
        }
        else
        {
            return $this->ItemDataGroupNames;
        }
    }
    
    //*
    //* 
    //* 
    
    function MyMod_Group_Datas()
    {
        $groupname="";
        foreach ($this->MyMod_Groups_Get() as $id => $group)
        {
            if (!$this->Singular)
            {
                if ($this->MyMod_Group_Allowed($this->ItemDataGroups[$group ]))
                {
                    $groupname=$group;
                }
            }
            else
            {
                if ($this->MyMod_Group_Allowed($this->ItemDataSGroups[$group ]))
                {
                    $groupname=$group;
                }
            }
        }

        return
            $this->MyMod_Data_Group_Datas_Get($groupname);
    }

    
    //*
    //* Returns list of data in items table.
    //* 

    function MyMod_Group_Datas_Get($datas)
    {
        $rdatas=array();

        $unique=array();
        foreach ($datas as $data)
        {
            if (preg_match('/newline/',$data))
            {
                array_push($rdatas,$data);
            }
            elseif (empty($unique[ $data ]))
            {
                array_push($rdatas,$data);
                $unique[ $data ]=TRUE;
            }
        }

        return $rdatas;
    }    

    //*
    //* function MyMod_Group_Datas_Title_Row, Parameter list: ($datas)
    //*
    //* 
    //* 

    function MyMod_Group_Datas_Title_Row($datas)
    {
        return
            $this->Html_Table_Head_Row
            (
                $this->MyMod_Data_Titles($datas)
            );
    }
}

?>