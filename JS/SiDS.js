"use strict";
function Detect_Rooms()
{
   let elements=document.getElementsByTagName("TR");

    let roomids=[];
    for (let n = 0; n < elements.length; n++)
    {
        let match;
        if (match=elements[n].id.match('^Room_([0-9]+)'))
        {
            roomids.push(match[1]);
        }
    }

    return roomids;
}

function Load_Building_Schedule(building,wday,shift)
{
    hash=GET2Hash();

    hash[ "ModuleName" ]="Lessons";
    hash[ "Action" ]="JSON";
    hash[ "GroupName" ]="Reserve";
    hash[ "Building" ]=building;
    hash[ "WeekDay" ]=wday;
    hash[ "Shift" ]=shift;
    hash[ "RAW" ]=1;
    hash[ "Export" ]=5;//JSON

    url=Hash2Get(hash);
    if (url in Loaded_URLs)
    {
        Console_Log("Already loaded");
    }
    else
    {
        Console_Log("Load");

        Url_Response_Read_Building_Schedule(url);
        Loaded_URLs[ url ]=1;
    }

    //console.table(Hash2Get(hash));
}

function Url_Response_Read_Building_Schedule(url)
{
    let date=new Date();
    let start=date.getTime();
    
    Console_Log(url);
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            let lessons=JSON.parse(this.responseText);

            lessons=lessons.Lessons;

            console.log(lessons.length+" lessons");
            Url_Response_Parse_Building_Lessons(lessons);
            
            
            date=new Date();
            let runtime=date.getTime()-start;
            console.log(runtime/1000,"s");
            
            
            return this.responseText;
        }
    };

    xhttp.open("GET",url,true);
    xhttp.send();

    return "Invalid response";
}

function Url_Response_Parse_Building_Lessons(lessons)
{
    for (let n=0;n<lessons.length;n++)
    {
        Url_Response_Parse_Building_Lesson(lessons[n]);
    }
}

function Url_Response_Parse_Building_Lesson(lesson)
{
    id=
        [
            "Schedule",
            lesson.Room,
            lesson.WeekDay,
            lesson.Hour
        ].join("_");

    
    let element = Get_Element_By_ID(id);
    if (element)
    {
        //console.log("Element "+id+" found");
        element.innerHTML=lesson.Content;
        element.innerHTML.verticalAlign = "middle"; 
    }
    else
    {
        console.log("Element "+id+" not found");
    }
}
