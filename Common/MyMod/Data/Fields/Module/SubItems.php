<?php


trait MyMod_Data_Fields_Module_SubItems
{
    //*
    //* Creates sql object show field.
    //*

    function MyMod_Data_Fields_Module_SubItem_Get($data,$item)
    {
        $value=$item[ $data ];
        if (empty($this->ItemData[ $data ][ "Items" ][ $value ]))
        {
            $subitem=
                $this->MyMod_Data_Fields_Module_SubItems_Read
                (
                    $data,$item,
                    array($value)
                );
            $this->ItemData[ $data ][ "Items" ][ $value ]=
                array_pop($subitem);
        }

        return $this->ItemData[ $data ][ "Items" ][ $value ];
    }
    //*
    //* Converts $subitems to ID =>, Name =>, Title => hash, according to
    //* Filters according to MyMod_Data_Fields_Module_Filter function.
    //*

    function MyMod_Data_Fields_Module_SubItems_2Options($data,$subitems)
    {
        $filter=$this->MyMod_Data_Fields_Module_Filter($data);
        $titlefilter=$this->MyMod_Data_Fields_Module_Filter($data,TRUE);
        
        $options=array();
        foreach (array_keys($subitems) as $id)
        {
            $subitems[ $id ]=
                $this->Module2Object($data)->MyMod_Data_Fields_Enums_ApplyAll
                (
                    $subitems[ $id ],
                    $latex=False,
                    $this->MyMod_Data_Fields_Module_Datas($data)
                );
            $rid=$subitems[ $id ][ "ID" ];

            $options[ $rid ]=array
            (
               "ID" => $rid,
               "Name" => $this->Filter($filter,$subitems[ $id ])
            );

                        
        
            if (!empty($titlefilter))
            {
                $title=$this->Filter($titlefilter,$subitems[ $id ]);
                if (!empty($title))
                {
                    $options[ $rid ][ "Title" ]=$title;
                }
            }
        }

        return $options;
    }


    //*
    //* 
    //*

    function MyMod_Data_Fields_Module_SubItems_Sort($data)
    {
       $subobject=$this->Module2Object($data);
       $sort=$subobject->Sort;

       if (is_array($sort))
       {
           $sort=join(",",$sort);
       }

       return $sort;
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Fields_Module_SubItems_Read($data,$item,$ids)
    {
        $subobject=$this->Module2Object($data);

        $subitems=array();
        if (!empty($ids))
        {
            $subitems=
                $subobject->Sql_Select_Hashes
                (
                    $subobject->MyMod_SqlWhere
                    (
                        array("ID" => $ids)
                    ),
                    $this->MyMod_Data_Fields_Module_Datas($data),
                    $this->MyMod_Data_Fields_Module_SubItems_Sort($data)
                );
        }

        return
            $this->MyMod_Data_Fields_Module_SubItems_2Options
            (
                $data,$subitems
            );
    }
}

?>
