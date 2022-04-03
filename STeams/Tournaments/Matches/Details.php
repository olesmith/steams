<?php

trait Tournament_Matches_Details
{
    //*
    //* 
    //*

    function Tournament_Match_Details_Handle($match=array())
    {
        if (empty($match)) { $match=$this->ItemHash; }
        
        
        //$this->MyMod_Handle_Show();
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Tournament_Match_Details(0,$match)
            )
        );
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Details($edit,$match)
    {
        $keys=
            array
            (
                "_Half","",
            );

        if ($match[ "Duration" ]>=3)
        {
            array_push($keys,"_Extra");
        }

        if ($match[ "Duration" ]>=4)
        {
            array_push($keys,"_Penalties");
        }

        $base="Goals";

        $table=
            array
            (
                array
                (
                    $this->Htmls_H
                    (
                        5,
                        array
                        (
                            $this->MyMod_Data_Field
                            (
                                $edit,$match,"Date"
                            ),
                            $this->MyMod_Data_Field
                            (
                                $edit,$match,"HHMM"
                            ),
                        )
                    ),
                )
            );

        $row=
            array
            (
                "",
                $this->Tournament_Match_Cell_Team_Icon_1(0,$match),
                $this->Tournament_Match_Cell_Team_Icon_2(0,$match),
            );
        

        array_push($table,$row);
        
        $row=
            array
            (
                "",
                $this->MyMod_Data_Field(0,$match,"Team1"),
                $this->MyMod_Data_Field(0,$match,"Team2"),
            );
        

        array_push($table,$row);
        foreach ($keys as $key)
        {
            $key1=$base."1".$key;
            $key2=$base."2".$key;

            $row=
                array
                (
                    $this->B
                    (
                        preg_replace
                        (
                            '/\S*#\S*/',
                            "",
                            $this->MyMod_Data_Title($key1)
                        ).
                        ":"
                    ),
                    $this->MyMod_Data_Field
                    (
                        $edit,$match,$key1
                    ),
                    $this->MyMod_Data_Field
                    (
                        $edit,$match,$key2
                    )
                );

            array_push($table,$row);
        }
        
        $base="Points";
        $key1=$base."1";
        $key2=$base."2";

        $row=
            array
            (
                $this->B
                (
                    preg_replace
                    (
                        '/\S*#\S*/',
                        "",
                        $this->MyMod_Data_Title($key1)
                    ).
                    ":"
                ),
                $this->MyMod_Data_Field
                (
                    $edit,$match,$key1
                ),
                $this->MyMod_Data_Field
                (
                    $edit,$match,$key2
                )
            );
        
        array_push
        (
            $table,
            array(),
            $row,
            array
            (
                $this->Htmls_H
                (
                    5,
                    array
                    (
                        $this->MyMod_Data_Field
                        (
                            $edit,$match,"Status"
                        ),
                    )
                )
            ),
            array($this->HR())
        );
        return
            array
            (
                $this->Htmls_Table
                (
                    array(),
                    $table
                )
            );
    }
}

?>
