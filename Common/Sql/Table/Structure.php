<?php

include_once("Structure/Column.php");
include_once("Structure/Columns.php");
include_once("Structure/Default.php");
include_once("Structure/Update.php");

trait Sql_Table_Structure
{
    use
        Sql_Table_Structure_Column,
        Sql_Table_Structure_Columns,
        Sql_Table_Structure_Default,
        Sql_Table_Structure_Update;
}
?>