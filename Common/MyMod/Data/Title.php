<?php

trait MyMod_Data_Title
{
    //*
    //* Generates title rows based on $datas.
    //*

    function MyMod_Data_Titles_Row($datas)
    {
        return array
        (
           array
           (
              "TitleRow" => TRUE,
              "Class" => 'head',
              "Row" => $this->MyMod_Data_Titles($datas)
           ),
        );
    }

    function MyMod_Data_Titles($datas,$nohtml=0,$options=array())
    {
        $titles=array();
        foreach (array_keys($datas) as $n)
        {
            $titles[$n]=
                $this->MyMod_Data_Title($datas[$n],$nohtml,True,$options);
        }

        return $titles;
    }


    function MyMod_Data_Title($data,$nohtml=False,$plural=False,$options=array())
    {
        $this->ItemData();
        
        if (is_array($data)) { $data=array_shift($data); }

        $title="";
        if ($data=="No")
        {
            $title="No";
        }
        elseif (preg_match('/^text_/',$data))
        {
            return "";
        }
        elseif (isset($this->ItemData[ $data ]))
        {
            if (!empty($this->ItemData[ $data ][ "Name" ]))
            {
                return $this->ItemData[ $data ][ "Name" ];
            }
            else
            {
                $itemdata=$this->ItemData[ $data ];
                $title=
                    $this->LanguagesObj()->Language_Data_Name_Get($this,$data);
                
                if
                    (
                        !$this->LatexMode()
                        &&
                        !$nohtml
                    )
                {
                    $title=
                        $this->SPAN
                        (
                            $title,
                            array_merge
                            (
                                $options,
                                array
                                (
                                    "TITLE" =>  $this->LanguagesObj()->Language_Data_Title_Get
                                    (
                                        $this,$data
                                    ),
                                    "CLASS" => 'datatitle '.$data,
                                )
                            )
                        );
                }
            }
        }
        elseif (isset($this->Actions[ $data ]))
        {
            $action=$this->Actions[ $data ];
            return "";
        }
        elseif (method_exists($this,$data))
        {
            if (empty( $this->CellMethods[ $data ]))
            {
                $msg=$this->ModuleName." ".$data." is method, but not in CellMethods!";
                print $msg;
                $this->ApplicationObj()->MyApp_Interface_Message_Add($msg);
            }
            else
            {
                $title=$this->$data(0,array(),$data,$plural);
                //if (is_array($title)) { $title=""; }
            }
        }
        else
        {
            $comps=preg_split('/_/',$data);
            if (count($comps)>1)
            {
                $pridata=array_shift($comps);
                $secdata=join("_",$comps);

                if
                    (
                        isset($this->ItemData[ $pridata ])
                        &&
                        is_array($this->ItemData[ $pridata ])
                    )
                {
                    if
                        (
                            !empty($this->ItemData[ $pridata ][ "SqlObject" ])
                        )
                    {
                        $object=$this->ItemData[ $pridata ][ "SqlObject" ];
                        $title=
                            $this->MyMod_Data_Title($pridata,$nohtml).", ".
                            $this->$object->MyMod_Data_Title($secdata,$nohtml);
                    }
                }
            }
        }
            

        return $title;
    }
}

?>