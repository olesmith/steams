<?php


trait DB_Web_Services_Where
{
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Where_Assoc_List($query=array(),$limit=-1,$page=1)
    {
        if (is_string($query))
        {
            $comps=preg_split('/\s*AND\s*/',$query);

            $query=array();
            foreach ($comps as $comp)
            {
                if (preg_match('/=/',$comp))
                {
                    $comp=preg_split('/=/',$comp);
                    $query[ $comp[0] ]=$comp[1];
                }
            }
        }
        
        $query[ $this->DB_Web_Services_Key_Items_PP() ]=
            $this->SigaZ()->SigaA_Items_Search_Field_Items_PP_Value();
        
        $query[ $this->DB_Web_Services_Key_Page() ]=
            $this->SigaZ()->SigaA_Items_Search_Field_Page_Value($page);


        $query=$this->SigaZ()->SigaA_Args_Where($query);

        return $query;
    }
    
}

?>