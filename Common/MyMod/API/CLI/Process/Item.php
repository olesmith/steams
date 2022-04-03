<?php

include_once("Item/Is.php");
include_once("Item/Unique.php");
include_once("Item/Create.php");
include_once("Item/Update.php");


trait MyMod_API_CLI_Process_Item
{
    var $__Item_Key__="SigaZ";

    use
        MyMod_API_CLI_Process_Item_Is,
        MyMod_API_CLI_Process_Item_Unique,
        MyMod_API_CLI_Process_Item_Create,
        MyMod_API_CLI_Process_Item_Update;
    
    //*
    //* Process one $api_item.
    //*

    function API_CLI_Process_Item($api_item)
    {
        $this->API_CLI_Process_Item_Pre($api_item);
        
        if ($this->API_CLI_Process_Item_Is($api_item))
        {
            if (!empty($api_item[ $this->__Item_Key__ ]))
            {
                $old_item=$api_item[ $this->__Item_Key__ ];
                $item=$old_item;
                $updatedatas=
                    $this->API_CLI_Process_Item_Update($api_item,$item);

                if (count($updatedatas)>0)
                {
                    print
                        "Update ".$item[ "ID" ].", ".
                        $item[ "Sigaa_ID" ].":".
                        "\n";

                    foreach ($updatedatas as $data)
                    {
                        print
                            "\t".$data.": ".
                            $old_item[ $data ]." => ".
                            $item[ $data ].":\n";
                    }

                    //var_dump($item);
                    $this->Sql_Update_Item_Values_Set($updatedatas,$item);

                    print
                        $this->Sql_Update_Item_Values_Set_Query($updatedatas,$item).
                        "\n";
                    //exit();

                    /* array_push($updatedatas,"SigaA_ID"); */
                    /* var_dump */
                    /*     ($this->API_CLI_Process_Item_Unique_Where($api_item), */
                    /*         $this->Sql_Select_Hashes */
                    /*         ( */
                    /*             $this->API_CLI_Process_Item_Unique_Where($api_item), */
                    /*             $updatedatas */
                    /*         ) */
                    /*     ); */

                    /* exit(); */

                }
            }
        }
        else
        {
            $item=
                $this->API_CLI_Process_Item_Create($api_item);
        }

        $this->API_CLI_Process_Item_Post($api_item,$item);
    }

    
    //*
    //* Preprocess $api_item.
    //*

    function API_CLI_Process_Item_Pre(&$api_item)
    {
        $method="API_CLI_Pre_Process_Item";
        if (method_exists($this,$method))
        {            
            $this->$method($update=True,$api_item);
        }
    }
    
    //*
    //* Postprocess $api_item.
    //*

    function API_CLI_Process_Item_Post(&$api_item,&$item)
    {
        $method="API_CLI_Post_Process_Item";
        if (method_exists($this,$method))
        {            
            $this->$method($api_item,$item);
        }
    }
    
}

?>