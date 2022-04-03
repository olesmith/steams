<?php


trait MyMod_Item_Update_CGI
{
    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_CGI($item=array(),$datas=array(),$prepost="",$postprocess=TRUE,$force=False)
    {
        if (count($item)==0) { $item=$this->ItemHash; }
        if (isset($this->PostProcessed[ $item[ "ID" ] ]))
        {
            unset($this->PostProcessed[ $item[ "ID" ] ]);
        }

        $olditem=$item;
        if (count($datas)==0) { $datas=array_keys($this->ItemData); }

        $rupdate=0;
        $update=0;
        $updatedatas=array(); //datas that are actually updated
        foreach ($datas as $id => $rrdata)
        {
            $rrdatas=$rrdata;
            if (!is_array($rrdata)) { $rrdatas=array($rrdata); }
            
            foreach ($rrdatas as $data)
            {
                $this->MyMod_Item_Update_CGI_Data
                (
                    $item,
                    $data,
                    $prepost,
                    $update,
                    $rupdate,
                    $updatedatas
                );
            }
        }

        $this->FormWasUpdated=FALSE;
        if (count($updatedatas)>0)
        {
            if (method_exists($this,"PostUpdateActions"))
            {
                //function PostUpdateActions($olditem,&$item,&$updatedatas)
                $this->PostUpdateActions($olditem,$item,$updatedatas);
            }
            
            $this->ApplicationObj->LogMessage
            (
               "UpdateItem",
               $item[ "ID" ].": ".
               $this->MyMod_Item_Name_Get($item)
            );

            $this->Sql_Update_Item
            (
                $item,
                array("ID" => $item[ "ID" ]),
                $updatedatas
            );

            
            $item=$this->MyMod_Item_Derived_Data_Read($item);
            $item=$this->SetItemTime("MTime",$item);
            $item=$this->SetItemTime("ATime",$item);

            $rdatanames=array();
            foreach ($updatedatas as $rdata)
            {
                array_push
                (
                    $rdatanames,
                    array
                    (
                        $this->MyMod_Data_Title($rdata),
                        ":",
                        $olditem[ $rdata ],
                        " => ",
                        $item[ $rdata ],
                        //$this->MyMod_Data_Fields_Show($rdata,$item)
                    )
                );
            }

            if (!$this->LatexMode())
            {
                $this->ApplicationObj()->MyApp_Interface_Message_Add
                (
                    $this->B($this->MyLanguage_GetMessage("Altered").": ").
                    $this->Htmls_Text($this->Htmls_List($rdatanames))
                );
            }

            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
               $this->MyLanguage_GetMessage
               (
                  "DataChanged"
               )
            );

            $this->FormWasUpdated=TRUE;
        }
        else
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
               $this->MyLanguage_GetMessage
               (
                  "DataUnchanged"
               )
            );
        }

        if ($this->FormWasUpdated && $postprocess)
        {
            $item=$this->MyMod_Item_PostProcess($item,$force);
        }

        return $item;
    }

    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_CGI_Data(&$item,$data,$prepost,&$update,&$rupdate,&$updatedatas)
    {
        $access=$this->MyMod_Data_Access($data,$item);
        if
            (
                $access<2
                ||
                !empty($item[ $data."_NoUpdate" ])
            )
        {
            //Not allowed to edit - ignore
            return;
        }
        elseif
            (
                preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ])
            )
        {
            //File $data
            $rrdata=$data;
            if (!empty($prepost)) { $rrdata=$prepost.$data; }

            $res=$this->MyMod_Data_Fields_File_Update($data,$item,$rrdata);

            if (is_array($res) && $res[ "__Res__" ])
            {
                $item=$res;
                $rupdate++;
                array_push($updatedatas,$data);

                if ($this->MyMod_Data_Trigger_Function($data))
                { 
                    $item=$this->MyMod_Data_Trigger_Apply($data,$item,$prepost);
                }
                        
                $update++;
            }
        }
        elseif
            (
                empty($this->ItemData[ $data ][ "Derived" ])
                && 
                empty($this->ItemData[ $data ][ "TimeType" ])
            )
        {
            $newvalue=$this->MyMod_Data_Field_Test($data,$item,FALSE,$prepost);

            $default=$this->ItemData($data,"Default");
                   
            if ($default=="0 " || $default==" 0") { $default="0"; }
             
            if (empty($newvalue))// && !empty($default))
            {
                $newvalue=htmlentities($default);
                $newvalue=preg_replace('/\\\\/',"&#92;",$newvalue);
            }

            $oldvalue="";
            if (!empty($item[ $data ])) { $oldvalue=$item[ $data ]; }

            
            if ($this->MyMod_Data_Trigger_Function($data))
            {
                $item=$this->MyMod_Data_Trigger_Apply($data,$item,$prepost);
            }
            else
            {
                $item[ $data ]=$newvalue;
            }

            if (empty($oldvalue) && empty($newvalue)) { return; }
            
            if ($item[ $data ]!=$oldvalue)
            {
                if (!empty($item[ $data ]) || !empty($oldvalue))
                {
                    array_push($updatedatas,$data);
                    $update++;                
                }
            }
        }
    }
}

?>