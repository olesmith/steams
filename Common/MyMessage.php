<?php


trait MyMessage
{
    //*
    //* function MyMessage_DebugMessage, Parameter list: $msg
    //*
    //* Shows message and dies.
    //*

    function MyMessage_Message($msg,$info="")
    {
        if (is_array($msg))
        {
            $msg=join("<BR>\n",$msg);
        }

        echo "MyMessage@".$this->ModuleName().": ".$msg;
        if (!empty($info)) { print(join("\n",$info))."\n";  }
    }

    //*
    //* function MyMessage_DebugMessage, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and dies.
    //*

    function MyMessage_DebugMessage($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if (is_array($msg))
        {
            $msg=join("<BR>\n",$msg);
        }

        echo "MyMessage_DebugMessage@".$this->ModuleName().": ".$msg;
        
        if (!empty($info1)) { var_dump($info1); }
        if (!empty($info2)) { var_dump($info2); }
        if (!empty($info3)) { var_dump($info3); }
        if (!empty($info4)) { var_dump($info4); }
        if (!empty($info5)) { var_dump($info5); }

        #var_dump(debug_backtrace(False));
        #$this->CallStack_Show();
    }

    //*
    //* function MyMessage_Die, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and dies.
    //*

    function MyMessage_Die($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if ($this->MakeCGI_CLI_Is())
        {
            echo $msg;
            //var_dump(debug_backtrace(False));
            var_dump($info1,$info2,$info3,$info4,$info5);
            //var_dump(debug_backtrace(False));
            return $msg;
        }

        if
            (
                method_exists($this,"MyApp_Interface_Head")
                &&
                !$this->HeadersSend
            )
        {
            echo
                $this->MyApp_Interface_Head();
        }

        if (
              empty($this->ApplicationObj()->DBHash)
              ||
              (
                 !empty($this->ApplicationObj()->DBHash[ "Debug" ])
                 &&
                 intval($this->ApplicationObj()->DBHash[ "Debug" ])==2
              )
          )
        {
            $this->MyMessage_DebugMessage
            (
                $msg,$info1,$info2,$info3,$info4,$info5
            );
        }
        else
        {
            $this->MyMessage_Message($msg,$info1);
        }
        //$this->CallStack_Show();
        die("<BR>Exiting...");

    }
    
    //*
    //* function MyMessage_Warn, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and returns.
    //*

    function MyMessage_Warn($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        echo "Warning! ";

        if
            (
                !empty
                (
                    $this->ApplicationObj()->DBHash[ "Debug" ]
                )
                ||
                empty($this->ApplicationObj()->DBHash)
            )
        {
            $this->MyMessage_DebugMessage
            (
                $msg,
                $info1,
                $info2,
                $info3,
                $info4,
                $info5
            );
        }
        else
        {
            $this->MyMessage_Message($msg);
        }

        echo "<BR>Ignored...";

    }
}
?>