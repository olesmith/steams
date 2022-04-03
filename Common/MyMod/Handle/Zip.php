<?php

trait MyMod_Handle_Zip
{
    var $ZipShowDatas=array("No","Edit","Name");
    var $ZipTmpFiles=array();
    
    //*
    //* function MyMod_Handle_Zip, Parameter list: 
    //*
    //* Handles Module zipping of file.
    //*

    function MyMod_Handle_Zip()
    {
        if ($this->CGI_POSTint("Zip")==1)
        {
            $this->MyMod_Handle_Zip_Do();
            exit();
        }

        $this->MyMod_Handle_Zip_Show();
        
    }

    //*
    //* function MyMod_Handle_Zip_Buttons, Parameter list: 
    //*
    //* Gebnerates buttons for sending ZIP form.
    //*

    function MyMod_Handle_Zip_Buttons()
    {
        return
            array
            (
                $this->Button("submit","ZIP").
                $this->MakeHidden("Zip",1)
            );
    }
    
    //*
    //* function MyMod_Handle_Zip_Backup_CheckBox, Parameter list: 
    //*
    //* Gebnerates buttons for sending ZIP form.
    //*

    function MyMod_Handle_Zip_Backup_CheckBox_CGI_Name()
    {
        return "Backup";
    }
    
    //*
    //* function MyMod_Handle_Zip_Backup_CheckBox, Parameter list: 
    //*
    //* Gebnerates buttons for sending ZIP form.
    //*

    function MyMod_Handle_Zip_Backup_CheckBox_CGI_Value()
    {
        return
            $this->CGI_POSTint
            (
                $this->MyMod_Handle_Zip_Backup_CheckBox_CGI_Name()
            );
    }
    
    //*
    //* function MyMod_Handle_Zip_Backup_CheckBox, Parameter list: 
    //*
    //* Gebnerates buttons for sending ZIP form.
    //*

    function MyMod_Handle_Zip_Backup_CheckBox()
    {
        return
            array
            (
                $this->B
                (
                    "Backup Style: ",
                    array
                    (
                        "TITLE" => "No name mangling - suitable for later restore",
                    )
                ).
                $this->Html_Input_CheckBox_Field
                (
                    $this->MyMod_Handle_Zip_Backup_CheckBox_CGI_Name(),
                    $value=1,$checked=False
                )
            );
    }
    
    
    //*
    //* function MyMod_Handle_Zip_Show, Parameter list: 
    //*
    //* Shows files in $this->ApplicationObj()->MyApp_Globals_Upload_Paths().
    //*

    function MyMod_Handle_Zip_Show()
    {
        $this->ApplicationObj()->MyApp_Interface_Head();
        $this->MyMod_HorMenu_Echo(True);
        echo
            $this->Htmls_Text
            (
                $this->MyDirs_Form
                (
                    "Uploaded Files",
                    array($this->MyMod_Data_Upload_Path()),
                    array
                    (
                        $this->MyMod_Handle_Zip_Buttons(),
                        $this->MyMod_Handle_Zip_Backup_CheckBox(),
                    ),
                    array
                    (
                        $this->MyMod_Handle_Zip_Backup_CheckBox(),
                        $this->MyMod_Handle_Zip_Buttons(),
                    )
                )
            );

    }

    
    //*
    //* function MyMod_Handle_Zip_Files, Parameter list: $paths
    //*
    //* List of files in upload paths
    //*

    function MyMod_Handle_Zip_Files($paths)
    {
        $files=array();
        foreach ($paths as $path)
        {
            $rfiles=$this->TreeFiles($path);
            foreach ($rfiles as $file)
            {
                $rfile=preg_replace('/[\/\.]/',"_",$file);
                $include=$this->CGI_POSTint($rfile);
                
                if ($include==1) { array_push($files,$file); }
            }
        }

        return $files;
    }

    //*
    //* function MyMod_Handle_Zip_Paths, Parameter list: $paths
    //*
    //* List of files in upload paths
    //*

    function MyMod_Handle_Zip_Paths($files)
    {
        $paths=array();
        foreach ($files as $file)
        {
            $path=dirname($file);
            $paths[ $path ]=1;
        }

        return array_keys($paths);
    }

    
    //*
    //* function MyMod_Handle_Zip_Do, Parameter list: 
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Do()
    {
        $zipname="/tmp/".$this->ModuleName.".".$this->MTime2FName().".zip";

        $zip=$this->OpenZip($zipname);

        $paths=array($this->MyMod_Data_Upload_Path());
        $files=$this->MyMod_Handle_Zip_Files($paths);
        
        $rpaths=$this->MyMod_Handle_Zip_Paths($files);

        $this->MyMod_Handle_Zip_Paths_Add($zip,$rpaths);
        $this->MyMod_Handle_Zip_Files_Add($zip,$files);

        $this->CloseZip($zip,$zipname);
        $this->SendZip($zipname);

        $this->MyMod_Handle_Zip_Tmp_Remove($zipname);
        exit();
    }


    //*
    //* function MyMod_Handle_Zip_Paths_Add, Parameter list: $zip,$files
    //*
    //* Will create list of paths in zip file.
    //*

    function MyMod_Handle_Zip_Paths_Add($zip,$paths)
    {
        foreach ($paths as $path)
        {
            $zip->addEmptyDir($path);
        }
    }

    
    //*
    //* function MyMod_Handle_Zip_Files_Add, Parameter list: $zip,$files
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Files_Add($zip,$files)
    {
        $paths=array();
        foreach ($files as $file)
        {
            $path=dirname($file);
            $paths[ $path ]=1;
        }

        $paths=array_keys($paths);
        $this->MyMod_Handle_Zip_Paths_Add($zip,$paths);

        $res=True;
        foreach ($files as $file)
        {
            $res=
                $res
                &&
                $this->MyMod_Handle_Zip_File_Add($zip,$file);
        }
    }

    //*
    //* function MyMod_Handle_Zip_File_Add, Parameter list: $zip,$file
    //*
    //* Add one file to archive. Does name mangling for friend names to appear in file names,
    //* instead of IDs.
    //*

    function MyMod_Handle_Zip_File_Add($zip,$file)
    {
        $localfile=$file;
        $owner=$this->MyFile_Owner_Name($file);
        
        $backupstyle=$this->MyMod_Handle_Zip_Backup_CheckBox_CGI_Value();
        
        if (!empty($owner) && $backupstyle!=1)
        {
            $owner=$this->TrimCase($owner);
        
            $data=$this->MyFile_Data_Name($file);
            $owner=preg_replace('/\s+/',"-",$owner);
            $data=preg_replace('/\s+/',"-",$data);
        
            $path=dirname($localfile);
            $filename=basename($localfile);

            if (preg_match('/_(\d+)\./',$filename,$matches))
            {
                $owner.="-".$matches[1];
            }
            $filename=preg_replace('/_(\d+)\./',"_".$owner.".",$filename);
            $filename=preg_replace('/(\S)+_/',$data."_",$filename);
            $filename=$this->Text2Sort($filename);
            $filename=$this->Html2Sort($filename);
            $localfile=$path."/".$filename;
        }

        return $zip->addFile($file,$localfile);
    }

}

?>