<?php

include_once("Test/Regexp.php");
include_once("Test/Compulsory.php");
include_once("Test/Unique.php");

trait MyMod_Item_Test
{
    use
        MyMod_Item_Test_Regexp,
        MyMod_Item_Test_Compulsory,
        MyMod_Item_Test_Unique;
    
    //*
    //* Tests item data according to prescribed data definitions.
    //* Messages are stored in $data."_Message" keys of item.
    //* Modified item is returned.
    //*


    function MyMod_Item_Test($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }

        $item=$this->MyMod_Item_Derived_Data_Read($item);

        $messages=array();
        $nerrors=0;

        if (!$item) { $item=array(); }

        foreach ($item as $data => $value)
        {
            $nerrors+=
                $this->MyMod_Item_Test_Data($item,$data,$messages);
        }

        if ($this->TestMethod)
        {
            $method=$this->TestMethod;
            if (method_exists($this,$method))
            {
                $item=$this->$method($item);
            }
            else
            {
                $this->AddMsg("TestMethod '".$method."' undefined");
            }
        }

        unset($item[ "__Error_Messages__" ]);
        unset($item[ "__Errors__" ]);
        if ($nerrors>0)
        {
            $item[ "__Error_Messages__" ]=$messages;
            $item[ "__Errors__" ]=$nerrors;
        }

        $this->ItemHash=$item;

        return $item;
    }

     
    //*
    //* Tests item data according to prescribed data definitions.
    //* Messages are stored in $data."_Message" keys of item.
    //* Modified item is returned.
    //*


    function MyMod_Item_Test_Data(&$item,$data,&$messages)
    {
        if (!isset($this->ItemData[ $data ]))
        {
            return;
        }

        unset($item[ $data."_Message" ]);

        $nerrors=0;
        
        $nerrors+=
            $this->MyMod_Item_Test_Regex_Data
            (
                $item,
                $data,
                $messages
            );
            
        $nerrors+=
            $this->MyMod_Item_Test_Compulsory_Data
            (
                $item,
                $data,
                $messages
            );
            
        $nerrors+=
            $this->MyMod_Item_Test_Unique_Data
            (
                $item,
                $data,
                $messages
            );
            

        if (empty($item[ $data."_Message" ]))
        {
            unset($item[ $data."_Message" ]);
        }

        return $nerrors;
    }
}

?>