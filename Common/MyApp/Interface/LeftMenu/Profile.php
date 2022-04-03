<?php


trait MyApp_Interface_LeftMenu_Profile
{
    //*
    //* function MyApp_Interface_LeftMenu_Profile, Parameter list: 
    //*
    //* Prints menu of images, for user to select profile.
    //*

    function MyApp_Interface_LeftMenu_Profile()
    {
        if ($this->LoginType=="Public") { return array(); }

        $links=array();

        foreach ($this->MyApp_CGIVars_Compulsory_Vars() as $var => $value)
        {
            $args[ $var ]=$value;
        }

        $trust=$this->MyApp_Profile_Trust();
        foreach ($this->AllowedProfiles() as $id => $profile)
        {
            $pname=$this->MyApp_Profile_Name($profile);

            if ($profile!=$this->Profile())
            {
                //May override this one
                $args[ "Action" ]="Start";

                //Check if menu item augments trust
                if ($this->MyApp_Profile_Trust($profile)>=$trust)
                {
                    //Good guess, that we have privilege to access current actions
                    $args=$this->CGI_URI2Hash();
                }
                
                $args[ "Profile" ]=$profile;

                if ($profile=="Admin")
                {
                    $args[ "Admin" ]=1;
                }
                elseif ($this->LoginType=="Admin")
                {
                    $args[ "Admin" ]=0;
                }

                array_push
                (
                   $links,
                   array
                   (
                       //$this->MyApp_Interface_LeftMenu_Bullet("+"),
                       $this->Htmls_Href
                       (
                           "?".$this->CGI_Hash2Query($args),
                           $pname,
                           $this->MyLanguage_GetMessage("Profile_Change").
                           " ".
                           $pname,
                           "leftmenulinks"
                       ),
                   )
                );
            }
            else
            {
                array_push($links,"&nbsp;- ".$pname);
            }
        }

        return $links;
    }
}

?>