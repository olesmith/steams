<?php


trait MyMod_Data_Fields_Module_Options
{
    //*
    //* function MyMod_Data_Object_Module_Options, Parameter list: $data,$item
    //*
    //* Generates $data object data select field (not search).
    //*

    function MyMod_Data_Fields_Module_Options($data,$item)
    {
        $subobject=$this->MyMod_Data_Fields_Module_2Object($data);

        $subobject->IncludeAll=TRUE;

        if (!empty($this->ItemData[ $data ][ "Compound" ]))
        {
            $data=$this->ItemData[ $data ][ "Compound" ];
        }

        if (empty($this->ItemData[ $data ][ "Options" ]))
        {
            $ids=$subobject->Sql_Select_Unique_Col_Values
            (
               "ID",
               $this->MyMod_Data_Fields_Module_SqlWhere($data,$item),
               $this->ItemData($data,"SqlGroupBy"),
               $this->ItemData($data,"SqlOrderBy")
           );
 
           $options=
                $this->MyMod_Data_Fields_Module_SubItems_Read($data,$item,$ids);

           $soptions=array();
           foreach ($options as $option)
           {
               $soptions
               [
                   strtolower($this->Html2Sort($option[ "Name" ])).
                   sprintf("%06d",$option[ "ID" ])
               ]=$option;
           }

           $keys=array_keys($soptions);
           sort($keys);
            
           $this->ItemData[ $data ][ "Options" ]=array();
           foreach ($keys as $key)
           {
               array_push($this->ItemData[ $data ][ "Options" ],$soptions[ $key ]);
           }
        }

         if (!empty($this->ItemData[ $data ][ "SqlSelectReverse" ]))
         {
             $this->ItemData[ $data ][ "Options" ]=
                 array_reverse($this->ItemData[ $data ][ "Options" ]);
         }

        return $this->ItemData[ $data ][ "Options" ];
    }
}

?>
