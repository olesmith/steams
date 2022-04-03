"use strict";

var  url_start= window.location.search;
var parms_start = new URLSearchParams(url_start);


function Get_Key(parms,key)
{
    let value="0";
    if (parms.has(key))
    {
        value=parms.get(key);
    }
    
    return value;
}

var Tournament=Get_Key(parms_start,"Tournament");
var Season=Get_Key(parms_start,"Season");
var Pool=Get_Key(parms_start,"Pool");


function Register_URL(url)
{
    let parms = new URLSearchParams(url);

    let update=false;
    let mobile=Get_Key(parms,"Mobile");
    let tournament=Get_Key(parms,"Tournament");
    if (tournament!=Tournament)
    {
        update=true;
    }
    
    let season=Get_Key(parms,"Season");
    if (season!=Season)
    {
        update=true;
    }
    
    let pool=Get_Key(parms,"Pool");
    if (pool!=Pool)
    {
        update=true;
    }

    
    if (mobile!=1 && update)
    {
        let lurl="?Action=Top";
        if (tournament!="0")
        {
            lurl=lurl+"&Tournament="+tournament;
        }
        if (season!="0")
        {
            lurl=lurl+"&Season="+season;
        }
        
        if (pool!="0")
        {
            lurl=lurl+"&Pool="+pool;
        }

        Tournament=tournament;
        Season=season;
        Pool=pool;
        
        console.log(lurl);
        Load_URL_2_Element_Do("TOP",lurl);
    }
}
