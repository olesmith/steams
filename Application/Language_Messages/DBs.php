<?php

class Language_Messages_DBs extends Language_Messages_Handle
{
    //*
    //* function Language_Messages_DB_Insert, Parameter list: 
    //*
    //* 

    function Language_Message_DB_Insert($message_key,&$item,$force=False)
    {
        if ($this->CGI_POSTint("Insert")==1 || $force)
        {
            $res=$this->Sql_Insert_Item($item,"",True);

            return "Adding Message: ".$message_key;
        }

        return "Add omitted: ".$message_key;
    }
    
    //*
    //* function Language_Messages_DB_Update, Parameter list: 
    //*
    //* 

    function Language_Message_DB_UpToDate($message_key,$item,$dbitem)
    {
        $message=$message_key." exists and is uptodate";
        if ($this->CGI_POSTint("Update")!=1)
        {
            $message.=" Update Omitted";
        }
        
        return $message;
    }
    
    //*
    //* function Language_Messages_DB_Update, Parameter list: 
    //*
    //* 

    function Language_Message_DB_Update($message_key,$item,$dbitem,$updatedatas,$force=False)
    {
        if ($this->CGI_POSTint("Update")==1 || $force)
        {
            $item[ "ID" ]=$dbitem[ "ID" ];
            $res=$this->Sql_Update_Item_Values_Set($updatedatas,$item);

            $messages=array();
            foreach ($updatedatas as $data)
            {
                array_push
                (
                    $messages,
                    $data.": ".$item[ $data ]
                );
            }
        
            return
                "Updating Message: ".
                $message_key.
                ", ".
                join($this->BR(),$messages).
                " - ID: ".
                $item[ "ID" ];
        }

        return "Update Omitted: ".$message_key;
    }
    
    //*
    //* 
    //* 

    function Language_Message_DB_Take($fhash,&$item)
    {
        $updatedatas=array();
        $value="";
        foreach (array("Name","Title") as $data)
        {
            if (!empty($fhash[ $data ]))
            {
                $value=$fhash[ $data ];
            }

            //var_dump($data,$value);
            foreach ($this->Language_Keys() as $lang)
            {
                $key=$data."_".$lang;
                if (empty($item[ $key ]))
                {
                   if (!empty($fhash[ $key ]))
                   {
                       $value=$fhash[ $key ];
                   }

                   if (!empty($value))
                   {
                       $item[ $key ]=$value;
                       array_push($updatedatas,$key);
                   }
                }
            }
        }
        
        if (count($updatedatas)>0)
        {
            echo
                "Update Message, ".$item[ "Message_Key" ].": ".
                $this->MyHash_Row_Line($item,$updatedatas);
            
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
            var_dump($updatedatas);
        }
    }
       
}
?>