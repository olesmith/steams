<?php

trait MyHash
{
    //*
    //* 
    //*

    function MyHash_Key_Get_Save($hash,$key,$default="")
    {
        if (isset($hash[ $key ])) { return $hash[ $key ]; }

        return $default;
    }
    
    //*
    //* Returns list of $key values in $list items.
    //*

    function MyHashes_Keys($list,$key)
    {
        $values=array();
        foreach (array_keys($list) as $id)
        {
            $values[ $id ]=$list[ $id ][ $key ];
        }

        return $values;
    }
    
    //*
    //* Returns list of $key values in $list items.
    //*

    function MyHashes_Keys_Unique($list,$key)
    {
        $values=array();
        foreach (array_keys($list) as $id)
        {
            $value=$list[ $id ][ $key ];

            $values[ $value ]=True;
        }

        return array_keys($values);
    }
    
    //*
    //* Compare $keys in $hash1 and $hash2.
    //*

    function MyHashes_Compare($hash1,$hash2,$keys)
    {
        $res=True;
        foreach ($keys as $key)
        {
            if ($hash1[$key ]!=$hash2[ $key ])
            {
                $res=False;
                break;
            }
        }

        return $res;
    }
    
    //*
    //* function MyHash_Show, Parameter list: $item
    //*
    //* Returns $item $datas keys.
    //*

    function MyHash_Show($item,$keys=array(),$olditem=array())
    {
        if (empty($keys)) { $keys=array_keys($item); }
        
        $text=array();
        foreach ($keys as $key)
        {
            if (is_array($item[ $key ]))  { $item[ $key ] =join(", ",$item[ $key ]); }

            if (isset($olditem[ $key ]))
            {
                if (is_array($olditem[ $key ])) { $olditem[ $key ]=join(", ",$olditem[ $key ]); }
                
                array_push
                (
                    $text,
                    $key.": ".$olditem[ $key ]." => ".$item[ $key ]
                );
            }
            else
            {
                array_push
                (
                    $text,
                    $key.": ".$item[ $key ]
                );
            }
        }

        return $text;
    }
     
    //*
    //* function MyHash_List_Keys, Parameter list: $list
    //*
    //* Returns has with $item => True entries.
    //*

    function MyHash_List_Keys($list)
    {
        $values=array();
        foreach ($list as $item)
        {
            $values[ $item ]=True;
        }

        return $values;
    }
    
     //*
    //* function MyHash_List_Unique, Parameter list: $item,$datas
    //*
    //* Returns $item $datas keys.
    //*

    function MyHash_List_Unique($list)
    {
        return
            array_keys
            (
                $this->MyHash_List_Keys($list)
            );
    }
    //*
    //* function MyHash_Values_Get, Parameter list: $item,$datas
    //*
    //* Returns $item $datas keys.
    //*

    function MyHash_Values_Get($item,$datas)
    {
        $values=array();
        foreach ($datas as $data)
        {
            array_push($values,$item[ $data ]);
        }

        return $values;
    }
    
    //*
    //* Returns $item hash with $datas keys.
    //*

    function MyHash_Values_Hash($item,$datas)
    {
        $ritem=array();
        foreach ($datas as $data)
        {
            $ritem[ $data ]=$item[ $data ];
        }

        return $ritem;
    }

    //*
    //* function MyHash_2_Hash_Transfer, Parameter list: $src,&$dest,$datas
    //*
    //* If empty $list[ $key ], sets it to array().
    //*

    function MyHash_2_Hash_Transfer($src,&$dest,$datas)
    {
        foreach (array("Date","Time","Place","Room","Submission") as $data)
        {
            $dest[ $data ]=$src[ $data ];
        }
    }

    //*
    //* function MyHash_Value_Save_Set, Parameter list: &$list,$key,$value=array()
    //*
    //* If empty $list[ $key ], sets it to array().
    //*

    function MyHash_Value_Save_Set(&$list,$key,$value=array())
    {
        if (empty($list[ $key ]))
        {
            $list[ $key ]=$value;
        }
    }
    //*
    //* function MyHash_Key, Parameter list: $hash,$key
    //*
    //* Savely return $hash key $key.
    //*

    function MyHash_Key($hash,$key)
    {
        if (isset($hash[ $key ])) { return $hash[ $key ]; }

        return NULL;
    }


    //*
    //* function MyHash_Args2Object, Parameter list: $hash
    //*
    //* Reads module specific setup.
    //*

    function MyHash_Args2Object($hash,$undefsonly=FALSE)
    {
        foreach ($hash as $key => $value)
        {
            if (!$undefsonly || empty($this->$key))
            {
                $this->$key=$value;
            }
        }
    }


    //*
    //* function MyHash_AddDefaultKeys, Parameter list: &$hash,$defaults
    //*
    //* Adds all keys in $defaults, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in definitions using $hash.
    //*

    function MyHash_AddDefaultKeys(&$hash,$defaults)
    {
        foreach ($defaults as $key => $value)
        {
            if (!isset($hash[ $key ]))
            {
                $hash[ $key ]=$value;
            }
        }
    }

    //*
    //* function MyHash_HashesList_Values, Parameter list: $list,$key1,$key2=""
    //*
    //* Keys list in sublists by ID $key values.
    //*

    function MyHash_HashesList_Values($list,$key1="ID",$key2="")
    {
        $rlist=array();
        if (!is_array($list)) { var_dump($list); return array(); }
        foreach (array_keys($list) as $id)
        {
            if (!isset($list[ $id ])|| !isset($list[ $id ][ $key1 ]))
            {
                var_dump("Not primary empty, key: $id ".$key1,$list[ $id ]);
                continue;
            }
            
            $value=$list[ $id ][ $key1 ];
            if (!empty($key2))
            {
                if (!isset($list[ $id ][ $key1 ][ $key2 ]))
                {
                    var_dump("Not empty, key: ".$key2,$list[ $id ][ $key1 ]);
                }
                
                $value=$list[ $id ][ $key1 ][ $key2 ];
            }

            $rlist[ $value ]=1;
        }

        return array_keys($rlist);
    }

    //*
    //* Keys list in sublists by ID $key values.
    //*

    function MyHash_HashesList_2ID($list,$key="ID",$warn=False)
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            if (isset($list[ $id ][ $key ]))
            {
                $val=$list[ $id ][ $key ];
                $this->MyHash_Value_Save_Set($rlist,$val);
                $rlist[ $val ]=$list[ $id ];
            }
            elseif ($warn)
            {
                var_dump
                (
                    $this->ModuleName.
                    ": ".
                    "Warning! No such key $key, $id:",$list[ $id ]
                );
            }
        }

        return $rlist;
    }

    //*
    //* function MyHash_HashesList_2IDs, Parameter list: $list,$key="ID"
    //*
    //* Keys list in sublists by ID $key values.
    //*

    function MyHash_HashesList_2IDs($list,$key="ID",$sortorder=array())
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            if (isset($list[ $id ][ $key ]))
            {
                $val=$list[ $id ][ $key ];
                $this->MyHash_Value_Save_Set($rlist,$val);
                $rlist[ $val ][ $id ]=$list[ $id ];
            }
        }

        if (!empty($sortorder))
        {
            $rrlist=array();
            foreach ($sortorder as $val)
            {
                if (isset($rlist[ $val ]))
                {
                    $rrlist[ $val ]=$rlist[ $val ];
                }
            }

            return $rrlist;
        }

        return $rlist;
    }

    //*
    //* function MyHash_HashesList_Key, Parameter list: $list,$key="ID"
    //*
    //* Keys list in sublists by ID $key values.
    //*

    function MyHash_HashesList_Key($list,$key="ID")
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            $val=$list[ $id ][ $key ];
            $this->MyHash_Value_Save_Set($rlist,$val);
            array_push($rlist[ $val ],$list[ $id ]);
        }

        return $rlist;
    }


    //*
    //* function MyHash_HashesList_Key2, Parameter list: $list,$key1,$key2
    //*
    //* Keys list in sublists by ID the two $key1 and $key2 values.
    //*

    function MyHash_HashesList_Key2($list,$key1,$key2)
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            $val1=$list[ $id ][ $key1 ];
            $this->MyHash_Value_Save_Set($rlist,$val1);

            
            $val2=$list[ $id ][ $key2 ];
            $this->MyHash_Value_Save_Set($rlist[ $val1 ],$val2);

            array_push($rlist[ $val1 ][ $val2 ],$list[ $id ]);
        }

        return $rlist;
    }

    //*
    //* function MyHash_HashesList_Key3, Parameter list: $list,$key1,$key2,$key3
    //*
    //* Keys list in sublists by ID $key1,$key2,$key3 values.
    //*

    function MyHash_HashesList_Key3($list,$key1,$key2,$key3)
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            $val1=$list[ $id ][ $key1 ];
            $this->MyHash_Value_Save_Set($rlist,$val1);

            
            $val2=$list[ $id ][ $key2 ];
            $this->MyHash_Value_Save_Set($rlist[ $val1 ],$val2);

            $val3=$list[ $id ][ $key3 ];
            $this->MyHash_Value_Save_Set($rlist[ $val1 ][ $val2 ],$val3);


            
            array_push($rlist[ $val1 ][ $val2 ][ $val3 ],$list[ $id ]);
        }

        return $rlist;
    }


    
   
    //*
    //* function MyHash_HashHashes_Get, Parameter list: $hashes,$key1="",$key2=""
    //*
    //* Returns $hashes[ $key1 ][ $key2 ] if both keys defined,
    //* $hashes[ $key1 ] if first key defined,
    //* elsewise return full hash.
    //*

    function MyHash_HashHashes_Get($hashes,$key1="",$key2="")
    {
        if (!empty($key1))
        {
            if (!empty($hashes[ $key1 ]))
            {
                if (!empty($key2))
                {
                    if (is_array($key2))
                    {
                        $rhash=array();
                        foreach ($key2 as $key)
                        {
                            if (!empty($hashes[ $key1 ][ $key ]))
                            {
                                $rhash[ $key ]=$hashes[ $key1 ][ $key ];
                            }
                        }

                        return $rhash;
                    }
                    elseif (!empty($hashes[ $key1 ][ $key2 ]))
                    {
                        return $hashes[ $key1 ][ $key2 ];
                    }
                }
                else
                {
                    return $hashes[ $key1 ];
                }
            }
        }
        else
        {
            return $hashes;
        }

        return NULL;
    }

    //*
    //* function MyHash_HashHashes_Set, Parameter list: &$hashes,$value,$key1="",$key2=""
    //*
    //* Sets $hashes[ $key1 ][ $key2 ] if both keys defined,
    //* $hashes[ $key1 ] if first key defined,
    //* elsewise does nothing.
    //*

    function MyHash_HashHashes_Set(&$hashes,$value,$key1="",$key2="")
    {
        if (!empty($key1))
        {
            if (!empty($key2))
            {
                $hashes[ $key1 ][ $key2 ]=$value;
            }
            else
            {
                $hashes[ $key1 ]=$value;
            }
        }
    }



    //*
    //* function MyHash_Hash2Access, Parameter list: $hash,$value=array(1)
    //*
    //* Tests if $hash, as an ItemData, Actions entry (or other hash), is
    //* permitted for current user.
    //*
    //* Considered are LoginType and Profile keys. 
    //*

    function MyHash_Hash2Access($hash,$values=array(1),$profile="",$logintype="")
    {
        if (!is_array($values)) { $values=array($values); }


        if (empty($profile)) { $profile=$this->Profile(); }
        
        if (empty($logintype))
        {
            if (!preg_match('/^(Admin|Public)/',$profile))
            {
                $logintype="Person";
            }
        }
        if (empty($logintype)) { $logintype=$this->LoginType(); }

        $res=FALSE;
        if ($logintype=="Admin")
        {
            if (isset($hash[ "Admin" ]))
            {
                if (preg_grep('/^'.$hash[ "Admin" ].'$/',$values))
                {
                    $res=TRUE;
                }
            }
            
            if (isset($hash[ "Person" ]))
            {
                if (preg_grep('/^'.$hash[ "Person" ].'$/',$values))
                {
                    $res=TRUE;
                }
            }
        }
        elseif ($logintype=="Person")
        {
            if (isset($hash[ $profile ]))
            {
                if (preg_grep('/^'.$hash[ $profile ].'$/',$values))
                {
                    $res=TRUE;
                }
            }

            if (isset($hash[ $logintype ]))
            {
                if (preg_grep('/^'.$hash[ $logintype ].'$/',$values))
                {
                    $res=TRUE;
                }
            }
        }
        elseif ($logintype=="Public")
        {
            if (isset($hash[ "Public" ]))
            {
                if (preg_grep('/^'.$hash[ "Public" ].'$/',$values))
                {
                    $res=TRUE;
                }
            }
        }

        return $res;
    }

    
    //*
    //* function MyHash_HashHashes_Find_First, Parameter list: $hashes,$where
    //*
    //* Returns first found item confirming 
    //*

    function MyHash_HashHashes_Find_First($hashes,$where)
    {
        foreach ($hashes as $id => $hash)
        {
            $found=TRUE;
            foreach ($where as $key => $value)
            {
                if ($hash[ $key ]!=$value)
                {
                    $found=FALSE;
                }
            }

            if ($found)
            {
                return $hash;
            }
        }
        
        return NULL;
    }
    
    //*
    //* function MyHash_Create_SubHashes_1, Parameter list: &$hash,$key1,$value=array()
    //*
    //* Creates one level hash $keys, with values $value.
    //*

    function MyHash_Create_KeyHashes_1(&$hash,$key1,$value=array())
    {
        if (!isset($hash[ $key1 ]))
        {
            $hash[ $key1 ]=array();
        }
    }
    
    //*
    //* function MyHash_Create_SubHashes_2, Parameter list: &$hash,$key1,$key2,$value=array()
    //*
    //* Creates 2 level hash $keys, with values $value.
    //*

    function MyHash_Create_KeyHashes_2(&$hash,$key1,$key2,$value=array())
    {
        $this->MyHash_Create_KeyHashes_1($hash,$key1,$value);
        $this->MyHash_Create_KeyHashes_1($hash[ $key1 ],$key2,$value);
    }
    
    //*
    //* function MyHash_Create_SubHashes_3, Parameter list: &$hash,$key1,$key2,$key3,$value=array()
    //*
    //* Creates 3 level hash $keys, with values $value.
    //*

    function MyHash_Create_KeyHashes_3(&$hash,$key1,$key2,$key3,$value=array())
    {
        $this->MyHash_Create_KeyHashes_2($hash,$key1,$key2,$value);
        $this->MyHash_Create_KeyHashes_1($hash[ $key1 ][ $key2 ],$key3,$value);
    }
    //*
    //* function MyHash_Create_SubHashes_4, Parameter list: &$hash,$key1,$key2,$key3,$key4,$value=array()
    //*
    //* Creates 4 level hash $keys, with values $value.
    //*

    function MyHash_Create_KeyHashes_4(&$hash,$key1,$key2,$key3,$key4,$value=array())
    {
        $this->MyHash_Create_KeyHashes_2($hash,$key1,$key2,$value);
        $this->MyHash_Create_KeyHashes_2($hash[ $key1 ][ $key2 ],$key3,$key4,$value);
    }
    
    //*
    //* function MyHash_Max, Parameter list: $hash
    //*
    //* Returns maximum value, looping over all keys.
    //*

    function MyHash_Max($hash)
    {
        $max=0;
        foreach ($hash as $key => $value) { $max=$this->Max($max,$value); }

        return $max;
    }
    
    //*
    //* function MyHash_Max, Parameter list: $hash
    //*
    //* Returns maximum value, looping over all keys.
    //*

    function MyHash_Level_2_SubHashes($hashes,$key1,$key2)
    {
        $rhashes=array();
        foreach ($hashes as $id => $hash)
        {
            $value1=$hash[ $key1 ];
            $value2=$hash[ $key2 ];
            
            if (empty($rhashes[ $value1 ]))
            {
                $rhashes[ $value1 ]=array();
            }

            $rhashes[ $value1 ][ $value2 ]=$hash;
        }

        return $rhashes;
    }
    
    
    //*
    //* function MyHash_List_Number, Parameter list: $items
    //*
    //* Creates 4 level hash $keys, with values $value.
    //*

    function MyHash_List_Number($items)
    {
        $n=1;
        foreach (array_keys($items) as $id)
        {
            array_unshift($items[ $id ],$n++);
        }

        return $items;
    }
    
    //*
    //* function MyHash_Keys_Take, Parameter list: $src,$keys,&$dest
    //*
    //* Takes undefined keys, $keys, in $dest from $src.
    //* Returns keys altered.
    //*

    function MyHash_Keys_Take($src,$keys,&$dest)
    {
        $changed=array();
        foreach ($keys as $key)
        {
            if (!empty($src[ $key ]) && empty($dest[ $key ]))
            {
                $dest[ $key ]=$src[ $key ];
                array_push($changed,$key);
            }
        }
    
        return $changed;
    }
    
    //*
    //* Filter $lines according to $hash. Pre adds $key.
    //*

    function MyHash_Filter($lines,$hash,$prekey="")
    {
        $datas=array();
        if ($hash) { $datas=array_keys($hash); }

        //Shortestm to be filtered first (#Line before #Lines)
        sort($datas);
        $datas=array_reverse($datas);

        //var_dump($datas);
        foreach ($datas as $data)
        {
            $value=$hash[ $data ];
            $rdata=$prekey.$data;

            if (!is_array($value))
            {
                $vvalue=preg_replace('/\\\\\\\\/',"__NEWLINE__",$value);
                $lines=preg_replace('/#'.$rdata.'\b/',$vvalue,$lines);
                $lines=preg_replace('/#'.$rdata.'_\b/',$vvalue."_",$lines);
                $lines=preg_replace('/__NEWLINE__/',"\\\\\\\\",$lines);
                while (preg_match("/#{([^}]+)}$rdata/",$lines,$matches))
                {
                    $format=$matches[1];
                    $value=sprintf($format,$value);

                    $format=preg_replace('/%/',"\\%",$format);
                    $lines=preg_replace('/'.$matches[0].'/',$value,$lines);
               }
            }
        }

        return $lines;
    }
    
    //*
    //* Filter $lines according to $hash. Pre adds $key.
    //*

    function MyHash_Filter_Hash($item,$hash,$prekey="")
    {
        foreach (array_keys($item) as $data)
        {
            if (is_string($item[ $data ]))
            {
                $item[ $data ]=$this->MyHash_Filter($item[ $data ],$hash,$prekey);
            }
        }

        return $item;
    }
    
    //*
    //* function MyHashes_Page, Parameter list: $list,$maxnitems,$ditem=1
    //*
    //* Splits a list in sublists, with max of $nlines per item.
    //*

    function MyHashes_Page($list,$maxnitems,$ditem=1)
    {
        $items=array();
        $plist=array();
        $nitems=0;
        foreach ($list as $id => $item)
        {
            $nitems+=$ditem;
            if ($nitems<=$maxnitems)
            {
                array_push($items,$item);
            }
            else
            {
                array_push($plist,$items);
                $items=array($item);
                $nitems=$ditem;
            }
        }

        if (count($items)>0)
        {
            array_push($plist,$items);
        }

        return $plist;
    }
    
    
    //*
    //* function MyHashes_Files_Show, Parameter list: $hashes
    //*
    //* Displays $hashes key and File entry, for each hash.
    //*

    function MyHashes_Files_Show($hashes)
    {
        $rfiles=array();
        foreach ($hashes as $data => $hash)
        {
            if (!empty($hash[ "File" ]))
            {
                $files=$hash[ "File" ];
                if (!is_array($files)) { $files=array($files); }

                foreach ($files as $rfile)
                {
                    $rfiles[ $rfile ]=TRUE;
                }
            }
            //else { var_dump(); }
            
        }

        $files=array_keys($rfiles);

        $table=array();
        foreach ($hashes as $key => $hash)
        {
            $row=array($this->B($key.":"));

            $rfiles=array();
            if (!empty($hash[ "File" ]))
            {
                $rrfiles=$hash[ "File" ];
                if (!is_array($rrfiles)) { $rrfiles=array($rrfiles); }

                foreach ($rrfiles as $file) { $rfiles[ $file ]=TRUE; }
            }
            
            foreach ($files as $file)
            {
                $cell="-";
                if (!empty($rfiles[ $file ]))
                {
                    $cell="x";
                }

                array_push($row,$cell);
            }
            
            array_push($table,$row);
        }

        $titles=$files;
        array_unshift($titles,"Data");
        
        echo
            $this->Html_Table
            (
               $titles,
               $table
            ).
            "";
    }

    
    //*
    //* function MyHashes_Key_Make_First, Parameter list: $list,$key
    //*
    //* Tries to put $key first in $list. That is, if there.
    //* Uses regex for comparison.
    //*

    function MyHashes_Key_Make_First($list,$key)
    {
        $len=count($list);
        $list=preg_grep('/^'.strval($key).'$/',$list,PREG_GREP_INVERT);
        if (count($list)!=$len)
        {
            array_unshift($list,intval($key));
        }

        return $list;
    }
    
    //*
    //* function MyHashes_Search, Parameter list: $list,$key,$debug=False
    //*
    //* Returns list of $items, confirming to $where.
    //*

    function MyHashes_Search($items,$where,$debug=False)
    {
        foreach (array_keys($where) as $key)
        {
            $values=$where[ $key ];
            if (!is_array($where[ $key ])) { $where[ $key ]=array($where[ $key ]); }
            foreach (array_keys($where[ $key ]) as $id)
            {
                $where[ $key ][ $id ]=$this->Html2Sort(strtolower($where[ $key ][ $id ]));
                
            }
            
        }
        
        $ritems=array();
        foreach (array_keys($items) as $id)
        {
            if ($this->MyHash_Match($items[ $id ],$where,$debug))
            {
                array_push($ritems,$items[ $id ]);
            }
        }

        return $ritems;
    }
    
    //*
    //* function MyHash_Match, Parameter list: $list,$key,$debug=False
    //*
    //* Tests whether $item matches $where.
    //*

    function MyHash_Match($item,$where,$debug=False)
    {
        $match=True;
        $unmatchkey="";
        foreach ($where as $key => $values)
        {
            if (is_int($values))
            {
                if (!empty($item[ $key ]))
                {
                    $ivalue=intval($item[ $key ]);
                    if ($ivalue!=$values)
                    {
                        $match=False;
                    }
                }
            }
            else
            {
                if (!is_array($values))
                {
                    $values=array($values);
                }

                if (isset($item[ $key ]))
                {
                    $ivalue=
                        preg_replace
                        (
                            '/\//',
                            '',
                            $this->Text2Sort
                            (
                                $this->Html2Sort($item[ $key ])
                            )
                        );

                    $match=False;
                    foreach ($values as $rkey => $rvalue)
                    {
                        if (preg_match('/'.$rvalue.'/i',$ivalue))
                        {
                            $match=True;
                            break;
                        }
                    }                
                }
                else
                {
                    $match=False;
                    break;
                }
            }

            if (!$match)
            {
                $unmatchkey=$key;
                break;
            }
        }

        return $match;
    }
    
    //*
    //* function MyHash_Default, Parameter list: $hash,$key,$default=""
    //*
    //* Returns $hash $key value or $default.
    //*

    function MyHash_Default($hash,$key,$default="")
    {
        if (isset($hash[ $key ])) { $default=$hash[ $key ]; }

        return $default;
    }
    
    //*
    //* function MyHash_Dump, Parameter list: $hash,$keys=array()
    //*
    //* Returns $hash $key value or $default.
    //*

    function MyHash_Dump($hash,$keys,$rindent="",$indent="")
    {
        if (empty($keys)) { $keys=array_keys($hash); }

        $texts=array();
        foreach ($keys as $key)
        {
            if (is_array($hash[ $key ]))
            {
                $indent.=$rindent;
                array_push
                (
                    $texts,
                    $indent.$key." => "
                );
                
                $texts=
                    array_merge
                    (
                        $texts,
                        $this->MyHash_Dump
                        (
                            $hash[ $key ],
                            array(),
                            $rindent,$indent
                        )
                    );
            }
            else
            {
                array_push
                (
                    $texts,
                    $indent.$key." => ".$hash[ $key ]
                );
            }
        }

        return $texts;
    }
    //*
    //* Returns html table with rows of key values.
    //*

    function MyHash_Table($hash,$title="")
    {
        if (!is_array($hash)) { return array(); }
        
        $table1=$table2=array();
        
        if (!empty($title)) { array_push($table1,$title); }
        
        foreach (array_keys($hash) as $key)
        {
            if (is_array($hash[ $key ]))
            {
                array_push
                (
                    $table2,
                    array($key,)
                );
                
                array_push
                (
                    $table2,
                    array
                    (
                        "",
                        $this->MyHash_Table
                        (
                            $hash[ $key ]
                        )
                    )
                );
            }
            else
            {
                array_push
                (
                    $table1,
                    array($key,$hash[ $key ])
                );
            }
        }

        return
            $this->Htmls_Table("",array_merge($table1,$table2));
    }

    
    //*
    //* function MyHash_Order, Parameter list: $hashes,$key
    //*
    //* Returns $hash $key value or $default.
    //*

    function MyHash_Order_Hashes_Keys($hashes,$orderkey,$nonemptykey="",$nonemptyvalue="")
    {
        $keys=array();
        
        $order=0;
        foreach (array_keys($hashes) as $key)
        {
            if
                (
                    !empty($nonemptykey)
                    &&
                    isset($hashes[ $key ][ $nonemptykey ])
                    &&
                    empty($hashes[ $key ][ $nonemptykey ])
                )
            {
                continue;
            }
            
            $rorder=$order;
            if (!empty($hashes[ $key ][ $orderkey ]))
            {
                $rorder=$hashes[ $key ][ $orderkey ];
            }

            #Avoid multiple defs, when keys are same.
            while (!empty($keys[ $rorder ])) { $rorder++; }
            $keys[ $rorder ]=$key;
            
            $order++;
        }
        
        $orders=array_keys($keys);
        sort($orders,SORT_NUMERIC);

        $rhashes=array();
        foreach ($orders as $order)
        {
            array_push($rhashes,$keys[ $order ]);
        }

        return $rhashes;
        
    }

    
    //*
    //* Returns $hash $keys as (sub)hash.
    //*

    function MyHash_Values_Get_Hash($hash,$keys)
    {
        if (!is_array($keys)) { $keys=array($keys); }
        
        $values=array();
        foreach ($keys as $key)
        {
            $values[ $key ]=$hash[ $key ];
        }

        return $values;
    }
    
    //*
    //* Zeroes hash keys in $keys.
    //* Changes hash and Rrturns list of keys altered.
    //*

    function MyHash_Keys_Zero(&$hash,$keys,$zero=0)
    {
        $modkeys=array();
        foreach ($keys as $key)
        {
            if ($hash[ $key ]!=$zero)
            {
                $hash[ $key ]=$zero;
                array_push($modkeys,$key);
            }
        }

        return $modkeys;
    }

    //*
    //* function MyAction_Access_Method_Apply, Parameter list: $action
    //*
    //* Checks if we have  module access - returns TRUE/FALSE.
    //* Uses $profiledef[ $module ][ "Access" ] to assess if allowed.
    //* If $module is empty or not given, uses $this->ModuleName as module.
    //*

    function MyHash_Access_Method_Apply($data,$def,$item)
    {
        if (empty($def[ "AccessMethod" ])) { return True; }
        $accessmethods=$def[ "AccessMethod" ];
        if (!is_array($accessmethods)) { $accessmethods=array($accessmethods); }

        $res=True;
        foreach ($accessmethods as $accessmethod)
        {
            if (method_exists($this,$accessmethod))
            {
                $res=$this->$accessmethod($item,$data,$def);
            }
            //try application obj for permissions
            elseif (method_exists($this->ApplicationObj(),$accessmethod))
            {
                $res=$this->ApplicationObj()->$accessmethod($item,$data);
            }
            else
            {
                var_dump($ritem);
                $this->MyAction_Error
                (
                    $this->ModuleName.": Warning: Invalid access method: ".
                    $accessmethod."(\$item,\$data), ignored",
                    $item
                );
            }

            if (!$res) { return False; }
        }

        return $res;
    }
    
    //*
    //* Run html_rentities_decode recursively, nested lists behavior.
    //*

    function MyHash_Html_Entities_Decode($message)
    {
        $rmessage=array();
        if (is_array($message))
        {
            foreach ($message as $key => $value)
            {
                $rmessage[ $key ]=$this->MyHash_Html_Entities_Decode($value);
                    
            }
        }
        else
        {
            $rmessage=html_entity_decode($message);
        }

        return $rmessage;
    }
    
    //*
    //* Run html_rentities_decode recursively, nested lists behavior.
    //*

    function MyHash_Pre_Key($hash,$prekey)
    {
        $rhash=array();
        foreach ($hash as $key => $value)
        {
            $rhash[ $prekey.$key ]=$value;
        }

        return $rhash;
    }
    
    //*
    //* Transposes array (matrix).
    //*

    function MyHash_Transpose($hash)
    {
        $rhash=array();
        foreach ($hash as $row => $cells)
        {
            foreach ($cells as $col => $cell)
            {
                $rhash[ $col ][ $row ]=$cell;
            }
        }

        return $rhash;
    }

    
    //*
    //* Transposes array (matrix).
    //*

    function MyHash_Prepend($list,$pre,$post=0,$empty="")
    {
        $max=$pre;

        $pre=array();
        for ($n=0;$n<$max;$n++)
        {
            array_push($pre,$empty);
        }
        
        $max=$post;

        $post=array();
        for ($n=0;$n<$max;$n++)
        {
            array_push($post,$empty);
        }
        
        foreach (array_keys($list) as $id)
        {
            if (isset($list[ $id ][ "Row" ]))
            {
                $list[ $id ][ "Row" ]=array_merge($pre,$list[ $id ][ "Row" ],$post);
            }
            else
            {
                $list[ $id ]=array_merge($pre,$list[ $id ],$post);
            }
        }

        return $list;
    }

    
    //*
    //* 
    //*

    function MyHash_Row($item,$datas=array())
    {
        if (empty($datas)) {$datas=array_keys($item); }
        
        $row=array();
        foreach ($datas as $data) { array_push($row,$data."=".$item[ $data ]); }

        return $row;
    }
    
    //*
    //* 
    //*

    function MyHash_Row_Line($item,$datas=array(),$sep="\t",$end="\n")
    {
        return join($sep,$this->MyHash_Row($item,$datas)).$end;
    }
    
    //*
    //* 
    //*

    function MyHashes_Table($items,$datas,$sep="\t",$format="%s")
    {
        $titles=array();
        foreach ($datas as $data)
        {
            array_push
            (
                $titles,
                sprintf($format,$data)
            );
        }
        
        $text=array(join($sep,$titles));
        foreach ($items as $item)
        {
            $row=array();
            foreach ($datas as $data)
            {
                array_push
                (
                    $row,
                    sprintf($format,$item[ $data ])
                );
            }
            
            array_push($text,join($sep,$row));
        }

        return $text;
    }
    
    //*
    //* 
    //*

    function MyHash_List_Join($list,$join)
    {
        $rlist=array(array_shift($list));
        foreach ($list as $item)
        {
            array_push
            (
                $rlist,
                $join,
                $item
            );
        }

        return $rlist;
    }
    
    //*
    //* 
    //*

    function MyHashes_Key_Sum($items,$key)
    {
        $sum=0;
        foreach ($items as $item) { $sum+=$item[ $key ]; }

        return $sum;
    }
    
    //*
    //* Join table by rows (making it wider).
    //*

    function MyHashes_Table_Join($nrows,$table)
    {

        $nrow=0;
        
        $rtable=array();
        $rrow=array();
        foreach ($table as $row)
        {
            if (!is_array($row)) { continue; }
            
            $nrow++;
            $rrow=array_merge($rrow,$row);
            
            if ($nrow>=$nrows)
            {
                array_push($rtable,$rrow);

                $rrow=array();
                $nrow=0;
            }
        }

        if (count($rrow)>0)
        {
            array_push($rtable,$rrow);
        }

        return $rtable;
    }
}
?>