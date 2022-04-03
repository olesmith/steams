<?php


trait MyMod_Data_Fields_File_Decorator_Download
{
    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Link($edit,$item,$data,$value)
    {
        if ($this->MyMod_Data_Value_Image_Is($item,$data))
        {
            return
                $this->Htmls_HRef
                (
                    $this->MyMod_Data_Fields_File_Decorator_Download_Url($item,$data),
                    $this->MyMod_Data_Fields_File_IMG($edit,$item,$data),
                    array
                    (
                        "CLASS" => "uploadmsg",
                        "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Download_Title($item,$data),
                    )
                );
        }
        
        return
            $this->A
            (
                $this->MyMod_Data_Fields_File_Decorator_Download_Url($item,$data),
                $this->MyMod_Data_Fields_File_Decorator_Download_Icon($item,$data),
                array
                (
                    "CLASS" => "uploadmsg",
                    "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Download_Title($item,$data),
                )
            );
    }

    //* FileDownloadLink
    //* 
    //* Creates icon for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Icon($item,$data)
    {
        $value=$file="";
        if (isset($item[ $data ]))
        {
            $file=$this->MyMod_Data_Fields_File_FileName($data,$item);
        }
        
        if (isset($item[ $data."_OrigName" ])) { $value=$item[ $data."_OrigName" ]; }

        $icon="";
        if (!empty($this->ItemData[ $data ][ "Icon" ]))
        {
            if ($this->MyMod_Data_Image_Value_Is($value))
            {
                $icon=
                    $this->IMG
                    (
                        "icons/".$this->ItemData[ $data ][ "Icon" ],
                        basename($value),
                        20,20
                    );
            }
            else
            {
                $icon=
                    $this->MyMod_Interface_Icon
                    (
                        $this->ItemData[ $data ][ "Icon" ]
                    );
            }
        }      
        elseif
            (
                preg_match('/\.pdf$/',$value)
                ||
                !empty($this->ItemData[ $data ][ "Iconify" ])
            )
        {
            $icon=$this->MyActions_Entry_Icon("Download");
        }      
        elseif (!empty($value))
        {
            $icon=$value;
            if (file_exists($file))
            {
               $icon=
                   $this->HRef
                   (
                       $this->MyMod_Data_Fields_File_Decorator_Download_Url
                       (
                           $item,$data
                       ),
                       $this->MyMod_Data_Fields_File_Decorator_Download_IMG
                       (
                           $item,$data
                       )
                   );
            }
            else
            {
                $icon=$item [ $data."_OrigName" ];
            }
        }
        else
        {
            $icon=$rvalue;
        }
        
        return $icon; 
    }
    
    //*
    //* 
    //* 
    //*

    function MyMod_Data_Fields_File_Decorator_Download_IMG($item,$data)
    {
        return
            $this->IMG
            (
                $this->MyMod_Data_Fields_File_Decorator_Download_Url($item,$data),
                $item[ $data ],
                $this->MyMod_Data_Fields_File_IMG_Height($item,$data),
                $this->MyMod_Data_Fields_File_IMG_Width($item,$data),
                array
                (
                    "CLASS" => 'center',
                )
            );
    }
    
    //* FileDownloadMTime
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_TimeStamp($item,$data)
    {
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }
        
        $filetime="";
        if (!empty($item[ $data."_Time" ]))
        {
            $filetime=$item[ $data."_Time" ];
        }
        elseif (file_exists($value))
        {
            $filetime=filemtime($value);
        }

        return $this->TimeStamp2Text($filetime," ",False);
    }
    
    //* MyMod_Data_Fields_File_Decorator_Download_Title
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Title($item,$data)
    {
        return
            $this->MyMod_Data_Fields_File_Decorator_Title($item,$data,"Field_File_Verify_Title");
    }

        
    //* FileDownloadHref
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Url($item,$data)
    {
        $args=$this->CGI_URI2Hash();
        $args=$this->CGI_Hidden2Hash($args);
        $this->CGI_CommonArgs_Add($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Download";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return "?".$this->CGI_Hash2Query($args);        
    }
}

?>