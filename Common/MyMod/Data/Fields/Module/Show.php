<?php


trait MyMod_Data_Fields_Module_Show
{
    //*
    //* Creates sql object show field.
    //*

    function MyMod_Data_Fields_Module_Show($data,$item,$value="",$plural=FALSE)
    {
        if (empty($value) && !empty($item[ $data ])) { $value=$item[ $data ]; }

        $empty="";//???$this->MyMod_Data_Enum_Empty_Name($data);
        $emptytext="";
        if (!empty($empty)) { $emptytext=$empty; }

        $origvalue=$value;
        if (!empty($value))
        {
            if (empty($this->ItemData[ $data ][ "Items" ]))
            {
                $this->ItemData[ $data ][ "Items" ]=array();
            }

            if (empty($this->ItemData[ $data ][ "Items" ][ $value ]))
            {
                $subitem=$this->MyMod_Data_Fields_Module_SubItems_Read($data,$item,array($value));
                $this->ItemData[ $data ][ "Items" ][ $origvalue ]=array_pop($subitem);
            }

            $value=$this->ItemData[ $data ][ "Items" ][ $origvalue ][ "Name" ];
            /* if (!empty($this->ItemData[ $data ][ "Items" ][ $origvalue ][ "Title" ])) */
            /* { */
            /*     $value=$this->Htmls_Span */
            /*     ( */
            /*        $value, */
            /*        array */
            /*        ( */
            /*           "TITLE" => $this->ItemData[ $data ][ "Items" ][ $origvalue ][ "Title" ], */
            /*        ) */
            /*     ); */
            /* } */
        }
        else { $value=$this->MyMod_Data_EmptyText($data); }

        $href=$this->ItemData[ $data ][ "HRef" ];
        if (!empty($item[ $data ]) && !empty($href))
        {
            $args=$this->CGI_URI2Hash();
            $args=$this->CGI_URI2Hash($href,$args);
            $href=$this->CGI_Hash2URI($args);

            $href=$this->Filter($href,$item);
            $value=$this->Href("?".$href,$value);
        }

        return $value;
    }
}

?>
