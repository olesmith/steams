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

//Store values on load
var App=Get_Key(parms_start,"App");
var Unit=Get_Key(parms_start,"Unit");
var City=Get_Key(parms_start,"City");
var Semester=Get_Key(parms_start,"Semester");


function Register_URL(url)
{
    let parms = new URLSearchParams(url);

    let update=false;
    
    let app=Get_Key(parms,"App");
    if (app!=App)
    {
        update=true;
    }
    
    let unit=Get_Key(parms,"Unit");
    if (unit!=Unit)
    {
        update=true;
    }
    
    let semester=Get_Key(parms,"Semester");
    if (semester!=Semester)
    {
        update=true;
    }
    
    let city=Get_Key(parms,"City");
    if (city!=City)
    {
        update=true;
    }
    
    if (update)
    {
        console.log(update,url);

        let lurl="?Action=Top";
        if (app!="0")
        {
            lurl=lurl+"&App="+app;
        }
        
        if (unit!="0")
        {
            lurl=lurl+"&Unit="+unit;
        }
        
        
        if (city!="0")
        {
            lurl=lurl+"&City="+city;
        }
        
        if (semester!="0")
        {
            lurl=lurl+"&Semester="+semester;
        }
        
        App=unit;
        Unit=unit;
        City=city;
        Semester=semester;
        
        console.log("Update TOP"+lurl);
        Load_URL_2_Element_Do("TOP",lurl);
    }
}
