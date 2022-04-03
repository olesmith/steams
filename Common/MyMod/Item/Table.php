<?php


trait MyMod_Item_Table
{
    var $MyMod_Item_Table_Data_Edit_Control=array();
    var $MyMod_Item_Table_Edit_Data=array();

    
    //*
    //* Sets Item_Data_Edit_Control var to array, if un defined for $item.
    //*

    function MyMod_Item_Table_Edit_Control_Set($item,$data)
    {
        if (is_array($data))
        {
            foreach ($data as $rdata)
            {
                $this->MyMod_Item_Table_Edit_Control_Set($item,$rdata);                
            }

            return;
        }
        
        if (!empty($item[ "ID" ] ))
        {
            if (empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ]))
            {
                $this->MyMod_Item_Table_Data_Edit_Control[ $item[ "ID" ] ]=array();
            }

            $this->MyMod_Item_Table_Data_Edit_Control[ $item[ "ID" ] ][ $data ]=True;
        }
    }
    
    //*
    //* Sets Item_Data_Edit_Control var to array, if un defined for $item.
    //*

    function MyMod_Item_Table_Edit($item,$edit,$data)
    {
        if
            (
                !empty($item[ "ID" ] )
                &&
                !empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ])
                &&
                !empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ][ $data ])
            )
        {
            $edit=0;
        }

        return $edit;
    }
    
    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function MyMod_Item_Table($edit,$item,$datas,$plural=FALSE,$includename=FALSE,$includecompulsorymsg=FALSE,$nodatatitles=False)
    {
        if (count($item)>0) {} else { $item=$this->ItemHash; }

        $table=array();

        $included=array();
        $compulsories=0;
        $ncols=0;
        foreach ($datas as $data)
        {
            if (is_string($data))
            {
                if (!empty($included[ $data ])) { continue; }
                $included[ $data ]=True;
            }
            
            $redit=$this->MyMod_Item_Table_Edit($item,$edit,$data);
            
            $row=
                $this->MyMod_Item_Table_Row($redit,$item,$data,$plural,$nodatatitles);

            if (count($row)>0) { array_push($table,$row); }
            
            $this->MyMod_Item_Table_Edit_Control_Set($item,$data);
            $ncols=$this->Max($ncols,count($row));

            if
                (
                    !is_array($data)
                    &&
                    !empty($this->ItemData[ $data ][ "Compulsory" ])
                    &&
                    empty($item[ $data ])
                )
            {
                $compulsories+=1;
            }
        }

        if ($includename)
        {
            array_unshift
            (
               $table,
               array
               (
                  $this->MultiCell
                  (
                     $this->MyMod_Item_Anchor($item).
                     $this->H(5,$this->MyMod_Item_Name_Get($item)),
                     $ncols
                  )
               )
            );
        }
        
        if ($includecompulsorymsg && $compulsories>0 && $edit==1)
        {
            array_push
            (
               $table,
               array
               (
                  $this->Htmls_Table_Multi_Cell
                  (
                     $this->MyMod_Data_Compulsory_Message(),
                     $ncols
                  )
               )
             );
        }

        return $table;
    }
    
    //*
    //* Creates item table, calling ItemTableRow for each var.
    //* Allows to prepend $precgikey to all var names.
    //*

    function MyMod_Item_Table_PreKey
        (
            $edit=0,$item=array(),$noid=FALSE,$rdatalist=NULL,$tbl=array(),
            $plural=FALSE,$includename=TRUE,$includecompulsorymsg=TRUE,$precgikey=""
        )
    {
        if (empty($item))
        {
            $item=$this->ItemHash;
        }
        
        $item=$this->MyMod_Item_Test($item);

        $datalist=array_keys($this->ItemData);
        $datalist=preg_grep('/^[AMC]Time$/',$datalist,PREG_GREP_INVERT);
        if
            (
                count($rdatalist)==0
                &&
                count($this->MyMod_Item_Table_Edit_Data)>0
            )
        {
            $rdatalist=$this->MyMod_Item_Table_Edit_Data;
        }

        if (!is_array($rdatalist))
        {
            $rdatalist=$datalist;
        }

        if ($noid)
        {
            $rdatalist=preg_grep('/^ID$/',$rdatalist,PREG_GREP_INVERT);
        }

        if ($includename)
        {
            array_push
            (
               $tbl,
               array
               (
                   $this->MultiCell
                   (
                       $this->MyMod_Item_Anchor($item).
                       $this->H(5,$this->MyMod_Item_Name_Get($item)),
                       2
                   )
               )
            );
        }

        if
            (
                !empty($item[ "ID" ] )
                &&
                empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ])
            )
        {
            $this->Item_Data_Edit_Control[ $item[ "ID" ] ]=array();
        }

        $compulsories=0;
        foreach ($rdatalist as $data)
        {
            $redit=$this->MyMod_Item_Table_Edit($item,$edit,$data);

            $hidden=FALSE;
            if
                (
                    isset($this->ItemData[ $data ][ "Hidden" ])
                    &&
                    $this->ItemData[ $data ][ "Hidden" ]
                )
            {
                $hidden=TRUE;
            }

            $this->MyMod_Item_Table_Edit_Control_Set($item,$data);
            if
                (
                    !$hidden
                    &&
                    $data!="No"
                    &&
                    isset($this->ItemData[ $data ])
                )
            {
                $row=
                    $this->MyMod_Item_PreKey_Row
                    (
                        $redit,$item,$data,
                        $compulsories,array(),$plural,
                        $precgikey
                    );

                
                
                if (count($row)>0)
                {
                    array_push($tbl,$row);
                }
            }
            elseif (isset($this->Actions[ $data ]))
            {
                $row=array
                (
                   $this->DecorateDataTitle
                   (
                      $this->GetRealNameKey($this->Actions[ $data ]).":"
                   ),
                   $this->MyActions_Entry($data,$item)
                );
                
                if (count($row)>0) { array_push($tbl,$row); }
            }
            elseif (method_exists($this,$data))
            {
                $class='data';
                if ($edit) { $class='editdata'; }
                           
                array_push
                (
                    $tbl,
                    array
                    (
                        $this->Span
                        (
                            $this->$data(),
                            array("CLASS" => 'datatitlelink')
                        ),
                        $this->Span
                        (
                            $this->$data($item),
                            array("CLASS" => $class)
                        )
                    )
                );
            }

        }

        if ($includecompulsorymsg && $compulsories>0 && $edit==1)
        {
            array_push
            (
               $tbl,
               array
               (
                  $this->MyMod_Data_Compulsory_Message()
               )
             );
        }

        return $tbl;
    }
}

?>