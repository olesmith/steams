"use strict";



function Clip_Board_Copy_URL(url)
{
    Register_Time("Clip_Board_Copy_URL");

    navigator.clipboard.writeText(url);
    console.log(url);
}
