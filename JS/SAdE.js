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

var School=Get_Key(parms_start,"School");


function Register_URL(url)
{
    let parms = new URLSearchParams(url);

    let update=false;
    let unit=Get_Key(parms,"Unit");
    let school=Get_Key(parms,"School");
    if (school!=School)
    {
        update=true;
    }
    
    if (update)
    {
        let lurl="?Unit="+unit+"&Action=Top";
        if (school!="0")
        {
            lurl=lurl+"&School="+school;
        }
       
        School=school;
        
        Load_URL_2_Element_Do("TOP",lurl);
    }
}

function Show_Sponsors(elementid,type,nmax,unit,school=0)
{
    //type: Logo or Banner
    console.log(elementid);
    let parms = new URLSearchParams();

    //let unit=Get_Key(parms,"Unit");
    //let school=Get_Key(parms,"School");
    console.log("Unit/school",unit,school);
    
    let url=
        "?"+
        "Type="+type+
        "&"+
        "N="+nmax+
        "&"+
        "Unit="+unit+
        "&"+
        "RAW=1"+
        "&"+
        "NoHorMenu=1"+
        "&"+
        "Dest="+elementid+
        "&"+
        "School="+school+
        "&"+
        "ModuleName=Sponsors"+
        "&"+
        "Action=Sponsors";

    console.log(url);
    Load_URL_2_Element_Do(elementid,url);
}
