<?php


trait STeams_Top
{
    //*
    //* Overrides interface titles.
    //*

    function MyApp_Interface_Titles()
    {
        $titles=
            array
            (
                $this->MyApp_Title(),
            );

        if (!empty($this->CGI_GETint("Tournament")))
        {
            array_push
            (
                $titles,
                $this->Tournament("Title")
            );
            
            if (!empty($this->CGI_GETint("Season")))
            {
                array_push
                (
                    $titles,
                    array
                    (
                        $this->Season("Name")
                    )
                );

                if (!empty($this->CGI_GETint("Pool")))
                {
                    array_push
                    (
                        $titles,
                        $this->Pool("Name")
                    );
                }
            }
        }

        return $titles;
    }

    
    //*
    //* Returns as string left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Logo_Get($n)
    {
        if ($n==1)
        {
            $logo=$this->Tournament("Logo");
            if (!empty($logo))
            {
                return
                    "?".$this->CGI_Hash2URI
                    (
                        array
                        (
                            "ModuleName" => "Tournaments",
                            "Action" => "Download",
                            "Tournament" => $this->Tournament("ID"),
                            "Data" => "Logo",
                        )
                    );

                //$logo;
            }
        }
        elseif ($n==2)
        {
            $logo=$this->Season("Logo");
            if (!empty($logo))
            {
                return
                    "?".$this->CGI_Hash2URI
                    (
                        array
                        (
                            "ModuleName" => "Tournament_Seasons",
                            "Action" => "Download",
                            "Season" => $this->Season("ID"),
                            "Data" => "Logo",
                        )
                    );
            }
        }
        
        $key='HtmlIcon'.$n;

        $icon=$this->Interface_Logos[ $n ][ "Icon" ];
        if (!empty($this->CompanyHash[ $key ]))
        {
            $icon=$this->CompanyHash[ $key ];
        }

        return parent::MyApp_Interface_Logo_Get($n);
    }
    
}

?>
