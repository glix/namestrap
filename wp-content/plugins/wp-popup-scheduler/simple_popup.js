// JavaScript Document
var dropdowncompleted = 0;
function popupLeftPosition(popup_width){
	var myWidth = 0, outputWidth;

  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
  } else if( document.documentElement && ( document.documentElement.clientWidth) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
  } else if( document.body && ( document.body.clientWidth) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
  }
  	outputWidth = (myWidth / 2) - (popup_width / 2);
	outputWidth = outputWidth ;
	return outputWidth;
}

function popupTopPosition(){
  	var outputHeight, myHeight = 0;

  if( typeof( window.innerHeight ) == 'number' ) {
    //Non-IE
    myHeight = window.innerHeight;
  } else if( document.documentElement && (document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientHeight ) ) {
    //IE 4 compatible
    myHeight = document.body.clientHeight;
  }
	outputHeight = (myHeight / 2) - 50;
	outputHeight = outputHeight;
	return outputHeight;
}

function DropDownEffect(target, destinationTop, maxSpeed)
{	var currentTop = parseInt(target.style.top);
	if(isNaN(currentTop))	currentTop = 0;
	var dropSpeed = 1 + Math.abs(destinationTop - currentTop)/10;
	if(dropSpeed > maxSpeed) 	dropSpeed = maxSpeed;
	if(currentTop < destinationTop)
	{	currentTop += dropSpeed;
		if(currentTop > destinationTop)	currentTop = destinationTop;
	}else
	{	currentTop -= dropSpeed;
		if(currentTop < destinationTop)	currentTop = destinationTop;
	}
	target.style.top = parseInt(currentTop) + "px";
	if (currentTop == destinationTop)
	{	clearInterval(target.animation);
		dropdowncompleted  =1;
	}
}

//with courtesy of Richard Rutter from http://www.splintered.co.uk/experiments/archives/javascript_fade/fade.jsx
function fadeIn(target) 
{   if(target.fade == null) target.fade = 0;
	if (target.fade <= 100) {
			if (target.style.MozOpacity!=null) {
				/* Mozilla's pre-CSS3 proprietary rule */
				target.style.MozOpacity = (target.fade/100)-.001;
				/* the .001 fixes a glitch in the opacity calculation which normally results in a flash when reaching 1 */
			} else if (target.style.opacity!=null) {
				/* CSS3 compatible */
				target.style.opacity = (target.fade/100)-.001;
			} else if (target.style.filter!=null) {
				/* IE's proprietary filter */
				target.style.filter = "alpha(opacity="+target.fade+")";
				/* worth noting: IE's opacity needs values in a range of 0-100, not 0.0 - 1.0 */ 
			}
			target.style.visibility = "visible";
			target.fade += 5;
			if(target.fade>100)
			{	clearInterval(target.animation);
				dropdowncompleted  =1;
			}
	}
}

function getPageHeight() {
	var pagescroll,	winHeight;;
	
	if (window.innerHeight && window.scrollMaxY) {	
		pagescroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){
		pagescroll = document.body.scrollHeight;
	} else {
		pagescroll = document.body.offsetHeight;
	}
	if (self.innerHeight) {
		winHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
		winHeight = document.documentElement.clientHeight;
	} else if (document.body) { 
		windowHeight = document.body.clientHeight;
	}	
	if(pagescroll < winHeight){
		pageHeight = winHeight;
	} else { 
		pageHeight = pagescroll;
	}
	return pageHeight;
}

function lightbox(target)
{	if (target.style.MozOpacity!=null) {
			/* Mozilla's pre-CSS3 proprietary rule */
		target.style.MozOpacity = 0.8;
				/* the .001 fixes a glitch in the opacity calculation which normally results in a flash when reaching 1 */
	} else if (target.style.opacity!=null) {
				/* CSS3 compatible */
		target.style.opacity = 0.8;
	} else if (target.style.filter!=null) {
				/* IE's proprietary filter */
		target.style.filter = "alpha(opacity=80)";
				/* worth noting: IE's opacity needs values in a range of 0-100, not 0.0 - 1.0 */ 
	}
	target.style.visibility = "visible";
}

function check_dropdown(popupStyleTop)
{
	if(dropdowncompleted ==1)
	{	window.onscroll = function() {eval(start(popupStyleTop));}; }
	else	
	{	setTimeout("check_dropdown(popupStyleTop)",5);}
}

function loadPopup (popup_content,popup_bgcolor,popup_width,effect,popup_left,popup_top,delay,autoscroll){
	var popupId = "WPS_popup_message";
	var popupStyleLeft;
	if(popup_left == "center")
	{	popupStyleLeft = popupLeftPosition(popup_width); }
	else
	{	popupStyleLeft = popup_left; }
	popupStyleTop = popupTopPosition();
	if(popup_top != "center"){ popupStyleTop = popup_top; }
	var popupStyleBorder = "solid medium #000000";
	var popupStyleVisibility = "hidden";	
	pageheight = getPageHeight();
	document.write('<div id="lightbox_div" style="overflow:auto;width:100%;height:'+pageheight+'px;background-color:#000000;z-index:50;position:absolute;left:0px;top:0px;visibility:hidden"></div>');
	document.write('<div id="WPS_popup_message" class="wps_popup" style="margin:auto;width:'+popup_width+'px;background-color:'+popup_bgcolor+';z-index:100;position:absolute;left:'+popupStyleLeft+'px;top:-400px;visibility:'+popupStyleVisibility+'">'+html_entity_decode(popup_content)+'</div>');
	if(effect == "popup")
	{ 	document.getElementById('WPS_popup_message').style.top = popupStyleTop + "px";
		if(delay>0)
		{	setTimeout("document.getElementById('WPS_popup_message').style.visibility = 'visible'",delay); }
		else
		{	document.getElementById('WPS_popup_message').style.visibility = "visible"; }
		if(autoscroll==1)
		{
			window.onscroll = function() {eval(start(popupStyleTop));};
		}		
	}
	else if(effect == "dropdown")
	{	document.getElementById('WPS_popup_message').style.visibility = "visible";
		if(delay>0)
		{	setTimeout("document.getElementById('WPS_popup_message').animation = setInterval('DropDownEffect(document.getElementById(\"WPS_popup_message\"),popupStyleTop,10)',60)",delay);
		}else
		{	document.getElementById('WPS_popup_message').animation = setInterval('DropDownEffect(document.getElementById("WPS_popup_message"),popupStyleTop,10)',60);
		}
		if(autoscroll==1)
		{
			setTimeout("check_dropdown(popupStyleTop)",5);
		}
	}
	else if(effect == "fadein")
	{	document.getElementById('WPS_popup_message').style.top = popupStyleTop + "px";
		if(delay>0)
			{ setTimeout("document.getElementById('WPS_popup_message').animation = setInterval('fadeIn(document.getElementById(\"WPS_popup_message\"))',150)",delay); }
		else
			{ document.getElementById('WPS_popup_message').animation = setInterval('fadeIn(document.getElementById("WPS_popup_message"))',150);}
		if(autoscroll==1)
		{
			setTimeout("check_dropdown(popupStyleTop)",5);
		}	
	}
	else if(effect == "lightbox")
	{	//pageheight = getPageHeight();
		//document.write('<div id="lightbox_div" style="overflow:auto;width:100%;height:'+pageheight+'px;background-color:#000000;z-index:50;position:absolute;left:0px;top:0px;visibility:hidden"></div>');
		document.getElementById('WPS_popup_message').style.top = popupStyleTop + "px";
		if(delay>0)
		{	setTimeout("lightbox(document.getElementById('lightbox_div'))",delay);
			setTimeout("document.getElementById('WPS_popup_message').style.visibility = \"visible\"",delay);
		}
		else
		{	lightbox(document.getElementById('lightbox_div'));
			document.getElementById('WPS_popup_message').style.visibility = "visible";
		}
		if(autoscroll==1)
		{
			window.onscroll = function() {eval(start(popupStyleTop));};
		}
	} 
}
function html_entity_decode (string, quote_style) {
    var hash_map = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }
    delete(hash_map['&']);
    hash_map['&'] = '&amp;';

    for (symbol in hash_map) {
        entity = hash_map[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }
    tmp_str = tmp_str.split('&#039;').join("'");
    
    return tmp_str;
}

function get_html_translation_table (table, quote_style) {
    var entities = {}, hash_map = {}, decimal = 0, symbol = '';
    var constMappingTable = {}, constMappingQuoteStyle = {};
    var useTable = {}, useQuoteStyle = {};
    
    // Translate arguments
    constMappingTable[0]      = 'HTML_SPECIALCHARS';
    constMappingTable[1]      = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';

    useTable       = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT';

    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error("Table: "+useTable+' not supported');
        // return false;
    }

    entities['38'] = '&amp;';
    if (useTable === 'HTML_ENTITIES') {
        entities['160'] = '&nbsp;';
        entities['161'] = '&iexcl;';
        entities['162'] = '&cent;';
        entities['163'] = '&pound;';
        entities['164'] = '&curren;';
        entities['165'] = '&yen;';
        entities['166'] = '&brvbar;';
        entities['167'] = '&sect;';
        entities['168'] = '&uml;';
        entities['169'] = '&copy;';
        entities['170'] = '&ordf;';
        entities['171'] = '&laquo;';
        entities['172'] = '&not;';
        entities['173'] = '&shy;';
        entities['174'] = '&reg;';
        entities['175'] = '&macr;';
        entities['176'] = '&deg;';
        entities['177'] = '&plusmn;';
        entities['178'] = '&sup2;';
        entities['179'] = '&sup3;';
        entities['180'] = '&acute;';
        entities['181'] = '&micro;';
        entities['182'] = '&para;';
        entities['183'] = '&middot;';
        entities['184'] = '&cedil;';
        entities['185'] = '&sup1;';
        entities['186'] = '&ordm;';
        entities['187'] = '&raquo;';
        entities['188'] = '&frac14;';
        entities['189'] = '&frac12;';
        entities['190'] = '&frac34;';
        entities['191'] = '&iquest;';
        entities['192'] = '&Agrave;';
        entities['193'] = '&Aacute;';
        entities['194'] = '&Acirc;';
        entities['195'] = '&Atilde;';
        entities['196'] = '&Auml;';
        entities['197'] = '&Aring;';
        entities['198'] = '&AElig;';
        entities['199'] = '&Ccedil;';
        entities['200'] = '&Egrave;';
        entities['201'] = '&Eacute;';
        entities['202'] = '&Ecirc;';
        entities['203'] = '&Euml;';
        entities['204'] = '&Igrave;';
        entities['205'] = '&Iacute;';
        entities['206'] = '&Icirc;';
        entities['207'] = '&Iuml;';
        entities['208'] = '&ETH;';
        entities['209'] = '&Ntilde;';
        entities['210'] = '&Ograve;';
        entities['211'] = '&Oacute;';
        entities['212'] = '&Ocirc;';
        entities['213'] = '&Otilde;';
        entities['214'] = '&Ouml;';
        entities['215'] = '&times;';
        entities['216'] = '&Oslash;';
        entities['217'] = '&Ugrave;';
        entities['218'] = '&Uacute;';
        entities['219'] = '&Ucirc;';
        entities['220'] = '&Uuml;';
        entities['221'] = '&Yacute;';
        entities['222'] = '&THORN;';
        entities['223'] = '&szlig;';
        entities['224'] = '&agrave;';
        entities['225'] = '&aacute;';
        entities['226'] = '&acirc;';
        entities['227'] = '&atilde;';
        entities['228'] = '&auml;';
        entities['229'] = '&aring;';
        entities['230'] = '&aelig;';
        entities['231'] = '&ccedil;';
        entities['232'] = '&egrave;';
        entities['233'] = '&eacute;';
        entities['234'] = '&ecirc;';
        entities['235'] = '&euml;';
        entities['236'] = '&igrave;';
        entities['237'] = '&iacute;';
        entities['238'] = '&icirc;';
        entities['239'] = '&iuml;';
        entities['240'] = '&eth;';
        entities['241'] = '&ntilde;';
        entities['242'] = '&ograve;';
        entities['243'] = '&oacute;';
        entities['244'] = '&ocirc;';
        entities['245'] = '&otilde;';
        entities['246'] = '&ouml;';
        entities['247'] = '&divide;';
        entities['248'] = '&oslash;';
        entities['249'] = '&ugrave;';
        entities['250'] = '&uacute;';
        entities['251'] = '&ucirc;';
        entities['252'] = '&uuml;';
        entities['253'] = '&yacute;';
        entities['254'] = '&thorn;';
        entities['255'] = '&yuml;';
    }

    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {
        entities['39'] = '&#39;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';


    // ascii decimals to real symbols
    for (decimal in entities) {
        symbol = String.fromCharCode(decimal);
        hash_map[symbol] = entities[decimal];
    }
    
    return hash_map;
}
