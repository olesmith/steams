array
(
    "Basic" => array
    (
        "Data" => array
        (
            "No","Friend",
            "Tournament_Round","Tournament_Match",
            "Goals1","Goals2",
        ),
       
        "Load_Method" => "",
        "CGIs" => array(),
        
        "Dynamic" => array
        (
            "Edit" => array
            (
                "Module" => "Pool_Bets",
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
            "Copy" => array
            (
                "Module" => "Pool_Bets",
                "Action" => "Copy",
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
            "Delete" => array
            (
                "Module" => "Pool_Bets",
                "Action" => "Delete",
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
        ),
    ),
    "Friend" => array
    (
        "Data" => array
        (
            "No",
            "Tournament_Match",
            "Pool_Bet_Cell_Match_Team_Icons",
            "Goals1","Goals2",
            "Pool_Bet_Cell_Match_Result",
            "Pool_Bet_Cell_Match_Date_Time",
            "Points",
            //"Result_Goals","Result","Result_Goal",
            //"Updated",
            //"MTime",
        ),
       
        "SumVars" => array("Points"),
        "Load_Method" => "",
        "CGIs" => array(),
        
        "Dynamic" => array
        (
            "Show" => array
            (
                "Module" => "Pool_Bets",
                "Action" => "Show",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array("Tournament","Pool","Round","Friend"),
                "Hash" => array
                (
                    "Bet" => "ID",
                ),
            ),
            "Match" => array
            (
                "Module" => "Tournament_Matches",
                "Action" => "Show",
                "Args" => array
                (
                    "GroupName" => "Date",
                ),
                "GETs" => array("Tournament",),
                "Hash" => array
                (
                    "Match" => "Tournament_Match",
                ),
                "Icon" => "Matches_Icon",
            ),
            "History" => array
            (
                "Module" => "Tournament_Matches",
                "Action" => "History",
                "Args" => array
                (
                    //"GroupName" => "Date",
                ),
                "GETs" => array("Tournament",),
                "Hash" => array
                (
                    "Match" => "Tournament_Match",
                ),
                "Icon" => "History_Icon",
            ),
        ),
    ),
);