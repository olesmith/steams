<?php


trait MyMod_Handle_Import_Read
{
    //*
    //* Detetect items in uploaded file.
    //*

    function MyMod_Handle_Import_Read_Items_From_CGI()
    {
        $keys=array_keys($_POST);
        $keys=preg_grep('/_Email$/',$keys);

        $ns=array();
        foreach ($keys as $id => $key)
        {
            $key=preg_replace('/_Email$/',"",$key);
            array_push($ns,$key);
        }

        $items=array();
        foreach ($ns as $n)
        {
            $item=array("No" => $n);            
            foreach ($this->Import_Datas as $data)
            {
                $item[ $data ]=$this->CGI_POST($n."_".$data);
            }
            
            $item=
                $this->MyMod_Handle_Import_Item_Status($item);
            
            array_push($items,$item);
        }

        return $items;
    }

    //*
    //* Detetect items in uploaded file.
    //*

    function MyMod_Handle_Import_Read_Items_From_File()
    {
        $cginame="File";
        $lines=$this->MakeCGI_Upload_File($cginame);
        if (empty($lines)) { return array(); }
        
        $lines=join("",$lines);
        $lines=preg_replace('/},{/',"},\n{",$lines);
       
        $lines=preg_split('/\n/',$lines);

        $items=array();
        foreach ($lines as $id => $line)
        {
            if ( preg_match('/^#/',$line)) { continue; }
            if (!preg_match('/\S/',$line)) { continue; }
            
            $line=preg_replace('/[\[\]"\'{}\n]+/',"",$line);

            $item=
                $this->MyMod_Handle_Import_Read_Item_From_Line($line);

            $this->MyMod_Handle_Import_Item_Status($item);
            $this->MyMod_Handle_Import_Item_Post_Process($item);
            
            array_push($items,$item);
        }

        return $items;
    }

    //*
    //* Detect item from $line.
    //*

    function MyMod_Handle_Import_Read_Item_From_Line($line)
    {
        $comps=preg_split('/\s*[,;]\s*/',$line);
        
        $hash=array();
        $hash[ "No" ]=array_shift($comps);

        $n=0;
        foreach ($this->Import_Datas as $data)
        {
            $hash[ $data ]="";
            if ($n<count($comps))
            {
                $hash[ $data ]=$comps[$n];
            }
            $n++;
        }

        return $hash;
    }
}
?>