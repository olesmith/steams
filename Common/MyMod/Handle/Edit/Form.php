<?php

trait MyMod_Handle_Edit_Form
{
    //*
    //* Creates form for editing an item. If $_POST[ "Update" ]==1,
    //* calls Update.
    //*

    function MyMod_Handle_Edit_Form($title,$item=array(),$edit=0,$noupdate=FALSE,$datas=array(),$echo=TRUE,$extrarows=array(),$formurl=NULL,$buttons="",$cgiupdatevar="Update")
    {
        if (empty($buttons))
        {
            $buttons=$this->Htmls_Buttons();

        }
        
        if (empty($item)) { $item=$this->ItemHash; }

        if
            (
                $this->CGI_POSTint($cgiupdatevar)==1
                &&
                $edit==1
                &&
                !$noupdate
            )
        {
            $item=
                $this->MyMod_Item_Update_CGI
                (
                    $this->MyMod_Item_Test($item)
                );
        }

        $this->AllDatas=array();
        foreach ($this->AllDatas as $data)
        {
            if ($this->MyMod_Data_Access($data,$item)>0)
            {
                $this->AllDatas[ $data ]=TRUE;
            }
        }

        $action="Show";
        if ($edit==1) { $action="Edit"; }
        
        $html=
            $this->Htmls_DIV
            (
                $this->Htmls_Form
                (
                    $edit,
                    
                    $this->ModuleName."_Edit_".
                    $this->MyMod_Handle_Show_SGroup_CGI(),

                    
                    $action,
                    
                    //$contents=
                    $this->MyMod_Handle_Edit_Htmls
                    (
                        $title,$edit,$item,$datas,$extrarows
                    ),
                    
                    //$args=
                    array
                    (
                        "Suppress" => $this->MyMod_Handle_Edit_Form_Suppress(),
                        "Hiddens"  => $this->MyMod_Handle_Edit_Form_Hiddens
                        (
                            $item,$cgiupdatevar
                        ),
                        "Buttons"  => $buttons,
                        "Clear_Group" => "GroupMenu",
                    )//,
                    
                    //$options=array()
                ),
                #DIV options
                array("ALIGN" => 'center')
            );

        if ($echo)
        {
            $this->Htmls_Echo($html);
            return "";
        }
        
        return $html;
    }
    
    //*
    //* Returns the edit form hidden fields.
    //*

    function MyMod_Handle_Edit_Form_Hiddens($item,$cgiupdatevar)
    {
        $hiddens=array();

        $hiddens[ $cgiupdatevar ]=1;        
        if ($this->IDAsHidden)
        {
            $hiddens[ "ID" ]=$item[ "ID" ];
        }

        return $hiddens;
    }
    
    //*
    //* Returns list of cgi vars to suppress.
    //*

    function MyMod_Handle_Edit_Form_Suppress()
    {
        $suppresscgis=
            array_merge
            (
                $this->NonPostVars,
                $this->NonGetVars
            );
            
        $action=$this->MyActions_Detect();
        if (!empty($action))
        {
            foreach (array("NonGetVars","NonPostVars") as $type)
            {
                $vars=$this->Actions($action,"NonGetVars");
                if (!empty($vars))
                {
                    $suppresscgis=array_merge($suppresscgis,$vars);
                }
            }
        }

        return $suppresscgis;
    }
    
    
}

?>