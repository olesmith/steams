function goto(site,title)
{
   var msg = confirm(title)
   if (msg) {window.location.href = site}
   else (null)
}
               
               
$(document).ready(function(){
    $('#select_1').on('click',function(){
        if(this.checked){
            $('.checkbox_1').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_1').each(function(){
                this.checked = false;
            });
        }
    });
    
               
    $('.checkbox_1').on('click',function(){
        if($('.checkbox_1:checked').length == $('.checkbox').length){
            $('#select_1').prop('checked',true);
        }else{
            $('#select_1').prop('checked',false);
        }
    });

               
    $('#select_2').on('click',function(){
        if(this.checked){
            $('.checkbox_2').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_2').each(function(){
                this.checked = false;
            });
        }
    });
    

    $('.checkbox_2').on('click',function(){
        if($('.checkbox_2:checked').length == $('.checkbox').length){
            $('#select_2').prop('checked',true);
        }else{
            $('#select_2').prop('checked',false);
        }
    });
});

                         
function Do_Show_Element_By_ID(elementid,display)
{
    var x = document.getElementById(elementid);
    x.style.display = display;
}

function Do_Hide_Element_By_ID(elementid)
{
    var x = document.getElementById(elementid);
    x.style.display = "none";
}


function Do_Show_Element(x)
{
    x.style.display = "table-row";
}

function Do_Hide_Element(x)
{
    x.style.display = "none";
}


function Do_Show_Elements_By_ID(divid) {
    var x = document.getElementById(divid);
    Do_Show_Element(x);
}

function Do_Hide_Elements_By_ID(divid) {
    var x = document.getElementById(divid);
    Do_Hide_Element(x);
}


function Do_Show_Elements(xs) {
    for (var n = 0; n < xs.length; n++) {
        xs[n].style.display = "";
    }
}

function Do_Hide_Elements(xs) {
    for (var n = 0; n < xs.length; n++) {
        xs[n].style.display = "none";
    }
}

//Must be within form to work - "Hide_".clss must be input (hidden)
function Save_State_Element_By_CLASS(clss,value) {
    var rclss="Hide_";
    rclss=rclss.concat(clss);
    document.getElementById(rclss).value=value;
}

function Do_Show_Elements_By_CLASS(clss) {
    var xs = document.getElementsByClassName(clss);
    Do_Show_Elements(xs);
    Save_State_Element_By_CLASS(clss,0);
}

function Do_Hide_Elements_By_CLASS(clss) {
    var xs = document.getElementsByClassName(clss);
    Do_Hide_Elements(xs);
    Save_State_Element_By_CLASS(clss,1);
}
 
 
function Load_URL_to_Element_Do(url,cell_id)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            var elment = document.getElementById(cell_id);

            if (elment)
            {            
                elment.innerHTML=this.responseText;

                //Fetched document should include a SCRIPT section
                var scripts = elment.getElementsByTagName("SCRIPT");

                if (scripts.length>0)
                {
                    var script=scripts[0];
                    var scr = document.createElement("SCRIPT");

                    //console.log(scr.innerHTML);
                    if (scr)
                    {
                        scr.innerHTML = script.innerHTML;
                        document.body.appendChild(scr);
                    }
                }
            }
            else
            {
                console.dir("Cell not found");
                console.dir(cell_id);
            }
        }

    };

    xhttp.open("GET",url,true);
    //*** xhttp.responseType = "document";
    xhttp.send();
}


//*
//* Parameters:
//*
//* url:        Url to load and place in element element_id.
//* element_id: Unique id of element where to insert url contents.
//* cgi-id:     ID of form hidden var (CGI), to contain control values, 0, 1 and 2.
//*             0: Should be inicialized by a <script>...</script> call to Load_URL_to_Element_Init.
//*             1: Has loaded url, no need to load anymore (will toggle between 1 and 2)
//*             2: Url loaded, by has been hidden by user.
//* dsplay:     Type of display to use when making visible.
//* hide_id:    If given, is used as the element to hide, when toggling visibility - else element_id is toggled.
//*

function Load_URL_to_Element(url,element_id,cgi_id,dsplay,hide_id)
{
    if (hide_id==undefined)
    {
        hide_id=element_id;
    }

    
    var cgi = document.getElementById(cgi_id);
    var elment = document.getElementById(hide_id);

    var v=cgi.value;
    if (v=='0')
    {
        Load_URL_to_Element_Do(url,element_id);
        elment.style.display = dsplay;
        cgi.value='1';
    }
    else if (v=='1')
    {
        cgi.value='2';
        elment.style.display = "none";        
    }
    else if (v=='2')
    {
        cgi.value='1';
        elment.style.display = dsplay;        
    }
}
 
function Load_URL_to_Element_Init(url,element_id,cgi_id,dsplay,hidden_id)
{
    var cgi = document.getElementById(cgi_id);
    cgi.value='0';
}

function Always_Load_URL_to_Element(url,display_id,insert_id,display,hide_id)
{
    if (hide_id==undefined)
    {
        hide_id=display_id;
    }

    
    Load_URL_to_Element_Do(url,insert_id);
    
    var element = document.getElementById(hide_id);
    
    current_display=element.style.display;
    if (current_display=='none')
    {
        element.style.display = display;
    }
    else
    {
        element.style.display ='none';
    }

    //window.alert(display.concat(':',display_id));
}
 
function Show_URL_to_Class(url,display_id,insert_id,display,hide_id)
{
    if (hide_id==undefined)
    {
        hide_id=display_id;
    }

    
    Load_URL_to_Element_Do(url,insert_id);
    
    var element = document.getElementById(hide_id);
    current_display=element.style.display;
    element.style.display = display;
}
 
function Update_URL_to_Element(url,cell_id,form_id)
{
    console.clear();
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            console.log(url,cell_id,form_id);
            
            console.table(this.responseText);
            
            var elment = document.getElementById(cell_id);
            elment.innerHTML=this.responseText;

            //cell_element=
            //    document.getElementById(cell_id);
            
                 //Fetched document should include a SCRIPT section
            //var scripts =
            //   cell_element.getElementsByTagName("SCRIPT");

           //console.log("Update_URL_to_Element inner");
           //console.table(scripts);
                //if (scripts.length>0)
                //{
                //    var script=scripts[0];
                //    var scr = document.createElement("SCRIPT");

                    //console.log(scr.innerHTML);
                //    if (scr)
                //    {
                        //scr.innerHTML = script.innerHTML;
                        //document.body.appendChild(scr);
                //    }
                //}
        }

    };

    xhttp.open("POST",url,true);
    //window.alert(form_id);
    
    
    console.log("Sending form ID: "+form_id);
    var form_elm=document.getElementById(form_id);
    var form_data=new FormData(form_elm);
    
    xhttp.send(form_data);


    return false;
}

