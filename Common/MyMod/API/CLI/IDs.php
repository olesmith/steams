<?php


trait MyMod_API_CLI_IDs
{
    //*
    //* Read one $page
    //*

    function API_CLI_Process_IDs_Page($page,$sigaa_items)
    {
        $sigaa_key=$this->SigaA_Args_Key();
        $sigaa_name_key=$this->SigaA_Name_Key();

        $sigaa_ids=array();
        foreach ($sigaa_items as $sigaa_item)
        {
            $sigaa_id=$sigaa_item[ $sigaa_key ];
            //print "\t".$sigaa_id."\n";
            
            if (!empty($sigaa_ids[ $sigaa_id ]))
            {
                if (TRUE) //!$this->SigaA_Args("Croak_Doubles"))
                {
                    print
                        "** Double SIGAA ID ".
                        $sigaa_id.
                        ": ".
                        $sigaa_item[ $sigaa_name_key ].
                        "\n";
                }
            }
            else
            {
                $sigaa_ids[ $sigaa_id ]=0;
            }
            
            $sigaa_ids[ $sigaa_id ]++;
        }

        
        $this->API_CLI_Process_IDs_Page_Write
        (
            $page,$sigaa_items,$sigaa_ids
        );


        return $sigaa_ids;
    }

    
    //*
    //* Write all API ids to one big file.
    //*

    function API_CLI_Process_IDs_Write($api_ids)
    {
        $lines=array();
        foreach ($api_ids as $page => $page_api_ids)
        {
            foreach ($page_api_ids as $page_api_id => $api_count)
            {
                array_push
                (
                    $lines,
                    join
                    (
                        "\t",
                        array($page_api_id,$page,$api_count)
                    )
                );
            }
        }
        
        $this->MyFile_Write
        (
            $this->API_CLI_Process_IDs_File($page),
            $lines
        );
    }
    
    //*
    //* Name of API ids file
    //*

    function API_CLI_Process_IDs_File()
    {
        return
            $this->SigaA_CLI_File_Path().
            "/".
            "IDs.txt";
    }
    
    //*
    //* Write one page to API ids file.
    //*

    function API_CLI_Process_IDs_Page_Write($page,$sigaa_items,$api_ids)
    {
        $lines=array();
        foreach ($api_ids as $api_id => $api_count)
        {
            array_push
            (
                $lines,
                join
                (
                    "\t",
                    array($api_id,$api_count)
                )
            );
        }
        
        $this->MyFile_Write
        (
            $this->API_CLI_Process_IDs_Page_File($page),
            $lines
        );
    }
    
    //*
    //*
    //* Name of API ids file.
    //*

    function API_CLI_Process_IDs_Page_File($page)
    {
        return
            $this->SigaA_CLI_File_Path().
            "/".
            $page.
            ".IDs.txt";
    }
    
}

?>