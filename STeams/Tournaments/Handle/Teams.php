<?php



trait Tournaments_Handle_Teams
{

    function Tournament_Handle_Teams($tournament=array())
    {
        if (!empty($tournament)) { $this->__Tournament__=$tournament; }

        $this->Tournament();

        
        $this->Htmls_Echo
        (
            $this->Htmls_Frame
            (
                $this->GroupsObj()->Tournament_Groups_Teams_Generate()
            )
        );
    }
}

?>