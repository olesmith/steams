<?php

trait Language_Messages_Groups_Names
{
    //*
    //* function Language_Group_Names, Parameter list: $module,$key
    //*
    //* 

    function Language_Group_Names($moduleobj)
    {
        return
            array
            (
                "Name",
                "Title",
            );
    }
    
    //*
    //* function Language_Group_Name_Get, Parameter list: $module,$key
    //*
    //* 

    function Language_Group_Names_Read($moduleobj,$key,$singular,$data="Name",$croak=False)
    {
        if (empty($this->Groups[ $moduleobj->ModuleName ]))
        {
            $this->Groups[ $moduleobj->ModuleName ]=array();
        }
        
        if (empty($this->Groups[ $moduleobj->ModuleName ][ $key ]))
        {
            $this->Groups[ $moduleobj->ModuleName ][ $key ]=
                $this->Language_Module_Filter
                (
                    $moduleobj,
                    $this->Language_Message_Item_Get
                    (
                        $this->Language_Group_Type_Get($singular),
                        $key,
                        $this->Language_Group_Names($moduleobj),
                        "",
                        array("Module" => $moduleobj->ModuleName)
                    )
                );

         }
     }
    
    //*
    //* function Language_Group_Title_Get, Parameter list: $module,$key,$singular,$datas=array()
    //*
    //* 
    //*

    function Language_Group_Name_Get($moduleobj,$key,$singular,$datas=array())
    {
        if (empty($datas)) { $datas=$this->Language_Group_Names($moduleobj); }
        $hash=$moduleobj->ItemDataGroups;
        if ($singular) { $hash=$moduleobj->ItemDataSGroups; }

        if (!empty($hash[ $key  ]))
        {
            foreach ($datas as $data)
            {
                $name=$this->GetRealNameKey($hash[ $key ],$data);
                if (!empty($name)) { return $name; }
            }
        }

        $this->Language_Group_Names_Read($moduleobj,$key,$singular);
                
        $title="undef Group $key";
        foreach ($datas as $data)
        {
            $rdata=$data."_".$this->ApplicationObj()->Language;
            if (!empty($this->Groups[ $moduleobj->ModuleName ][ $key ][ $rdata ]))
            {
                return
                    $this->Message_Debug_Pre.
                    $this->Groups[ $moduleobj->ModuleName ]
                    [ $key ][ $rdata ];
            }
        }

        
        //Still here, create and warn!
        $this->Language_Message_Auto_Create
            (
                $this->Language_Group_Type_Get($singular),
                $key,
                $moduleobj->ModuleName
            );
        
        #if ($croak) { $this->Warn("Unable to retrieve system message",$key,$type); }
        
        return " ";
    }
}
?>