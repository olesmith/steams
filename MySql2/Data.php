<?php


class Data extends DataPrint
{
    var $TitleKeyShortName="ShortName";
    var $TitleKeyName="Name";
    var $TitleKeyTitle="Title";

    //*
    //* Variables of Data class:

    var $Masculine;
    var $ItemName,$ItemsName,$ItemNamer,$ItemName_UK,$ItemsName_UK,$ItemNamer_UK;
    var $SqlData,$SqlDerivers;
    var $ItemFieldMethods=array();
 

    var $ItemDataMode="Php";
    var $TabMovesDownKey="_TabMovesDown";
    var $StringVars=array("Sql","Name","LongName");
    var $BoolVars=array("Compulsory","Visible","Admin","Person","Public","NoSort","ShowOnly","TimeType");
    var $ListVars=array("Values","ShowIDCols","EditIDCols");
    var $AlwaysReadData=array();
    var $DatasRead=array();

     //*
    //* function GetDefaultItemData, Parameter list: $data,&$datadef
    //*
    //* Makes sure ItemData entries has all necessary keys.
    //*

    function GetDefaultItemData($data,&$datadef)
    {
        foreach ($this->DefaultItemData as $key => $value)
        {
            if (!isset($datadef[ $key ]))
            {
                $datadef[ $key ]=$value;
            }
        }

        foreach ($this->ApplicationObj->ValidProfiles as $profile)
        {
            if (!isset($datadef[ $profile ]))
            {
                $datadef[ $profile ]=0;
            }
        }
    }

    //*
    //* function DisableFileData, Parameter list: $value=0
    //*
    //* Disables FILE data, setting ItemData's [ $this->Profile() ] to $value, default 0.
    //*

  function DisableFileData($value=0)
  {
      foreach (array_keys($this->ItemData) as $data)
      {
          if ($this->ItemData[ $data ][ "Sql" ]=="FILE")
          {
              $this->ItemData[ $data ][ $this->Profile() ]=0;
          }
      }
  }

  function RealFieldName($field)
  {
      $rfield=$field;
      if ($this->Reserved[ $field ]!="") { $rfield=$this->Reserved[ $field ]; }

      return $rfield;
  }

  function OriginalFieldName($field)
  {
      $hash=$this->Reserved;
      $rhash=array();
      foreach ($hash as $key => $value) { $rhash[ $value ]=$key; }

      $rfield=$field;
      if ($rhash[ $field ]!="") { $rfield=$rhash[ $field ]; }

      return $rfield;
  }

  function TransFieldNamesHash($hash,$type)
  {
      $specs=$this->DataSpecs[ $type ];

      $rhash=array();
      foreach ($hash as $field => $value)
      {
          $rfield=$this->RealFieldName($field);
          $res=preg_grep("/^$field$/",$specs);
          if (count($res)>0)
          {
              $rhash[ $rfield ]=$hash[ $field ];
              $rhash[ $rfield ]=preg_replace("/'/","''",$rhash[ $rfield ]);
          }
      }

      return $rhash;
  }

  function OriginalFieldNamesHash($hash)
  {
      $rhash=array();
      foreach ($hash as $field => $value)
      {
          $rfield=$this->OriginalFieldName($field);
          $rhash[ $rfield ]=$hash[ $field ];
      }

      return $rhash;
  }

  function GetRealSqlWhereClause()
  {
      $this->MyApp_Login_Detect();

      $where="";
      if ($this->LoginType=="Admin")
      {
          if (isset($this->ItemData[ $data ][ "SqlAdminWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlAdminWhere" ];
          }
      }
      elseif ($this->LoginType=="Person")
      {
          if (isset($this->ItemData[ $data ][ "SqlPersonWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlPersonWhere" ];
          }
      }
      elseif ($this->LoginType=="Public")
      {
          if (isset($this->ItemData[ $data ][ "SqlPublicWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlPublicWhere" ];
          }
      }

      if ($where=="")
      {
          $where=$this->ItemData[ $data ][ "SqlWhere" ];
      }

      $loginid=(int)$this->LoginID;
      $where=preg_replace('/#LoginID/',$loginid,$where);

      return $where;
  }

  function SetSqlObjectDataDefs($data)
  {
      if ($this->ItemData[ $data ][ "SqlObject" ]!="")
      {
          $object=$this->ItemData[ $data ][ "SqlObject" ];
          foreach ($object->Object->ItemData as $id => $rdata)
          {
              $this->ItemData[ $data."_".$data ]=$object->ItemData[ $rdata ];
          }
      }
  }


  function InitSqlObject($data)
  {
      $class=$this->ItemData[ $data ][ "SqlClass" ];

      return $this->LoadSubModuleVars($data,$class);
  }

  function LoadSubModuleVars($data,$class)
  {
      if (empty($this->ApplicationObj->SubModulesVars [ $class ])) { return FALSE; }

      foreach ($this->ApplicationObj->SubModulesVars [ $class ] as $key => $value)
      {
          if (empty($this->ItemData[ $data ][ $key ]))
          {
              $this->ItemData[ $data ][ $key ]=$value;
          }
      }

      return TRUE;
  }




  function DataKeyHash($key)
  {
      $list=array();
      foreach ($this->ItemData as $data => $hash)
      {
          $list[ $data ]=$hash[ $key ];
      }

      return $list;
  }

  function DataKeys()
  {
      $list=array();
      foreach ($this->ItemData as $data => $hash)
      {
          array_push($list,$data);
      }

      return $list;
  }

  function Datas2Datas($datas)
  {
      $rdatas=array();
      foreach ($datas as $data)
      {
          if (!empty($this->ItemData[ $data ]))
          {
              array_push($rdatas,$data);
          }
      }

      return $rdatas;
  }

  /* function GetDataTitle($data,$nohtml=0) */
  /* { */
  /*     return $this->MyMod_Data_Title($data,$nohtml); */
  /* } */


  /* function GetDataTitles($datas,$nohtml=0) */
  /* { */
  /*     return $this->MyMod_Data_Titles($datas,$nohtml); */
  /* } */


  function DecorateDataTitle($name,$title="",$includecolon=FALSE)
  {
      if (empty($title)) { $title=$name; }
      
      if ($includecolon) { $title.=":"; }

      if ($this->LatexMode())
      {
          $title="\\textbf{".$title."}";
      }
      else
      {
          $title=$this->Span($name,array("CLASS" => 'datatitlelink',"TITLE" => $title));
      }

      return $title;
  }

  function DecoratedDataTitle($data,$includecolon=FALSE)
  {
      $title=$this->MyMod_Data_Title($data);

      if ($includecolon) { $title.=":"; }

      return $this->DecorateDataTitle($title);
    
  }

  function DataHash2File($itemdata,$file)
  {
      $keys=array();
      foreach ($itemdata as $data => $hash)
      {
          foreach ($hash as $key => $value)
          {
              if (!preg_grep("/^$key$/",$keys)) { array_push($keys,$key); }
          }
      }

      $lines=array();
      foreach ($itemdata as $data => $hash)
      {
          for ($n=0;$n<count($keys);$n++)
          {
              $value=$hash[ $keys[ $n ] ];
              $type="Scalar";
              if (is_array($value))
              {
                  $value='("'.join('","',$value).'")';
                  $type="List";
              }
              array_push($lines,$data."\t".$type."\t".$keys[ $n ]."\t".$value."\n");
          }
      }

      $this->MyWriteFile($file,$lines);
  }

  function WriteDataFiles()
  {
      $this->DataHash2File($this->ItemData,"Data/".$this->ModuleName.".Data.txt");
      $this->DataHash2File($this->ItemDataGroups,"Data/".$this->ModuleName.".Groups.txt");
  }

  function DataFile2Hash($file)
  {
      $lines=$this->MyReadFile($file);

      $itemdata=array();
      for ($n=0;$n<count($lines);$n++)
      {
          $lines[$n]=chop($lines[$n]);
          $comps=preg_split('/\t/',$lines[$n]);
          $data=array_shift($comps);
          $type=array_shift($comps);
          $key=array_shift($comps);
          $value=join("\t",$comps);


          if (!is_array($itemdata[ $data ]))
          {
              $itemdata[ $data ]=array();
          }

          if ($type=="List")
          {
              $value=preg_replace('/^\("/',"",$value);
              $value=preg_replace('/"\)$/',"",$value);
              $value=preg_split('/","/',$value);
          }

          $itemdata[ $data ][ $key ]=$value;
      }

      return $itemdata;
  }
                    
  function ReadDataFiles()
  {
      $this->ItemData=$this->DataFile2Hash("Data/".$this->ModuleName.".Data.txt");
      $this->ItemDataGroups=$this->DataFile2Hash("Data/".$this->ModuleName.".Groups.txt");
  }


  function DefineItemData($itemdata)
  {
      $table=array();
      $keys=array();
      foreach ($itemdata as $data => $hash)
      {
          if (!preg_match('/^[ACM]Time$/',$data))
          {
              array_push($table,array($this->H(3,$data)));
              if (count($keys)==0) { $keys=array_keys($hash); }
              for ($n=0;$n<count($keys);$n++)
              {
                  $fieldname=$data."_".$keys[$n];

                  $value=$hash[ $keys[$n] ];
                  if (preg_grep('/^'.$keys[$n].'$/',$this->StringVars))
                  {
                      $value=$this->MakeInput($fieldname,$value,strlen($value));
                  }
                  elseif (preg_grep('/^'.$keys[$n].'$/',$this->BoolVars))
                  {
                      $bools=array("0","1");
                      $value=$this->MakeSelectField($fieldname,$bools,$bools,$value);
                  }
                  elseif (is_array($value))
                  {
                      $value=join(",",$value);
                  }
                  array_push($table,array($n+1,"<B>".$keys[$n]."</B>",$value));
              }
          }
      }

      print
          $this->H(1,"Dados do ".$this->ItemName).
          $this->HtmlTable("",$table);
  }

  function DefineDataForm()
  {
      $this->DefineItemData($this->ItemData);
  }

    //*
    //* function NonDerivedData, Parameter list: $datas=array()
    //*
    //* Detects which data to actually read.
    //*

    function NonDerivedData($datas=array())
    {
        if (count($datas)==0)
        {
            $datas=array_keys($this->ItemData);
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (
                isset($this->ItemData[ $data ])
                &&
                is_array($this->ItemData[ $data ])
                &&
                empty($this->ItemData[ $data ][ "Derived" ])
               )
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }
    

    //*
    //* function Hash2ItemData, Parameter list: $hashdata,$datakey
    //*
    //* Adds hash data in $hashdata to $this->ItemData with prekey $datakey.
    //* If $hashdata is a string, tries to read item hashes from this as a file.
    //*

    function Hash2ItemData($hashdata,$datakey,$filterhash=array())
    {
        if (!is_array($hashdata))
        {
            $hashdata=$this->ReadPHPArray($hashdata);
        }

        if (!preg_match('/_$/',$datakey)) { $datakey.="_"; }

        $rdatas=array();
        foreach ($hashdata as $data => $datadef)
        {
            $key=$datakey.$data;
            $this->ItemData[ $key ]=$this->FilterHashKeys($datadef,$filterhash);

            array_push($rdatas,$key);
        }

        return $rdatas;
    }

    //*
    //* function HashList2ItemData, Parameter list: $hashdata,$datakey,$ndata
    //*
    //* Adds $ndata copies of each of the data defined in $hashdata to 
    //* $this->ItemData.
    //* If $hashdata is a string, tries to read item hashes from this as a file.
    //*

    function HashList2ItemData($hashdata,$datakey,$ndata,$filterhash=array(),$newline=0)
    {
        if (!is_array($hashdata))
        {
            $hashdata=$this->ReadPHPArray($hashdata);
        }

        if (!preg_match('/_$/',$datakey)) { $datakey.="_"; }

        $rdatas=array();
        for ($n=1;$n<=$ndata;$n++)
        {
            $rfilterhash=$filterhash;
            foreach ($rfilterhash as $key => $value)
            {
                $rfilterhash[ $key ].=" ".$n;
            }
            $rfilterhash[ "N" ]=$n;

            foreach ($hashdata as $data => $datadef)
            {
                $key=$datakey.$n."_".$data;
                $this->ItemData[ $key ]=$this->FilterHashKeys($datadef,$rfilterhash);
                foreach (array("Title","Name","ShortName") as $rdata)
                {
                    if (empty($this->ItemData[ $key ][ $rdata ])) { continue; }

                    $this->ItemData[ $key ][ $rdata ]=
                        preg_replace('/#N/i',$n,$this->ItemData[ $key ][ $rdata ]);
                }

                array_push($rdatas,$key);
            }

            if ($newline>0)
            {
                array_push($rdatas,"newline(".$newline.")");
            }
        }

        return $rdatas;
    }



    //*
    //* Returns data defined in $this->ItemData that are not ReadOnly.
    //*

    function GetNonReadOnlyData()
    {
        //27/01/2012 $this->PostProcessItemData();
        $datas=array_keys($this->ItemData);
        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (!$this->ItemData[ $data ][ "ReadOnly" ])
            {
                if (!preg_match('/[MCA]Time/',$data))
                {
                    array_push($rdatas,$data);
                }
            }
        }

        return $rdatas;
   }

    //*
    //* function ListOfItemDataWithKeysValues, Parameter list: $valueshash,$datas=NULL
    //*
    //* Returns list of item data keys, where the keys in $valueshash
    //* matches regex in $value. $valueshash is ass. array: $key => $value,...
    //* If $datas is NULL or non-array, $datas is set to all data:
    //* array_keys($this->ItemData).
    //*

    function ListOfItemDataWithKeysValues($valueshash,$datas=NULL,$revert=TRUE)
    {
        if (!$datas || !is_array($datas)) { $datas=array_keys($this->ItemData); }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            $include=TRUE;
            foreach ($valueshash as $key => $regex)
            {
                if ($revert)
                {
                    if (!preg_match('/'.$regex.'/',$this->ItemData[ $data ][ $key ]))
                    {
                        $include=FALSE;
                        break;
                    }
                }
                else
                {
                    if (preg_match('/'.$regex.'/',$this->ItemData[ $data ][ $key ]))
                    {
                        $include=FALSE;
                        break;
                    }
                }
            }

            if ($include)
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }

    //*
    //* function IntIsDefined, Parameter list: $id
    //*
    //* Tests whether ID is deined and an integer.
    //*

    function IntIsDefined($id)
    {
        $res=FALSE;
        if (!empty($id) && preg_match('/^\d+$/',$id))
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function GetFileFields, Parameter list: 
    //*
    //* Returns list of data defined as file fields.
    //*

    function GetFileFields()
    {
        $datas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->MyMod_Data_Access($data)>0)
            {
                if ($this->ItemData[ $data ][ "Sql" ]=="FILE")
                {
                    array_push($datas,$data);
                }
            }
        }

        return $datas;
    }
    //*
    //* function GetFileFields, Parameter list: 
    //*
    //* Returns list of data defined as file fields.
    //*

    function GetFileFieldDatas()
    {
        $datas=array();
        foreach ($this->GetFileFields() as $data)
        {
            array_push($datas,$data);
            foreach (array_keys($this->Sql_Table_Fields_File_Datas()) as $key)
            {
                array_push($datas,$data,$data."_".$key);
            }
        }

        return $datas;
    }
}
?>