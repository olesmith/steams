<?php


trait MyMod_Items_Row
{
    var $MyMod_Items_Row_Last_Values=array();
    
    //*
    //* Creates items table datas row.
    //* Plural default,as we generate $date => $value row.
    //*

    function MyMod_Items_Table_Row($edit,$n,$item,$datas,$plural=TRUE,$pre="")
    {
        $this->ItemData("ID");
        
        if (!is_array($datas)) { $datas=array($datas); }

        $row=array();
        foreach ($datas as $rdata)
        {
            //Trick to be able to have one level sublists
            if (!is_array($rdata)) { $rdata=array($rdata); }

            foreach ($rdata as $data)
            {
                $cell="";
                if ($data=="No")
                {
                    if (is_array($n))
                    {
                        $cell=$this->Htmls_SPAN($n,array("CLASS" => 'Bold'));
                    }
                    else
                    {
                        $cell=$this->B($n);
                    }
                }
                elseif (!empty($this->ItemData[ $data ]))
                {
                    $access=$this->MyMod_Data_Access($data,$item);

                    $redit=$edit;

                    if ($access<=1) { $redit=0; }
                    
                    if ($access>=1)
                    {
                        $rdata=$pre.$data;

                        $cell="";

                        if (!empty($this->ItemData[ $data ][ "Non_Repeat" ]))
                        {
                            $cell='"';
                        }
                        
                        
                        if
                            (
                                empty($this->MyMod_Items_Row_Last_Values[ $data ])
                                ||
                                empty($this->ItemData[ $data ][ "Non_Repeat" ])
                                ||
                                $this->MyMod_Items_Row_Last_Values[ $data ]
                                !=
                                $item[ $data ]
                            )
                        {
                            $cell=
                                $this->MyMod_Item_Data_Cell
                                (
                                    $redit,$item,$data,
                                    $plural,
                                    $rdata
                                );
                        }

                        if (!empty($item[ $data ]))
                        {
                            $this->MyMod_Items_Row_Last_Values[ $data ]=
                                $item[ $data ];
                        }

                    }
                }
                elseif (!empty($this->Actions[ $data ]))
                {
                    if ($this->Actions[ $data ][ "Singular" ] && empty($item[ "ID" ]))
                    {
                        //do nothing
                    }
                    elseif ($this->MyAction_Access_Has($data))
                    {
                        $cell=$this->MyActions_Entry($data,$item);
                    }
                }
                elseif (!empty($this->CellMethods[ $data ]))
                {
                    $class='data';
                    if ($edit) { $class='editdata'; }
                   
                    $cell=
                        $this->Htmls_Span
                        (
                            $this->$data
                            (
                                $edit,
                                $item,
                                $data
                            ),
                            array("CLASS" => $class)
                        );
                }
                else
                {
                    $cell="no cell type";
                }

                array_push($row,$cell);
            }
        }

        return $row;
    }
}

?>