var dropdowncompleted = 0;
function popupLeftPosition(popup_width){var myWidth=0,outputWidth;if(typeof(window.innerWidth)=='number'){myWidth=window.innerWidth;}else if(document.documentElement && (document.documentElement.clientWidth)){myWidth=document.documentElement.clientWidth;}else if(document.body && (document.body.clientWidth)){myWidth=document.body.clientWidth;}outputWidth=(myWidth/2)-(popup_width/2);outputWidth=outputWidth;return outputWidth;}