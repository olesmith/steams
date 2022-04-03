<?php

trait MyMod_Handle_Email_Read
{
    var $MyMod_Handle_Emails_Warning=array();
    
    //*
    //* function MyMod_Handle_Emails_Read, Parameter list: $rwhere,$friendkeys=array("Friend")
    //*
    //* Reads emails.
    //*

    function MyMod_Handle_Emails_Read($rwhere,$friendkeys=array("Friend"))
    {
        if (!is_array($friendkeys)) { $friendkeys=array($friendkeys); }

        $this->NoPaging=TRUE;
        $this->MyMod_Handle_Emails_Warning=array();

        //Array keeping track of included ids. Avoids multiple entries.
        $ids=array();
        $emails=array();        

        foreach ($friendkeys as $friendkey)
        {
            $emails[ $friendkey ]=array();
        }

        
        foreach ($this->MyMod_Handle_Emails_Read_Items($rwhere,$friendkeys) as $friend)
        {
            foreach ($friendkeys as $friendkey)
            {
                //Avoid repeated entries.
                if (!empty($ids[ $friend[ $friendkey ] ]))
                {
                    continue;
                }

                
                $rfriend=
                    $this->UsersObj()->Sql_Select_Hash
                    (
                        array("ID" => $friend[ $friendkey ]),
                        array("ID","Email","Name")
                    );

                if (!empty($rfriend[ "Email" ]) && preg_match('/^\S+\@\S+$/',$rfriend[ "Email" ]))
                {
                   if (empty($emails[ $friendkey ][ $rfriend[ "Email" ] ]))
                   {
                       $emails[ $friendkey ][ $rfriend[ "Email" ] ]=$rfriend;
                   }
                   else
                   {
                       array_push
                       (
                           $this->MyMod_Handle_Emails_Warning,
                           array
                           (
                               "Double Email: ".$rfriend[ "Email" ],
                               $this->ApplicationObj->UsersObj()-> MyActions_Entry("Edit",$rfriend,$noicons=True)
                           )
                       );
                   }
                }
                else
                {
                    array_push
                    (
                        $this->MyMod_Handle_Emails_Warning,
                        array
                        (
                            "Empty email ".$rfriend[ "Name" ].": ".$rfriend[ "Email" ],
                            $this->ApplicationObj->UsersObj()-> MyActions_Entry("Edit",$rfriend,$noicons=True)
                        )
                    );
                }
                

                //Register entry
                $ids[ $friend[ $friendkey ] ]=1;
            }
 
            $emails[ $friendkey ]=$this->Sort_List_ByKey($emails[ $friendkey ],"Email");
        }

        return $emails;
    }
    //*
    //* function MyMod_Handle_Emails_Read_Items, Parameter list: $where,$friendkeys
    //*
    //* Reads items to email..
    //*

    function MyMod_Handle_Emails_Read_Items($where,$friendkeys)
    {
        $this->MyMod_Items_Read
        (
            $where,
            array_merge
            (
                array("ID","Name"),
                $friendkeys
            ),
            $nosearches=FALSE,
            $nopaging=True,
            $includeall=0,$nopostprocess=True
        );

        return $this->ItemHashes;
    }
}

?>