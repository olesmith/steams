<?php

trait MyMod_Handle_Add_Update
{
    //* 
    //* 
    //*

    function MyMod_Handle_Add_Update($redirect)
    {
        $res=False;
        $action=$this->MyActions_Detect();
        if ($this->CGI_POSTint("Add")==1)
        {
            $msg="";
            $res=$this->MyMod_Handle_Add_Do($msg);
            if ($res && $redirect)
            {
                $this->MyMod_Handle_Add_Redirect();
            }
        }

        return $res;
    }
}

?>