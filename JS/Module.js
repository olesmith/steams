"use strict";

function Show_Hide_Module_Buttons(module,action,display,id,reloadcolor="")
{
    let color='red';
    
    let display1="block";
    if (display!="none")
    {
        if (id>0)
        {
            id=" "+id;
        }
        else { id=""; }

        
        let show="_Show_ "+module+id;
        let hide="_Hide_ "+module+id;
        let hide_button=hide+" "+action;
        let show_button=show+" "+action;
       

        //Turn on all actions show buttons
        Show_Elements_By_Class(show,display1);
        
        
        //Turn off all actions hide buttons
        Hide_Elements_By_Class(hide);
 
        //Turn on specific action hide button
        Show_Elements_By_Class(hide_button,display1);
        
        //Turn off specific show button
        Hide_Elements_By_Class(show_button);
    }
    else
    {
        let class1="_Show_ "+module+" "+action;
        let class2="_Hide_ "+module+" "+action;
        if (id>0)
        {
            class1=class1+" "+id;
            class2=class2+" "+id;
        }
        
        Show_Elements_By_Class(class1,display1,reloadcolor);
        Hide_Elements_By_Class(class2);
        
    }
}
function Load_Item_Module_Action(hide,url,id,module,action,insert_id,row_id,display,hide_ids,reloadcolor="")
{
    if (url in Loaded_URLs)
    {
        console.log("Reload (ignored):",module,action);
        //console.table(Parse_URL(url));
        
        //Console_Log(display);
    }
    else
    {
        Loaded_URLs[ url ]=1;
        
        url=url.concat("&RAW=1");
        Show_Load_URL_2_Element(url,insert_id,row_id,display);
    }

    let show_ids=[];
    let show_rids=[];
    
    if (hide)
    {
        hide_ids.push(row_id,insert_id);
    }
    else
    {
        show_ids.push(insert_id);
        show_rids.push(row_id);
    }

    Show_Hide_Module_Buttons(module,action,display,id,reloadcolor);

    //console.log(action,hide,"Hide:");
    //console.table(hide_ids,"Show");
    //console.table(show_ids);
    Hide_Elements_By_ID(hide_ids);
    Show_Elements_By_ID(show_ids,display);
    Show_Elements_By_ID(show_rids,'table-row');
}


function Load_Module_Action(url,module,action,insert_id,hide_id,display,reloadcolor="")
{
    //console.clear();
    //console.log("Load");
    
    url=url.concat("&RAW=1");    
    Show_Load_URL_2_Element(url,insert_id,hide_id,display);
    
    Show_Hide_Module_Buttons(module,action,display,0,hide_id,reloadcolor);    
}
 
