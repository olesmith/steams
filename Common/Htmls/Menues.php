<?php

include_once("Menues/Horisontal.php");
include_once("Menues/Dynamic.php");

trait Htmls_Menues
{
    use
        Htmls_Menues_Horisontal,
        Htmls_Menues_Dynamic;
}
?>