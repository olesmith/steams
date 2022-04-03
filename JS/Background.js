"use strict";


var colors={}
var bg_colors={}

function Class_Background(clss,color,bg_color,maxlevels)
{
    let elements = document.getElementsByClassName(clss);
    Elements_Background(elements,color,bg_color,1,maxlevels);
}

function Elements_Background(elements,color,bg_color,level,maxlevels)
{
    for (let n=0;n<elements.length;n++)
    {
        colors[ elements[n].id ]=
            elements[n].style.color;
        
        bg_colors[ elements[n].id ]=
            elements[n].style.backgroundColor;
        
        elements[n].style.backgroundColor=bg_color;
        elements[n].style.color=color;
        if (level<maxlevels)
        {
            Elements_Background
            (
                elements[n].children,
                color,bg_color,
                level+1,maxlevels
            );
        }
    }
    
}

function Class_Background_Reset(clss,maxlevels)
{
    let elements = document.getElementsByClassName(clss);
    
    Elements_Background_Reset(elements,1,maxlevels);
}

function Elements_Background_Reset(elements,level,maxlevels)
{
    for (let n=0;n<elements.length;n++)
    {
        elements[n].style.color=
            colors[ elements[n].id ];
        
        elements[n].style.backgroundColor=
            bg_colors[ elements[n].id ];

        if (level<maxlevels)
        {
            Elements_Background_Reset(elements[n].children,level+1,maxlevels);
        }
    }
}
