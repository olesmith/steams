<?php

class Language_Messages_Types_Update extends Language_Messages_Types_Html
{    
    //*
    //* function Language_Message_Types_Update, Parameter list: 
    //*
    //* 

    function Language_Message_Types_Update()
    {
        $output=array();
        if ($this->CGI_POSTint("Run")==1)
        {
            foreach ($this->Language_Messages_Types_Get() as $type => $hash)
            {
                if ($this->CGI_POSTint($type)==1 || $this->CGI_POSTint("All")==1)
                {
                    if (!empty($hash[ "Method" ]))
                    {
                        $this->NItems=0;
                        $this->NAdded=0;
                        $this->Updated=0;
        
                        $method=$this->Language_Message_Type_Update_Method($hash);
                        array_push($output,$this->$method());
                    }
                }
            }
        }

        if (isset($_FILES[ "File" ]) && is_array($_FILES[ "File" ]))
        {
            $file=$_FILES[ "File" ][ 'tmp_name' ];

            if (!empty($file) && file_exists($file))
            {
                foreach ($this->ReadPHPArray($file) as $item)
                {
                    $ritem=
                        $this->Sql_Select_Hash
                        (
                            array
                            (
                                "Message_Key" =>  $item[ "Message_Key" ],
                                "Message_Type" => $item[ "Message_Type" ],
                                "N" => $item[ "N" ],
                            )
                        );

                    foreach (array("ID",) as $data)
                    {
                        if (!empty($item[ $data ]))
                        {
                            unset($item[ $data ]);
                        }                        
                    }
                    
                    if (empty($ritem))
                    {
                        $this->Sql_Insert_Item($item);
                        var_dump("Item '".$item[ "Message_Key" ]."' Added");
                    }
                }
                
            }
        }
        
        return $output;
    }
     
    //*
    //* function Language_Message_Type_Method, Parameter list: 
    //*
    //* 

    function Language_Message_Type_Update_Method($hash)
    {
        return "Language_".$hash[ "Method" ]."_Update";
    }
}
?>