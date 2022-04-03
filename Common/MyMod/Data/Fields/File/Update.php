<?php


trait MyMod_Data_Fields_File_Update
{
    //*
    //* Updates File field (ie moves file)
    //*

    function MyMod_Data_Fields_File_Update($data,&$item,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $uploadpath=$this->MyMod_Data_Upload_Path();
        $extensions=$this->MyMod_Data_Fields_File_Extensions_Get($data);

        if (!empty($_FILES[ $rdata ]) && !empty($_FILES[ $rdata ][ 'tmp_name' ]))
        {
            $uploadinfo=$_FILES[ $rdata ];
            $tmpname=$uploadinfo['tmp_name'];
            $name=$uploadinfo['name'];
            $error=$uploadinfo['error'];

            $comps=preg_split('/\./',$name);
            $ext=$comps[ count($comps)-1 ];

            $comps=preg_split('/\//',$name);
            $rname=$comps[ count($comps)-1 ];
            $datatitle=$this->MyMod_Data_Title($data);

            if (preg_grep('/^'.$ext.'$/i',$extensions))
            {
                $destfile=$this->MyMod_Data_Upload_FileName_Get($data,$item,$ext);

                $res=$this->MyMod_Data_Field_File_Move($tmpname,$data,$item,$ext);

                

                $item[ $data."_OrigName" ]=$name;
                $item[ $data ]=$destfile;
                $this->Sql_Update_Item_Values_Set
                (
                   array($data,$data."_OrigName"),
                   $item,
                   $this->SqlTableName()                   
                );

                
                $msgtext=$this->MyLanguage_GetMessage("FileUploaded");
                
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$datatitle,$msgtext);
                
                $this->HtmlStatus=$msgtext."<BR><BR>";

                $this->ApplicationObj()->MyApp_Interface_Message_Add($msgtext);

                $item[ "__Res__" ]=TRUE;
                return $item;
            }
            elseif (empty($name))
            {
                $msgtext=$this->GetMessage($this->ItemDataMessages,"InvalidExtension");
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$rdata,$msgtext);
                $item[ $data."_Message" ]=$msgtext;

                $msgtext=$this->GetMessage($this->ItemDataMessages,"InvalidExtensionStatus");
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$rdata,$msgtext);
                $this->HtmlStatus=$msgtext."<BR><BR>";
                $item[ "__Res__" ]=FALSE;

                $this->ApplicationObj()->MyApp_Interface_Message_Add($msgtext);
                echo $this->Div($msgtext,array("CLASS" => 'errors',"ALIGN" => 'center'));
            }
        }

        return FALSE;
    }
    
    //*
    //* Moves uploaded file.
    //*

    function MyMod_Data_Field_File_Move($tmpname,$data,$item,$ext)
    {
        $destfile=$this->MyMod_Data_Upload_FileName_Get($data,$item,$ext);

        $fulldestfile=
            $this->ApplicationObj()->Upload_Path.
            "/".
            $destfile;
                
        $this->Dir_Create_AllPaths(   dirname($fulldestfile)   );
        
        $res=
            move_uploaded_file
            (
                $tmpname,
                $fulldestfile
            );

        return $res;                
    }
}

?>