<?php


trait MyMod_Items_Rows
{
    //* 
    //*

    function MyMod_Items_Rows_Form($edit,$setup,$where=array(),$titles="")
    {
        $redit=$edit;

        $key=$setup[ "GET" ];
        $value=$this->CGI_GETint($key);

        if (!empty($value)) { $redit=0; }
        
        return
            $this->Htmls_Form
            (
                $redit,
                "Rows_Form",
                $action="",
                $contents=
                $this->MyMod_Items_Rows_Html
                (
                    $edit,$redit,
                    $setup,$where,$titles
                ),
                $args=array
                (
                ),
                $options=array()
            );

        
    }
    ////javascript:goto('?Unit=1&Event=29&ModuleName=Datas&Action=Delete&DataGroup=1&ID=1','Deletar%20*Dado,%20Question%C3%A1rio%20City%20,%20ID:%201?')
    //*
    //* 
    //*

    function MyMod_Items_Rows_Html($edit,$redit,$setup,$where=array(),$titles="")
    {
        return
            $this->Htmls_Table
            (
                $titles,
                $this->MyMod_Items_Rows_Table($edit,$redit,$setup,$where)
            );

    }
    
    //*
    //* Creates items table datas row.
    //* Plural default,as we generate $date => $value row.
    //*

    function MyMod_Items_Rows_Table($edit,$redit,$setup,$where=array())
    {
        $this->ItemData();
        $this->ItemDataGroups();
        $this->Actions();
        
        $titles=
            $this->MyMod_Items_Rows_Table_Titles($edit,$setup);

        $table=
            array
            (
                array($this->H(3,$this->MyMod_ItemsName())),
                $titles,
            );

        $items=
            $this->MyMod_Items_Table_Rows_Read($edit,$setup,$where);
        
        $n=1;
        foreach ($items as $item)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyMod_Item_Rows
                    (
                        $edit,
                        $setup,
                        $item
                    )
                );

            if
                (
                   $n<count($items)
                   &&
                   $this->MyMod_Item_Rows_Details_Should($setup,$item)
                )
            {
                array_push($table,$titles);
            }
            $n++;
        }

        if ($redit==1)
        {
            array_push
            (
                $table,
                array
                (
                    $this->MyMod_Items_Rows_Buttons($setup)
                ),
                array
                (
                    $this->MyMod_Items_Rows_Hiddens($setup)
                )
            );
        }

        return $table;
    }
    
    //*
    //*
    //*

    function MyMod_Items_Rows_Table_Titles($edit,$setup)
    {
        return
            $this->Htmls_Table_Head_Row
            (
                $this->MyMod_Item_Rows_Titles
                (
                    $edit,
                    $setup,
                    $this->MyMod_Items_Rows_Datas($setup)
                )
            );
    }
    
    //*
    //*
    //*

    function MyMod_Items_Rows_Datas($setup)
    {
        return $this->MyHash_List_Unique($setup[ "Data" ]);
    }
    
    //*
    //*
    //*

    function MyMod_Items_Rows_Datas_Read($setup)
    {
        $datas=$setup[ "Data" ];
        if (!empty($setup[ "SData" ]))
        {
            $datas=array_merge($datas,$setup[ "SData" ]);
        }

        array_unshift($datas,"ID");
        
        return $this->MyHash_List_Unique($datas);
    }
    //*
    //*
    //*

    function MyMod_Items_Table_Rows_Action_Titles($setup)
    {
        return array("&nbsp;");
    }
    
    //*
    //* Creates items table datas row.
    //* Plural default,as we generate $date => $value row.
    //*

    function MyMod_Items_Table_Rows_Read($edit,$setup,$where=array(),$sort="")
    {
        if (empty($sort)) { $sort=$this->Sort; }
        if (!empty($setup[ "Sort" ])) { $sort=$setup[ "Sort" ]; }
        
        $items=
            $this->MyMod_Items_PostProcess
            (
                $this->Sql_Select_Hashes
                (
                    $where,
                    array_merge
                    (
                        array("ID"),
                        $this->MyMod_Items_Rows_Datas_Read($setup)
                    ),
                    $sort
                )
            );

        $this->MyMod_Items_Number($items);

        $hidden=$this->MyMod_Items_Rows_Hidden($setup);
        if ($this->CGI_POSTint($hidden)==1)
        {
            $items=$this->MyMod_Items_Update($items);
        }
        
        return $items;
    }
    //*
    //*

    function MyMod_Items_Rows_Hiddens($setup)
    {
        return
            array
            (                
                $this->Htmls_Hidden($this->MyMod_Items_Rows_Hidden($setup),1),
            );
    }
    //*
    //*

    function MyMod_Items_Rows_Hidden($setup)
    {
        $hidden="";
        if (!empty($setup[ "List_Hidden" ]))
        {
            $hidden=$setup[ "List_Hidden" ];
        }
        
        return $hidden;
    }
    //*
    //*

    function MyMod_Items_Rows_Buttons($setup)
    {
        $buttons=array();
        if (!empty($setup[ "List_Buttons" ]))
        {
            $buttons=$setup[ "List_Buttons" ];
        }

        return $buttons;
    }
    
}

?>