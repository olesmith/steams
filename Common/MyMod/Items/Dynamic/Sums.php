<?php


trait MyMod_Items_Dynamic_Sums
{
    //*
    //* Adds to row for $items sums.
    //*

    function MyMod_Item_Dynamic_Sums_Rows($items,$group,$checkbox=True)
    {
        return
            array
            (
                $this->MyMod_Item_Dynamic_Sums_Row($items,$group,$checkbox)
            );
    }
    
    //*
    //* Adds to row for $items sums.
    //*

    function MyMod_Item_Dynamic_Sums_Row($items,$group,$checkbox=True)
    {
        $datas=$this->MyMod_Items_Group_Data($group);

        $row=array();

        $firstsum=False;
        foreach ($datas as $data)
        {
            $rfirstsum=$firstsum;
            array_push
            (
                $row,
                $this->MyMod_Item_Dynamic_Sums_Cell($items,$data,$firstsum)
            );

            if (!$rfirstsum && $firstsum)
            {
                $row[ count($row)-2 ]=
                    $this->B($this->ApplicationObj()->Sigma);
            }
        }
        
        $actions=array();
        for ($n=0;$n<$this->MyMod_Item_Dynamic_Title_Menu_N($group);$n++)
        {
            array_push($actions,"");
            
        }

        array_splice
        (
            $row,
            $this->MyMod_Item_Dynamic_Actions_Position($group),
            0,
            $actions
        );

        if ($checkbox)
        {
            array_unshift
            (
                $row,
                ""
            );
        }
        
        return $row;

    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Sums_Cell($items,$data,&$firstsum)
    {
        $cell="";
        if (!empty($this->ItemData($data,"SumVar")))
        {
            $firstsum=True;
            $cell=$this->MyHashes_Key_Sum($items,$data);

            if (!empty($this->ItemData[ $data ][ "Format" ]))
            {
                $cell=
                    sprintf
                    (
                        $this->ItemData[ $data ][ "Format" ],
                        $cell
                    );
            }
            
            $cell=$this->B($cell);
        }

        return $cell;
    }
    
}

?>