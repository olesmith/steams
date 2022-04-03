<?php


trait MyMod_Search_Options_Edit
{    
    var $MyMod_Search_Options_Edit_Key="Go_Edit";
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Edit_Row($omitvars)
    {
        if (!$this->MyMod_Search_Options_Edit_Should($omitvars))
        {
            return array();
        }
        
        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyLanguage_GetMessage
                  (
                      $this->MyMod_Search_Options_Edit_Key
                  ).":",
                  array("CLASS" => 'searchtitle')
              ),
              $this->MyMod_Search_Options_Edit_Cell(),
           );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Edit_Cell()
    {
        $field=$this->MyMod_Search_Options_Edit_Field();
        
        $disabled=False;
        if ($this->CGI_GET("Action")=="EditList")
        {
            $disabled=True;
        }
        
        return
            $this->MakeCheckBox
              (
                  $field,
                  1,
                  $this->CGI_GETOrPOST($field),
                  $disabled
              );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Edit_Field()
    {
        return $this->ModuleName."_".$this->MyMod_Search_Options_Edit_Key;
    }
    
    //*
    //* Value to set for Details hide field.
    //*

    function MyMod_Search_Options_Details_Edit_Value()
    {
        return
            $this->CGI_POSTint(   $this->MyMod_Search_Options_Edit_Field()   );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Edit_Should($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("EditList",$omitvars))
        {
            return False;
        }
        
        return $this->MyAction_Allowed("EditList");
    }
}

?>