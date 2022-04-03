<?php

trait MyMod_HorMenu_Action
{
    //*
    //* Generates $paction entry.
    //*

    function MyMod_HorMenu_Action($action,$cssclass="",$id="",$item=array(),$title="",$caction="")
    {
        if (empty($caction))  { $caction=$this->MyActions_Detect(); }
        if (empty($cssclass)) { $cssclass="ptablemenu"; }
        if (empty($item))     { $item=$this->ItemHash; }


        $raction=$action;
        $res=$this->MyAction_Allowed($action,$item);

        if (!empty($this->Actions[ $action ][ "AltAction" ]))
        {
            if (!$res || $caction==$action)
            {
                $raction=$this->Actions[ $action ][ "AltAction" ];
            }
        }

        $href="";
        $tag=False;
        if ($res)
        {
            if ($caction!=$action)
            {
                $href=$this->MyActions_Entry($action,$item,1,$cssclass);
                $tag=True;
            }
            elseif (
                      $raction
                      &&
                      $raction!=$action
                      &&
                      $this-> MyAction_Allowed($raction,$item)
                      &&
                      !empty($this->Actions[ $raction ])
                   )
            {
                $href=$this->MyActions_Entry($raction,$item,1,$cssclass);
                $tag=True;
            }
            else
            {
                $name="";
                if (!empty($item))
                {
                    //$name=$this->MyMod_Item_Name_Get();
                    $name=
                        $this->LanguagesObj()->Language_Action_Name_Get
                        (
                            $this,
                            $action,
                            "Name"
                        );
                    $name=preg_replace('/#ID/',$id,$name);
                }
                
                $href=
                    $this->SPAN
                    (
                        $name,
                        array
                        (
                            "CLASS" => 'inactivemenuitem'
                        )
                    );
            }

            if ($tag)
            {
                $href=
                    array
                    (
                        $this->LanguagesObj()->Message_Debug_Pre
                        (
                            $this->LanguagesObj()->Language_Action_Type,
                            $action,
                            array
                            (
                                "Module" => $this->ModuleName,
                            )
                        ),
                        $href
                    );
            }
        }

        return $href;
    }
    
    //*
    //*
    //*

    function MyMod_HorMenu_Action_InActive($action)
    {
        return !$this->MyMod_HorMenu_Action_Active($action);
    }
    
    //*
    //*
    //*

    function MyMod_HorMenu_Action_Active($action)
    {
        $active=False;
        if ($action==$this->MyActions_Detect())
        {
            $active=True;
        }

        return $active;
    }
    
    //*
    //*
    //*

    function MyMod_HorMenu_Action_Get($singular,$action,$id,$item)
    {
        if (empty($caction))  { $caction=$this->MyActions_Detect(); }

        $raction=$action;
        $res=$this->MyAction_Allowed($action,$item);

        if (!$res)
        {
            if (!empty($this->Actions[ $action ][ "AltAction" ]))
            {
                $raction=$this->Actions[ $action ][ "AltAction" ];
            }
        }

        return $raction;
    }
}

?>