<?php


trait DB_Web_Services_Query
{
    var $JSON_First=array();
    var $JSONs=array();
    
    //*
    //* Prepare and send query.
    //* 
    //* 

    function DB_Web_Services_Query($query,$ignoreerror=FALSE)
    {
        if (empty($this->DBHash("Link")))
        {
            return array();
        }
        
        $hashes=array();
        $npages=-1;

        if ($this->DB_Web_Services_Paging())
        {
            $hashes=
                $this->DB_Web_Services_Paged_Read($query,$npages,$ignoreerror);
        }
        else
        {
           $hashes=$this->DB_Web_Services_Query_UnPaged($query,$ignoreerror);
            $npages=1;
        }

        $this->ApplicationObj()->MyApp_Interface_Message_Add
        (
            "Read,".
            $this->BR().
            $this->DB_Web_Services_Curl_Url($query).":".
            $this->BR().
            count(array_keys($hashes)).
            " (".$npages." pages ".$this->DB_Web_Services_Paging().")."
        );


        return $hashes;
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_Query_JSON($query,$options)
    {
        return
            $this->DB_Web_Services_Query_Curl
            (
                $query,
                $options
            );
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_Query_JSON_2_Hashes($json,$hashes=array())
    {
        $rows_key=$this->DB_Web_Services_Key_Rows();
        if
            (
                isset($json[ $rows_key ])
                &&
                is_array($json[ $rows_key ])
            )
        {
            $hashes=
                array_merge
                (
                    $hashes,
                    $json[ $rows_key ]
                );
        }

        return $hashes;
    }
        
    //*
    //* 
    //* 

    function DB_Web_Services_Query_UnPaged($query,$ignoreerror=FALSE)
    {
        $json=
            $this->DB_Web_Services_Query_Curl
            (
                $query,
                $this->DB_Web_Services_Options_Assoc_List($query,-1)
            );

        return $this->DB_Web_Services_Query_JSON_2_Hashes($json);
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_Query_Number_Of_Items_Read($query)
    {
        //We need to store first result (page)
        if (empty($this->JSON_First))
        {
            $this->JSON_First=
                $this->DB_Web_Services_Query_JSON
                (
                    $query,
                    $this->DB_Web_Services_Options_Assoc_List
                    (
                        $query,
                        $this->SigaZ()->SigaA_Items_Search_Field_Items_PP_Value(),
                        $this->DB_Web_Services_Page_First()
                    )
                );
        }

        $totals_key=$this->DB_Web_Services_Key_Total();

        $ntotal=0;
        if (!empty($this->JSON_First[ $totals_key ]))
        {
            $ntotal=$this->JSON_First[ $totals_key ];
        }

        return $ntotal;

        
    }
}

?>