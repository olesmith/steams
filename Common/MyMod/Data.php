<?php


include_once("Data/Access.php");
include_once("Data/Defaults.php");
include_once("Data/Groups.php");
include_once("Data/Files.php");
include_once("Data/Read.php");
include_once("Data/Fields.php");
include_once("Data/TimeData.php");
include_once("Data/Language.php");
include_once("Data/Info.php");
include_once("Data/Title.php");
include_once("Data/Triggers.php");
include_once("Data/Upload.php");

trait MyMod_Data
{
    use 
        MyMod_Data_Access,
        MyMod_Data_Defaults,
        MyMod_Data_Groups,
        MyMod_Data_Fields,
        MyMod_Data_Files,
        MyMod_Data_Read,
        MyMod_Data_TimeData,
        MyMod_Data_Language,
        MyMod_Data_Info,
        MyMod_Data_Title,
        MyMod_Data_Triggers,
        MyMod_Data_Upload;


    //*
    //* function MyMod_Data_Is, Parameter list: $data
    //*
    //* Returns true if $data is defined in ItemData.
    //*

    function MyMod_Data_Is($data)
    {
        $res=False;
        if (!empty($this->ItemData[ $data ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* function MyMod_Datas, Parameter list: $datas
    //*
    //* Returns item data in $datas.
    //*

    function MyMod_Datas($datas)
    {
        $rdatas=array();
        foreach (array_keys($datas) as $id)
        {
            if ($this->MyMod_Data_Is($datas[ $id ]))
            {
                array_push($rdatas,$datas[ $id ]);
            }
        }

        return $rdatas;
    }
    
    //*
    //* function MyMod_Data_Init, Parameter list: $initstructure=FALSE,$readitemgroupsdata=FALSE
    //*
    //* Initializes Item data; updates DB fields
    //* if $updatetable is set to TRUE in call.
    //*

    function MyMod_Data_Init($initstructure=FALSE,$readitemgroupsdata=FALSE)
    {
        $this->ItemData();

        if ($readitemgroupsdata)
        {
            $this->MyMod_Data_Groups_Initialize();
        }

        $this->MyMod_Data_Permissions_Init();
        
        if ($initstructure)
        {
            $this->MyMod_SubModule_Structure_Init($this->ModuleName);
        }

        foreach ($this->ItemData as $data => $hash)
        {
            if ($data=="ID")
            {
                $this->ItemData[ $data ][ "ReadOnly" ]=1;
            }
            
            if (isset($this->ItemData[ $data ][ "IsDate" ]) && $this->ItemData[ $data ][ "IsDate" ])
            {
                if (empty($this->ItemData[ $data ][ "TriggerFunction" ]))
                {
                    $this->ItemData[ $data ][ "TriggerFunction" ]="MyMod_Item_Trim_Date";
                }
            }

            foreach ($this->ItemData[ $data ] as $key => $value)
            {
                if (is_array($value))
                {
                    foreach ($value as $id => $val)
                    {
                        if (is_string($val))
                        {
                            $value[ $id ]=preg_replace('/#LoginID/',$this->LoginID,$val);
                        }
                    }

                    $this->ItemData[ $data ][ $key ]=$value;
                }
                elseif (is_string($value))
                {
                    $this->ItemData[ $data ][ $key ]=
                        preg_replace('/#LoginID/',$this->LoginID,$value);
                }
            }

            if (!empty($this->ItemData[ $data ][ "TriggerFunction" ]))
            {
                $this->TriggerFunctions[ $data ]=$this->ItemData[ $data ][ "TriggerFunction" ];
            }
        }
        
        $this->MyLanguage_HashTakeNameKeys($this->ItemData);
    }

    //*
    //* function MyMod_Data_2ModuleKey, Parameter list: $data,$key
    //*
    //* Tries to convert a key, (ex SqlFilter) to value for module $data.
    //*

    function MyMod_Data_2ModuleKey($data,$key)
    {
        $rkey="";
        $class=$this->MyMod_Data_Field_Is_Sql($data);
        if (!empty($class))
        {
            if (!empty($this->ItemData[ $data ][ $key ]))
            {
                $rkey=$this->ItemData[ $data ][ $key ];
            }
            elseif (!empty($this->ApplicationObj()->SubModulesVars[ $class ][ $key ]))
            {
                $rkey=$this->ApplicationObj()->SubModulesVars[ $class ][ $key ];
            }
        }

        return $rkey;
    }
    
    //*
    //* function MyMod_Data_2Module, Parameter list: $data
    //*
    //* Tries to convert a key, (ex SqlFilter) to value for module $data.
    //*

    function MyMod_Data_2Module($data)
    {
        $rkey="";
        $method=$this->MyMod_Data_2ModuleKey($data,"SqlClass");
        if (!empty($method))
        {
            $method.="Obj";
            return $this->$method();
        }

        $this->DoDie("Error retrieving data module",$data);
    }

    
    //*
    //* Returns true if $data is Compulsory.
    //*

    function MyMod_Data_Field_Compulsory($data)
    {
        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              $this->ItemData[ $data ][ "Compulsory" ]
           )
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* Returns true if $data is Languaged.
    //*

    function MyMod_Data_Languaged_Is($data)
    {
        $res=False;
        if (!empty($this->ItemData[ $data ][ "Languaged" ]))
        {
            $res=True;
        }

        return $res;
    }

    
    //*
    //* Returns true if $data is Compulsory.
    //*

    function MyMod_Data_Compulsories()
    {
        $datas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->MyMod_Data_Field_Compulsory($data))
            {
                array_push($datas,$data);
            }
        }
        
        return $datas;
    }

    //*
    //* Returns true if $data is Compulsory.
    //*

    function MyMod_Data_Writeable()
    {
        $datas=array();
        foreach (array_keys($this->ItemData) as $id => $data)
        {
            if (!$this->ItemData[ $data ][ "ReadOnly" ])
            {
                if (!preg_match('/[MCA]Time/',$data))
                {
                    array_push($datas,$data);
                }
            }
        }
        
        return $datas;
    }

    
    //*
    //* function MyMod_Data_EmptyText, Parameter list: $data,$emptytext=""
    //*
    //* Generates title rows based on $datas.
    //*

    function MyMod_Data_EmptyText($data)
    {
        $emptytext=
            $this->LanguagesObj()->Language_Data_Name_Get($this,$data."_Empty");
        if (preg_match('/^undef:/',$emptytext)) { return ""; };

        return $emptytext;
    }

    
    //*
    //* Removes action entreis from $datas
    //*

    function MyMod_Datas_Actions_Remove($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            $action=$this->Actions($data,"Name");
            if (empty($action))
            {
                array_push($rdatas,$data); 
            }
        }

        return $rdatas;
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Compulsory_Message()
    {
        return
            $this->Htmls_Center
            (
                array
                (
                    $this->Htmls_Span
                    (
                        "*:",
                        array("CLASS" => 'errors')
                    ),
                    $this->MyLanguage_GetMessage
                    (
                        "Compulsory_Message"
                    ),
                ),
                array("CLASS" => 'datatitlelink')
            );
    }
   
    //*
    //* 
    //*

    function MyMod_Data_Image_Types_Regex()
    {
        return '/(png|jpe?g|gif|svg)$/i';
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Image_Value_Is($value)
    {
        $regex=$this->MyMod_Data_Image_Types_Regex();

        $res=False;
        if (preg_match($regex,$value))
        {
            $res=True;
        }

        return $res;        
    }

    
    //*
    //* function MyMod_Data_Allowed_Get, Parameter list: $edit=0,$datas=array(),$item=array()
    //*
    //* Returns list of data allowed to read ($edit=0) or write ($edit=1), in $datas.
    //*
    //* If $datas is empty, uses all data. Calls MyMod_Data_Access.
    //*
    //* $item is transfered when calling MyMod_Data_Access, for item particular permissions.
    //*

    function MyMod_Data_Allowed_Get($edit=0,$datas=array(),$item=array())
    {
        if (empty($datas)) { $datas=array_keys($this->ItemData()); }

        $item=array();

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            $access=$this->MyMod_Data_Access($data,$item);
            if ($access>$edit)
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }

    //*
    //* 
    //*

    function MyMod_ItemData_Rename($olddata,$newdata,$sqltable="")
    {
        $status_message=
            $this->Sql_Table_Column_Rename("Title","Title_PT",$sqltable);
        $msg=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                array
                (
                    "Module" => $this->ModuleName,
                    "Message_Type" => $this->LanguagesObj()->Language_Data_Type,
                    "Message_Key" => $olddata,
                )
            );

        if (!empty($msg[ "ID" ]))
        {
            $this->LanguagesObj()->Sql_Update_Item_Value_Set($msg[ "ID" ],"Message_Key",$newdata);
        }

        return $status_message;
    }
    
    //*
    //* 
    //*

    function MyMod_ItemData_Get($data,$key,$subkey="")
    {
        $def=$this->ItemData($data,$key);
        
        if (!is_array($def))
        {
            return $def;
        }

        if ($subkey==-1)
        {
            if (isset($this->ItemData[ $data ][ "Default" ]))
            {
                $subkey=$this->ItemData[ $data ][ "Default" ]-1;
            }
        }
        
        $value="";
        if (isset($def[ $subkey ]))
        {
            $value=$def[ $subkey ];
        }
        
        return $value;
    }

    
    //*
    //* Updates data permissions from Profile.
    //*

    function MyMod_Data_Permissions_Init()
    {
        $alldatas=array_keys($this->ItemData);

        //Take directly defined data permissions, via $this->ProfileHash[ "Data" ][ "Access" ]
        if (isset($this->ProfileHash[ "Data" ][ "Access" ]))
        {
            foreach ($this->ProfileHash[ "Data" ][ "Access" ] as $data => $value)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=$value;
                        $this->ItemData[ $rdata ][ $this->Profile ]=$value;
                    }
                }

                if (!isset($this->ItemData[ $rdata ][ $this->Profile ]))
                {
                    $this->ItemData[ $rdata ][ $this->Profile ]=0;
                }
                if (!isset($this->ItemData[ $rdata ][ $this->LoginType ]))
                {
                    $this->ItemData[ $rdata ][ $this->LoginType ]=0;
                }
            }
        }

        //Take data read permissions (1) defined via $this->ProfileHash[ "Data" ][ "Read" ]
        if (
            isset($this->ProfileHash[ "Data" ][ "Read" ])
            &&
            is_array($this->ProfileHash[ "Data" ][ "Read" ])
           )
        {
            foreach ($this->ProfileHash[ "Data" ][ "Read" ] as $id => $data)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=1;
                        $this->ItemData[ $rdata ][ $this->Profile ]=1;
                    }
                }
            }
        }

        //Take data write permissions (2) defined via $this->ProfileHash[ "Data" ][ "Write" ]

        if (
            isset($this->ProfileHash[ "Data" ][ "Write" ])
            &&
            is_array($this->ProfileHash[ "Data" ][ "Write" ])
           )
        {
            foreach ($this->ProfileHash[ "Data" ][ "Write" ] as $id => $data)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=2;
                        $this->ItemData[ $rdata ][ $this->Profile ]=2;
                    }
                }
            }
        }
    }
}

?>