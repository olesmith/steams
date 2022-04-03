<?php

trait MyMod_API_CLI_Process_Pages
{
    //*
    //* Process all pages.
    //*

    function API_CLI_Process_Pages($args)
    {
        $pages=
            $this->API_CLI_Process_Pages_Get($args);
        
        $first=$pages[0];
        $last=$pages[1];

        $api_ids=array();
        for ($page=$first;$page<=$last;$page++)
        {
            $api_ids[ $page ]=
                $this->API_CLI_Process_Page
                (
                    $args,$page
                );
        }

        $this->API_CLI_Process_IDs_Write($api_ids);
    }
    
    //*
    //* Detect pages from $args.
    //*

    function API_CLI_Process_Pages_Get($args)
    {
        $first=1;
        $last=$this->API_CLI_Process_Pages_N_Get();

        
        $args=join(" ",$args);
        $args=preg_replace('/.*(Read|Process)\s*/',"",$args);
        $rargs=preg_split('/\s+/',$args);

        if (!empty($args) && count($rargs)>0)
        {
            $pages=preg_split('/-/',$rargs[0]);
            if (count($pages)>1)
            {
                sort($pages,SORT_NUMERIC);
                $first=$pages[0];
                $last=$pages[1];
            }
            else
            {
                $first=$pages[0];
                $last=$pages[0];
            }
        }
        
        return array($first,$last);
    }
    //*
    //* Detect Number of Pages read.
    //*

    function API_CLI_Process_Pages_N_Get()
    {
        $files=
            $this->DirFiles
            (
                $this->SigaA_CLI_File_Path(),
                "\d+\.txt$"
            );

        $npages=1;
        foreach ($files as $file)
        {
            $n=intval(basename($file));
            $npages=max($n,$npages);
        }
        
        return $npages;
    }
    
}

?>