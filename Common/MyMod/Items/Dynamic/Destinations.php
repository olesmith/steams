<?php

include_once("Destinations/Cells.php");
include_once("Destinations/Row.php");
include_once("Destinations/Plural.php");


trait MyMod_Items_Dynamic_Destinations
{
    use
        MyMod_Items_Dynamic_Destinations_Cells,
        MyMod_Items_Dynamic_Destinations_Row,
        MyMod_Items_Dynamic_Destinations_Plural;
}

?>