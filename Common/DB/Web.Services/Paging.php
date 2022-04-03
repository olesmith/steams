<?php


trait DB_Web_Services_Paging
{
    //* Name of json/uri field containg item per page.
    //* 

    function DB_Web_Services_Page_First()
    {
        $this->SigaZ()->SigaA_Args();
        
        $first=0;
        if (!empty($this->SigaZ()->SigaA_Args[ "Siga_API_Paging_First" ]))
        {
            $first=$this->SigaZ()->SigaA_Args[ "Siga_API_Paging_First" ];
        }

        return $first;
    }
    
    //* Name of json/uri field containg item per page.
    //* 

    function DB_Web_Services_Page_Last($query)
    {
        $last=
            $this->DB_Web_Services_Page_First()
            +
            $this->DB_Web_Services_NPages_Get($query);
        
        return $last;
    }
    
    //* Name of json/uri field containg item per page.
    //* 

    function DB_Web_Services_Paging()
    {
        return $this->SigaZ()->SigaA_Args("Siga_API_Paging");
    }
    
    //* 
    //* Name of json/uri field containg page limit.
    //* 

    function DB_Web_Services_Page_Limit()
    {
        return $this->SigaZ()->SigaA_Items_Search_Field_Items_PP_Value();
    }
        
    
    //*
    //* 
    //* 

    function DB_Web_Services_Paged_Read($query,&$npages,$ignoreerror=FALSE)
    {
        #items per page
        $ipp=$this->SigaZ()->SigaA_Items_Search_Field_Items_PP_Value();

        $npages=
            $this->DB_Web_Services_NPages_Get($query,$ignoreerror);

        $current_page=
            $this->SigaZ()->SigaA_Items_Search_Field_Page_Value();

        
        $json=$this->JSON_First;

        $hashes=array();
        for ($page=1;$page<=$npages;$page++)
        {
            if ($current_page!=0 && $current_page!=$page) { continue; }

            $hashes=
                array_merge
                (
                    $this->DB_Web_Services_Page_Read($query,$page)
                );
        }
        
        $this->JSON_First=array();
        return $hashes;
    }

    var $NItems_Read=0;
    
    //*
    //* 
    //* 

    function DB_Web_Services_Page_Read($query,$page)
    {
        $first_page=$this->DB_Web_Services_Page_First();
        $ipp=$this->SigaZ()->SigaA_Items_Search_Field_Items_PP_Value();

        //$this->DB_Web_Services_ReConnect(100);
                
        $json=array();
        if ($page==$first_page || empty($this->JSON_First))
        {
            $json=$this->JSON_First;
        }
        else
        {
            $json=
                $this->DB_Web_Services_Query_Curl
                (
                    $query,
                    $this->DB_Web_Services_Options_Assoc_List
                    (
                        $query,
                        $ipp,
                        $page
                    )
                );
        }

        
        $rows_key=$this->DB_Web_Services_Key_Rows();
        $name_key=$this->SigaZ()->SigaA_Args[ "SigaA_Name_Key" ];
        

        $this->NItems_Read=0;
        if (!empty($json[ $rows_key ]))
        {
            $this->NItems_Read=count($json[ $rows_key ]);
        }
        
        $hashes=array();
        if
            (
                isset($json[ $rows_key ])
                &&
                is_array($json[ $rows_key ])
            )
        {
            return $json[ $rows_key ];
        }
        else
        {
            return False;
        }

        return $hashes;
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_NPages_Get($query,$ignoreerror=FALSE)
    {
        $ntotal=
            $this->DB_Web_Services_Query_Number_Of_Items_Read($query);

        #items per page
        $ipp=$this->DB_Web_Services_Page_Limit();

        $npages=1;
        if ($ipp>0)
        {
            $npages=intval($ntotal/$ipp);

            if ($npages*$ipp<$ntotal)
            {
                $npages++;
            }
        }

        return $npages;
    }
 }

?>