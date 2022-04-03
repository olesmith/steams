"use strict";

//Number of milliseconds in  Grace period
var Grace=60   *60*1000;

var Active=true;
var MTime=Date.now();

function Grace_Init(grace=0)
{
    if (grace>0) { Grace=grace; }
    
    let date = new Date();

    let hours=date.getHours();
    let mins =date.getMinutes();
    let secs =date.getSeconds();

    if (hours<10) { hours="0"+hours; }
    if (mins<10)  { mins="0"+mins; }
    if (secs<10)  { secs="0"+secs; }

    
    //console.log
    //(
    //    "Grace initialized at",
    //    date.getHours()+
    //        ":"+
    //        date.getMinutes()+
    //        ":"+
    //        date.getSeconds(),
    //    "Grace:",
    //    Grace/(60*1000),"min",
    //);
}

Grace_Init();


function Register_Time(fnc)
{
    let sid=getCookie("SID");
    if (sid)
    {
        if (!Active)
        {
            Active=true;
            //console.log("Activating");
        }
    }
    else
    {
        if (Active)
        {
            Active=false;
            //console.log("Deactivating");
        }
    }

    MTime=Date.now();
    //console.log("Grace Update:",fnc,MTime,Active);
}


function setCookie(cname, cvalue, exdays)
{
    let d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie =
        cname + "=" + cvalue + ";" +
        expires + ";path=/;samesite=strict;";
}

function getCookie(cname)
{
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++)
    {
        var c = ca[i];
        while (c.charAt(0) == ' ')
        {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0)
        {
            return c.substring(name.length, c.length);
        }
  }
  return "";
}

var Register = setInterval
(
    function()
    {
        if (!Active) { return; }

        let elapsed=Date.now()-MTime;

        
        if (elapsed>Grace)
        {
            setCookie("SID",-1,1);
            
            window.location.reload();
            Active=false;
            alert("60 Minutes of Inactivity: Logging Out");
            
            console.log("Limit",elapsed);
            
        }
        //console.log("Elapsed",elapsed);
    },
    10000 //300//periodicity for checking
);


