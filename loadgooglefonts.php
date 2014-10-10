<?php
/*
LOAD GOOGLE FONTS
 *
 * Description:     A PHP script for loading Google Fonts' css files in an orderly manner
 * Version:			0.8.2
 * Author:			Maarten Zilverberg (www.mzilverberg.com)
 * Contributor:		Shemyakina Tatiana (www.life-thai.com)
 * Examples:		https://github.com/mzilverberg/LoadGoogleFonts

 * Licensed under the GPL license:
 * http://www.gnu.org/licenses/gpl.html
 *
 * Last but not least:
 * if you like this script, I would appreciate it if you took the time to share it
*/
function loadGoogleFonts($fonts, $debug = false) {
	// if debugging, use &lt; and $gt; notation for output as plain text
	// otherwise, use < and > for output as html
	$debug ? $x = array("&lt;", "&gt;") : $x = array("<", ">");
	// create a new font array
	$array = array();
	// determine how many fonts are requested by checking if the array key ["name"] exists
	// if it exists, push that single font into the $array variable
	// otherwise, just copy the $fonts variable to $array
	isset($fonts["name"]) ? array_push($array, $fonts) : $array = $fonts;
	// if IE<=8
	if(preg_match("/(?i)msie [2-8]/", $_SERVER["HTTP_USER_AGENT"])) {
        // open conditional statement
		echo $x[0] . "!--[if lte IE 8]" . $x[1] . "\n";
		// request the link for each font
		foreach ($array as $font) {
			// create a new fallback array for storing possible fallback urls
			$fallback_urls = array();
			// set the basic url
			$base_url = "http://fonts.googleapis.com/css?family=" . str_replace(" ", "+", $font["name"]);
			// create a new array for storing the font weights
			if(isset($font["weight"])) {
				$weights = explode(",", str_replace(" ", "", $font["weight"]));
				// add each weight to $url
				foreach($weights as $weight) {
					$fallback_urls[] = $base_url . ":" . $weight;
				}
			} else {
                $fallback_urls[] = $base_url;
            }
            // check for subsets
			if(isset($font["subset"])){
				$subsets = explode(",", str_replace(" ", "", $font["subset"]));
                // loop trough fallback urls
				foreach($fallback_urls as $key => $url) {
                    // loop through requested subsets
					foreach($subsets as $subset) {
                        // unset fallback url
				 		unset($fallback_urls[$key]);
                        // add subset request to fallback url
				 		$fallback_urls[] = $url . "&subset=" . $subset;
					}
				}
			}
            // loop through fallback urls
			foreach($fallback_urls as $url) {
                // give output
				outputFontUrl($url, $x);
			}
		}
        // close conditional statement
		echo $x[0] . "![endif]--" . $x[1] . "\n";
    // if not IE8-
	} else {
	    // set the basic url
	    $no_subset_fonts = "http://fonts.googleapis.com/css?family=";
	    // request the link for each font
		foreach($array as $font) {
			$font_family = str_replace(" ", "+", $font["name"]);
			$weight = getFontWeight($font);
			// if weights were specified
			if($weight != false) {
                // add weights after family name
				$font_family .= ":" . $weight;
			}
            // if subsets are specified
			if(isset($font["subset"])) {
				// remove spaces
				$font["subset"] = str_replace(" ", "", $font["subset"]);
				$url = "http://fonts.googleapis.com/css?family=" . $font_family;
				$url .= "&subset=" . $font["subset"];
                // give output
				outputFontUrl($url, $x);
			} else {
				// if font has no defined subset we can optimize a bit
				// by loading several font families in one query
				$no_subset_fonts .= $font_family . "|";
			}
		}
        // remove last character from string
		$no_subset_fonts = substr_replace($no_subset_fonts, "", -1);
        // if font families are defined
		if ($no_subset_fonts != "http://fonts.googleapis.com/css?family") {
			// give output
            outputFontUrl($no_subset_fonts, $x);
        }
	}
}

// get font weights from font request
function getFontWeight($font){
    // setup return value
    $weights = false;
    // if weights are specified
    if(isset($font["weight"])) {
        // get the type
        switch(gettype($font["weight"])) {
            case "string":
                // remove spaces
                $weights = str_replace(" ", "", $font["weight"]);
                break;
            case "array":
                $weights = (implode(",", $font["weight"]));
            case "integer":
                // return passed value
                $weights = $font["weight"];
        }
    }
    // return
    return $weights;
}

// echo output
function outputFontUrl($url, $x){
	// html output
	echo $x[0] . "link href=\"" . $url . "\" rel=\"stylesheet\" type=\"text/css\" /" . $x[1] . "\n";
}
?>
