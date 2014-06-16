<?php
/*
LOAD GOOGLE WEBFONTS
 *
 * Description:	A PHP script for loading Google Webfonts' css files in an orderly manner
 * Version:			0.8.1
 * Author:			Maarten Zilverberg (www.mzilverberg.com)
 * Author:			Shemyakina Tatiana (www.life-thai.com)
 * Examples:		https://github.com/mzilverberg/LoadGoogleWebfonts
 
 * Licensed under the GPL license:
 * http://www.gnu.org/licenses/gpl.html
 * 
 * Last but not least:
 * if you like this script, I would appreciate it if you took the time to share it
*/
function loadGoogleWebfonts($fonts, $debug = false) {
	// if debugging, use &lt; and $gt; notation for output as plain text
	// otherwise, use < and > for output as html
	$debug ? $x = array('&lt;', '&gt;') : $x = array('<', '>');
	// create a new font array
	$array = array();
	// determine how many fonts are requested by checking if the array key ['name'] exists
	// if it exists, push that single font into the $array variable
	// otherwise, just copy the $fonts variable to $array
	isset($fonts['name']) ? array_push($array, $fonts) : $array = $fonts;
	// if IE<=8
	if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']))
	{
		echo $x[0] . '!--[if lte IE 8]' . $x[1] . "\n";
	   
		// request the link for each font
		foreach ($array as $font) {
			// create a new fallback array for storing possible fallback urls
			$fallback_urls = array();
			// set the basic url
			$base_url = 'http://fonts.googleapis.com/css?family=' . str_replace(' ', '+', $font['name']);			
			// create a new array for storing the font weights
			if (isset($font['weight'])){
				$weights = explode(',', str_replace(' ', '', $font['weight']));
				// add each weight to $url
				foreach($weights as $weight) { 
					$fallback_urls[] = $base_url.':'. $weight ;
				}
			}else $fallback_urls[] = $base_url;
			if (isset($font['subset'])){
				$subsets = explode(',', str_replace(' ', '', $font['subset']));			

				foreach($fallback_urls as $key=>$url) {
					foreach ($subsets as $subset) {
				 		unset($fallback_urls[$key]);
				 		$fallback_urls[] = $url."&subset=".$subset;						
					}
				}
			}
			foreach($fallback_urls as $url){
				outputFontUrl($url, $x);	
			}			
		}
		echo $x[0] . '![endif]--' . $x[1] . "\n";
	}
	else
	{
	    // if IE>8
	    // set the basic url
	    $no_subset_fonts = 'http://fonts.googleapis.com/css?family=';
	    // request the link for each font
		foreach ($array as $font) {
			
			$font_family = str_replace(' ', '+', $font['name']);
			$weight = getFontWeight($font);		
			// if weights were specified we add them after font family name	
			if ($weight != false){
					$font_family .= ':' . $weight;
				}
			if(isset($font['subset'])) {
				$url = 'http://fonts.googleapis.com/css?family=' . $font_family;				
				$url .= "&subset=".$font['subset'];
				outputFontUrl($url, $x);
			}else{
				// if font has no defined subset we can optimize a bit 
				// and load several font families in one query
				$no_subset_fonts .= $font_family . '|';
			}
		}
		$no_subset_fonts = substr_replace($no_subset_fonts, '', -1);
		if ($no_subset_fonts != "http://fonts.googleapis.com/css?family")
			outputFontUrl($no_subset_fonts, $x);
	}
}

function getFontWeight($font){
	// if the font weights are passed as a string (from which all spaces will be removed), insert each value into the $weights array
	// otherwise, just copy the weights passed
	if(isset($font['weight'])) {
		switch(gettype($font['weight'])){
			case 'string' : return str_replace(' ', '', $font['weight']); 
			case 'array'  : return (implode(",", $font['weight']));
			case 'integer': return $font['weight'];
		}
	};
	return false;
}
function outputFontUrl($url, $x){
	// normal html output
	echo $x[0] . 'link href="' . $url . '" rel="stylesheet" type="text/css" /' . $x[1] . "\n";
}
?>