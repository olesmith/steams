"use strict";


function HorMenu_Actions_Set(modulename,visible,action,actions,shows,hiddens,newcolor="")
{
    let toshow=[];
    let tohide=[];
    for (let n=0;n<actions.length;n++)
    {
        if (action==actions[n])
        {
            //current action
            for (let m=0;m<hiddens.length;m++)
            {
                let id=modulename+"_"+actions[n]+"_"+hiddens[m];
                tohide.push(id);
            }
            
            for (let m=0;m<shows.length;m++)
            {
                let id=modulename+"_"+actions[n]+"_"+shows[m];
                toshow.push(id);
            }
        }
        else
        {
            for (let m=0;m<hiddens.length;m++)
            {
                let id=modulename+"_"+actions[n]+"_"+hiddens[m];
                toshow.push(id);
            }
            
            for (let m=0;m<shows.length;m++)
            {
                let id=modulename+"_"+actions[n]+"_"+shows[m];
                tohide.push(id);
            }
        }
    }

    //Console_Log("To hide: "+tohide.length+": "+tohide.join(", "));
    //Console_Log("To show: "+toshow.length+": "+toshow.join(", "));
    
    Hide_Elements_By_ID(tohide,"initial");
    Show_Elements_By_ID(toshow,"initial",newcolor);
    //Console_Log("HorMenu_Actions_Set done");
}

