<?php
/*
------------
GOOGLE FONTS
------------
 *
 * Description:     A PHP Class for loading Google Fonts
 * Version:			0.9
 * Author:			Maarten Zilverberg (www.mzilverberg.com)
 * Special thanks:  Shemyakina Tatiana (www.life-thai.com) -- for adding some useful functionality in my previous script
 * Examples:		https://github.com/mzilverberg/GoogleFonts
 *
 * Licensed under the GPL license:
 * http://www.gnu.org/licenses/gpl.html
 *
 * Last but not least:
 * if you like this script, I would appreciate it if you took the time to share it
*/
class GoogleFonts {
    // Overridable variable
    public $fonts;
    // Constant (each file source begins with the same string)
    const SOURCE_PREFIX = "https://fonts.googleapis.com/css?family=";

    /*
    Nest fonts
    */
    private function nestFonts($fonts) {
        // Create a new array
        $new_fonts = array();
        // Determine how many fonts are requested by checking if the array key ["name"] exists
        // If it exists, wrap the $fonts in another array
        // Otherwise, just copy the array into the new array
        $new_fonts = isset($fonts["name"]) ? array($fonts) : $fonts;
        return $new_fonts;
    }

    /*
    Get requested weights per font
    ------------------------------
    @param `$font`   (array):   Array with requested font data
    */
    private function getWeight($font) {
        // Set a flag
        $weight = isset($font["weight"]) ? $font["weight"] : false;
        $new_weight = false;
        // If weights are specified
        if(isset($weight)) {
            // Get the type
            switch(gettype($weight)) {
                case "string":
                    // Remove spaces
                    $new_weight = str_replace(" ", "", $weight);
                    break;
                case "array":
                    // Join values with a comma
                    $new_weight = implode(",", $weight);
                    break;
                case "integer":
                    // Cast integer as string
                    $new_weight = (string)$weight;
            }
        }
        // Return new array
        return $new_weight;
    }

    /*
    Request a link for each font
    */
    private function getURLParams() {
        // Setup font collections
        $no_subset_fonts = array();
        $subset_fonts = array();
        // Loop through fonts
        foreach($this->fonts as $font) {
            // Define font family
            $family = str_replace(" ", "+", $font["name"]);
            // Get weights as a comma seperated string
            $font["weight"] = $this->getWeight($font);
            $weights = $font["weight"];
            // Set source parameters
            $params = $family . ($weights !== false ? ":" . $weights : "");
            // Determine to which array the font should be added
            if(!isset($font["subset"])) {
                // Add to array
                array_push($no_subset_fonts, $params);
            } else {
                // Add query parameter to string
                $params .= "&subset=" . str_replace(" ", "", $font["subset"]);
                array_push($subset_fonts, $params);
            }

        }
        // Add both font collections to new array
        $sources = array(
            "no_subset" => $no_subset_fonts,
            "subset"    => $subset_fonts
        );
        return $sources;
    }

    /*
    Get HTML
    --------
    @param `$request` (string):    Requested path
    @param `$debug`   (boolean):   When set to true, the HTML is printed as a string instead of added to the DOM
    */
    private function getHTML($request, $debug) {
        // Set output characters, use &lt; and &gt; when debugging
        $x = $debug ? array("&lt;", "&gt;") : array("<", ">");
        // Return HTML
        return $x[0] . "link href='" . self::SOURCE_PREFIX . $request . "' rel='stylesheet' /" . $x[1] . "\n";
    }

    /*
    Load file
    ---------
    @param `$debug`   (boolean):   When set to true, the HTML is printed as a string instead of added to the DOM
    */
    public function load($debug = false) {
        // Build up HTML string
        $html = "";
        // Setup combined font request
        $combined = "";
        // Loop through subsetless fonts
        foreach($this->source["no_subset"] as $font) {
            $combined .= "$font|";
        }
        // Trim last character and get HTML string
        if($combined !== "") {
            $html .= $this->getHTML(rtrim($combined, "|"), $debug);
        }
        // Loop through subset fonts
        foreach($this->source["subset"] as $font) {
            // Add to HTML string
            $html .= $this->getHTML($font, $debug);
        }
        // Add to DOM
        echo nl2br($html);
    }

    /*
    Load file with fallback methods
    -------------------------------
    @param `$debug`   (boolean):   When set to true, the HTML is printed as a string instead of added to the DOM
    */
    public function fallback($debug = false) {
        // Set output characters, use &lt; and &gt; when debugging
        $x = $debug ? array("&lt;", "&gt;") : array("<", ">");
        // Build up HTML conditional comment
        $html = $x[0] . "!--[if lte IE8]" . $x[1] . "\n";
        // Loop trough all fonts
        foreach($this->source as $fonts) {
            foreach($fonts as $font) {
                // Get subset, family and weights
                $request = explode("&subset=", $font);
                // If subset is defined, get subset
                // Else, set subset as an empty string
                $subset = isset($request[1]) ? "&subset=" . $request[1] : "";
                // Get font family
                $info = explode(":", $request[0]);
                $family = $info[0];
                // Get weights if defined
                $weights = isset($info[1]) ? explode(",", $info[1]) : "";
                // If weights is array
                if(gettype($weights) === "array") {
                    // Loop through weights
                    foreach($weights as $weight) {
                        $html .= $this->getHTML("$family:$weight$subset", $debug);
                    }
                // Otherwise
                } else {
                    // Setup source
                    // Don't add a colon if no font weights are specified
                    $source = $family . ($weights !== "" ? ":$weights" : "") . $subset;
                    $html .= $this->getHTML($source, $debug);
                }
            }
        }
        // Close conditional comment and add to DOM
        $html .= $x[0] . "![endif]--" . $x[1] . "\n";
        echo nl2br($html);
    }

    /*
    Constructor function
    --------------------
    @param `$fonts`   (array):   Possibly nested requested font information
    */
    public function __construct($fonts) {
        // Set variables
        $this->fonts = $this->nestFonts($fonts);
        // Set source
        $this->source = $this->getURLParams();
    }
}
?>
