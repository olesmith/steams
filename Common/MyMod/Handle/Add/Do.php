<?php

trait MyMod_Handle_Add_Do
{  
    //*
    //* Add preprocesses $item. Do nothing, supposed to be overrridden.
    //*

    function MyMod_Handle_Add_Do_PreProcess(&$item)
    {
        return False;
    }
    
    //*
    //* Add preprocesses $item. Do nothing, supposed to be overrridden.
    //*

    function MyMod_Handle_Add_Do_PostProcess(&$item)
    {
        return True;
    }
    
    //*
    //* Add testing $item. Do nothing, supposed to be overrridden.
    //*

    function MyMod_Handle_Add_Do_Test(&$item)
    {
        return True;
    }
    
    //*
    //* Adds item to DB.
    //*

    function MyMod_Handle_Add_Do(&$msg,&$item=array())
    {
        if (empty($item))
        {
            $item=
                array_merge
                (
                    $this->MyMod_Item_GET_Read(),
                    $this->MyMod_Item_POST_Read()
                );
        }

        foreach ($this->MyMod_Handle_Add_Fixed() as $data => $value)
        {
            $item[ $data ]=$value;
        }

        if ($this->MyMod_Item_Unique_Is($item))
        {
            foreach ($this->AddDefaults as $data => $value)
            {
                if
                    (
                        !isset($item[ $data ])
                        ||
                        empty($item[ $data ])
                    )
                {
                    $item[ $data ]=$value;
                }
            }
            
            $this->MyMod_Handle_Add_Do_PreProcess($item);
            
            $ritem=$item;
            $item=$this->MyMod_Item_Test($item);


            if (isset($item[ "__Errors__" ]) && $item[ "__Errors__" ]>0)
            {
                 $this->ItemHash=$item;
                 $this->AddDefaults=$item;

                 $this->MyMod_Handle_Message=
                     $this->Htmls_List($item[ "__Error_Messages__" ]);
                 return FALSE;
            }
 
            $ritem[ "ATime" ]=time();
            $ritem[ "MTime" ]=$ritem[ "ATime" ];
            $ritem[ "CTime" ]=$ritem[ "ATime" ];

            foreach (array_keys($ritem) as $id => $data)
            {
                if (!isset($this->ItemData[ $data ]) || !empty($this->ItemData[ $data ][ "Derived" ]))
                {
                    unset($ritem[ $data ]);
                }
            }

            if (isset($this->ItemData[ $this->CreatorField ]))
            {
                if (!isset($item[ $this->CreatorField ]))
                {
                    $ritem[ $this->CreatorField ]=$this->FindLoggedID();
                }
            }

            $test=True;
            if (method_exists($this,"MyMod_Handle_Add_Do_Test"))
            {
                $test=$this->MyMod_Handle_Add_Do_Test($item);
            }
            
            if ($test)
            {
                $res=$this->Sql_Insert_Item($ritem,$this->SqlTableName());
                $item[ "ID" ]=$ritem[ "ID" ];


                $item=$this->SetItemTimes($item);
                $item=$this->MyMod_Item_Derived_Data_Read($item);
                $item=$this->MyMod_Item_PostProcess($item);

                $this->MyMod_Handle_Add_Do_PostProcess($item);
            
                $this->ItemHash=$item;
                $this->ApplicationObj->LogMessage("Item Added");

                return TRUE;
            }
            else { var_dump("Discarded by ".$this->ModuleName." MyMod_Handle_Add_Do_Test."); }
        }
        else
        {
            $msg=
                join
                (
                    " ",
                    array
                    (
                        $this->MyLanguage_GetMessage("New"),
                        $this->MyMod_ItemName(),
                        $this->MyLanguage_GetMessage("not"),
                        $this->MyLanguage_GetMessage("Unique").":",
                        $this->MyMod_Unicity_Field_Offending
                    )
                );

            echo $msg;
        }

        $this->ItemHash=$item;
        $this->AddDefaults=$item;

        return FALSE;
    }

}

?>