<?php


trait MyMod_API_CLI_Delete
{
    //*
    //* Handle delete/removal process.
    //*

    function MyMod_API_CLI_Deletes($args)
    {
        $sigaa_ids_file=
            $this->MyMod_API_CLI_Delete_File_Get($args);
        
        $sigaa_ids_db=
            $this->MyMod_API_CLI_Delete_DB_Get($args);

        print
            "Delete items: ".count(array_keys($sigaa_ids_file))." in api, ".
            count($sigaa_ids_db)." in table\n";
        
        $delete_items=array();
        $n=0;
        foreach ($sigaa_ids_db as $sigaa_id_db)
        {
            if (empty($sigaa_ids_file[ $sigaa_id_db ]))
            {
                $delete_items[ $sigaa_id_db ]=
                    $this->Sql_Select_Hash
                    (
                        array($this->SigaZ_Args_Key() => $sigaa_id_db)
                    );
            }
        }
        
        $this->MyMod_API_CLI_Deletes_Show($delete_items);

        print
            join
            (
                "\n",
                $this->MyMod_API_CLI_Deletes_Queries($delete_items)
            ).
            "\n";
    }

    //*
    //* 
    //*

    function MyMod_API_CLI_Deletes_Queries($delete_items)
    {
        $queries=array();
        foreach ($delete_items as $delete_item)
        {
            $queries=
                array_merge
                (
                    $queries,
                    $this->MyMod_API_CLI_Delete_Query($delete_item)
                );
        }

        return $queries;
    }
    
    //*
    //* 
    //*

    function MyMod_API_CLI_Delete_Query($delete_item)
    {
        $queries=
            array
            (
                $this->MyMod_API_CLI_Delete_Query_Lessons($delete_item),
                $this->MyMod_API_CLI_Delete_Query_Slots_Update($delete_item),
                $this->Sql_Delete_Item_Query($delete_item[ "ID" ]).";",
                "",
            );

        return $queries;
    }
    
    //*
    //* 
    //*

    function MyMod_API_CLI_Delete_Query_Lessons($delete_item)
    {
        return
            $this->LessonsObj()->Sql_Delete_Items_Query
            (
                array
                (
                    "Solicitation" => $delete_item[ "ID" ],
                )
            ).";";
    }
    
    //*
    //* 
    //*

    function MyMod_API_CLI_Delete_Query_Slots_Update($delete_item)
    {
        return
            $this->SlotsObj()->Sql_Update_Where_Query
            (
                array
                (
                    "Solicitation" => '0',
                ),
                array
                (
                    "Solicitation" => $delete_item[ "ID" ],
                )
            ).";";
    }
    
    //*
    //* 
    //*

    function MyMod_API_CLI_Deletes_Show($delete_items)
    {
        $line=
            join
            (
                "\t",
                array
                (
                    "----",
                    "------",
                    "--------------------------------",
                    "--------------------------------",
                )
            ).
            "\n";
        
        //var_dump($delete_items);
        print
            count(array_keys($delete_items)).
            " items to delete:\n".
            $line.
            join
            (
                "\t",
                array
                (
                    "N",
                    "ID",
                    $this->SigaZ_Args_Key(),
                    "\t\t\tName"
                )
            ).
            "\n".
            $line;

        $n=0;
        foreach ($delete_items as $delete_item)
        {
            $n++;
            print
                join
                (
                    "\t",
                    array
                    (
                        $n,
                        $delete_item[ "ID" ],
                        $delete_item[ $this->SigaZ_Args_Key() ],
                        $this->Html2Sort($delete_item[ "Name" ])
                    )
                ).
                "\n";
        }

        print $line;
    }
    
    //*
    //* Handle delete/removal process.
    //*

    function MyMod_API_CLI_Delete_DB_Get($args)
    {
        return
            $this->Sql_Select_Unique_Col_Values
            (
                $this->SigaZ_Args_Key()
            );
    }
    
    //*
    //* Handle delete/removal process.
    //*

    function MyMod_API_CLI_Delete_File_Get($args)
    {
        $ids=
            $this->MyFile_Read
            (
                $this->API_CLI_Process_IDs_File()
            );
        
        $sigaa_ids_file=array();
        foreach ($ids as $id)
        {
            $comps=preg_split('/\s+/',$id);
            $id=$comps[0];
            $sigaa_ids_file[ $id ]=True;
        }

        return $sigaa_ids_file;
    }
}

?>