array
(
    "Basic" => array
    (
        "Data" => array
        (
            "No","Friend",
            //"Tournament_Round","Tournament_Month",
            "Ranking","Points",
        ),
       
        "Load_Method" => "",
        "CGIs" => array("Tournament","Season","Pool"),
        
        "Dynamic" => array
        (
            "Edit" => array
            (
                "Module" => "Pool_Rankings",
                "Action" => "Edit",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array(),
                "Hash" => array
                (
                    "Bet" => "ID",
                ),
            ),
            /* "Delete" => array */
            /* ( */
            /*     "Module" => "Pool_Rankings", */
            /*     "Action" => "Delete", */
            /*     "Args" => array */
            /*     ( */
            /*         "GroupName" => "Basic", */
            /*     ), */
            /*     "GETs" => array(), */
            /*     "Hash" => array */
            /*     ( */
            /*         "" => "ID", */
            /*     ), */
            /* ), */
        ),
    ),
);