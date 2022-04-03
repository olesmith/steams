"use strict";

function String2Hash(text)
{
    text=text.substring(1);
    let comps=text.split("&");

    let hash={};
    for (let n=0;n<comps.length;n++)
    {
        let comp=comps[n].split("=");
        hash[ comp[0] ]=comp[1];
    }

    return hash;
}


function Send_Form_URL(element,url)
{
    Register_Time("Send_Form_URL");

   
    let form_element=element.closest("form");

    let args=String2Hash(url);
    console.log(args);
    for (let key in args)
    {
        let input=document.createElement("input");
        input.name=key;
        input.setAttribute("type", "hidden");
        
        input.value=args[ key ];
        form_element.appendChild(input);
    }

    
    form_element.submit();
}

function Select_Send(element,url,dest_id)
{
    let rurl=Url2Hash(url);
    
    rurl[ element.name ]=element.value;
    
    let rrurl=Hash2Get(rurl);
    
    console.log(url);  
    console.log(rrurl);  
    console.log(dest_id);  
    Load_URL_2_Element_Do(dest_id,rrurl);
    console.log("back");
}
