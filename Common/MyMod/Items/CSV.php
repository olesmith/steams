<?php


trait MyMod_Items_CSV
{
    //*
    //* Creates CSV table with datas in the columns, one for each item in $item.
    //* If $datas is the empty list, retrieves $datas from actual data group.
    //*

    function MyMod_Items_CSV_Table($items=array(),$datas=array(),$titles=array())
    {
        $this->ApplicationObj()->SetLatexMode();

        if (count($items)==0)     { $items=$this->ItemHashes; }
        if (count($datas)==0)
        {
            $group=$this->MyMod_Data_Group_Actual_Get();
            $datas=$this->MyMod_Data_Group_Datas_Get($group);
            if (is_array($this->ItemDataGroups[ $group ][ "TitleData"]))
            {
                $titles=$this->ItemDataGroups[ $group ][ "TitleData"];
                $datas=$this->ItemDataGroups[ $group ][ "Data"];
            }
            else
            {
                $titles=$this->MyMod_Data_Titles($datas,1);
            }
        }

        $rdatas=array();
        $rtitles=array();
        for ($n=0;$n<count($titles);$n++)
        {
            $data=$datas[$n];
            if (
                !isset($this->Actions[ $data ])
                &&
                $datas[$n]!="No"
               )
            {
                array_push($rdatas,$data);
                $titles[$n]=$this->Html2Text($titles[$n]);
                $titles[$n]=preg_replace('/;/',",",$titles[$n]);
                array_push($rtitles,$titles[$n]);
            }
        }


    
        $tbl=array();
        $nn=1;
        foreach ($items as $item)
        {
            $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE);
            $item=$this->MyMod_Item_Latex_Trim($item);

            $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]);
            $nn=sprintf("%03d",$nn);

            $rows=array();

            $count=1;
            $number=1;
            $row=array($nn);
            foreach ($rdatas as $data)
            {
                $value="";
                if (!empty($item[ $data ]))
                {
                    $value=$item[ $data ];
                }
                elseif (method_exists($this,$data))
                {
                    $value=
                        $this->$data(0,$item,$data);
                }
                
                
                if (!preg_match('/\S/',$value)) { $value=""; }

                $value=$this->Html2Text($value);
                $value=preg_replace('/;/',",",$value);

                
                array_push($row,$value);
            }

            array_push($tbl,$row);
            $nn++;
        }

        array_unshift($rtitles,'No');
        $text=join(";",$rtitles)."\n";
        foreach ($tbl as $id => $row)
        {
            $text.=join(";",$row)."\n";
        }

        $this->MyMod_Doc_Header_Send
        (
            "csv",
            $this->ModuleName.".".$this->MTime2FName().".csv",
            "utf-8"
        );
        
        echo $text;        
        exit();
    }
}

?>