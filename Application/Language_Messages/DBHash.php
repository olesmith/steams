<?php

class Language_Messages_DBHash extends Language_Messages_CLI
{
    #Store sperate connection
    var $_DB_Hash_=array();

    //* DBHash accessor. Reads once only.
    //*

    function DBHash($key="")
    {
        if (empty($this->_DB_Hash_))
        {
            //Read DB definitions, once only
            $this->_DB_Hash_=$this->ApplicationObj()->DBHash;
            //Overwrite keys preceded by Message_
            foreach
                (
                    preg_grep
                    (
                        '/^Message_/',
                        array_keys($this->_DB_Hash_)
                    )
                    as $mdata
                )
            {
                $data=preg_replace('/Message_/',"",$mdata);
                
                if (!empty($this->_DB_Hash_[ $mdata ]))
                {
                    $this->_DB_Hash_[ $data ]=
                        $this->_DB_Hash_[ $mdata ];
                    unset($this->_DB_Hash_[ $mdata ]);
                }
            }

            //Connect - or die
            $this->DB_Connect($this->_DB_Hash_);
        }

        
        if (!empty($key)) { return $this->_DB_Hash_[ $key ]; }
        else              { return $this->_DB_Hash_; }
    }
    
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //*

    function SqlTableName($table="")
    {
        return $this->DBHash("Table");
    }
   
}

?>