<?php


trait MyMod_Data_Fields_Module_Select
{
    //*
    //* Generates $data object select field.
    //*

    function MyMod_Data_Fields_Module_Select($data,$item,$id="",$ignoredefault=0,$rdata="",$fieldtitle="",$multiple=FALSE)
    {
        //$id not specified and $item $data key set.
        if
            (
                empty($id)
                &&
                !empty($item[ $data ]))
        {
            $id=$item[ $data ];
        }

        $options=
            $this->MyMod_Data_Fields_Module_Options($data,$item);
        

        //Do we have only one item?
        
        if
            (
                !empty($this->ItemData[ $data ][ "Options" ])
                &&
                is_array($this->ItemData[ $data ][ "Options" ])
            )
        {
            if (count($this->ItemData[ $data ][ "Options" ])==1)
            {
                $id=array_pop($this->ItemData[ $data ][ "Options" ]);
                $id=$id[ "ID" ];
            }
        }

        return
            $this->Htmls_DIV
            (
                $this->Htmls_Select_Hashes_Field
                (
                    $rdata,
                    $options,
                    array
                    (
                        "Selected"   => $id,
                        "Empty_Text" => $this->MyMod_Data_EmptyText($data)
                    ),
                    array
                    (
                        "ID" => $this->MyMod_Data_Field_Enum_Classes
                        (
                            $data,$item
                        ),
                        "CLASS" => $this->MyMod_Data_Field_Enum_Classes
                        (
                            $data,$item
                        ),
                    )
                ),
                $this->MyMod_Data_Fields_Module_Select_Options($data,$item)
            );
    }

     //*
    //* Generates $data object select field options.
    //*

    function MyMod_Data_Fields_Module_Select_Options($data)
    {
        $options=array("CLASS" => 'searchdata select');
        if (!empty($this->ItemData[ $data ][ "Size_Max" ]))
        {
            $options[ "STYLE" ]=
                "Max-width: ".$this->ItemData[ $data ][ "Size_Max" ].";";
        }

        if
            (
                !empty($this->ItemData[ $data ][ "Options" ])
                &&
                is_array($this->ItemData[ $data ][ "Options" ])
            )
        {
            $options[ "TITLE" ]=
                count($this->ItemData[ $data ][ "Options" ]).
                " items";
        }
        //else {var_dump("No options $data",$this->ItemData[ $data ]); }

        return $options;
    }

}

?>
