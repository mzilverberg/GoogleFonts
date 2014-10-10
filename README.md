LoadGoogleFonts
===============

A PHP script for loading Google Fonts' CSS files in an orderly manner


Why this script?
----------------

First, I must admit that I'm a bit of a neat freak. I dislike having to many conditional comments in my template files. While Google's Webfont service allows embedding a font by a single rule of HTML, Internet Explorer 8 and earlier versions don't seem to play along.

**For example:**
When you want to use the normal and bold versions of the Droid Sans font, the rule below will work in most browsers.

	<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" type="text/css" />

In IE8 and below, however, we need to make a call to 2 single CSS files in order to be able to use both font weights. Here is where we need to use conditional comments.

	<!--[if lte IE 8]>
		<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
	<![endif]-->

(Further reading: http://stackoverflow.com/questions/3694060/how-to-make-google-fonts-work-in-ie#10885925)

Of course, when using multiple Google Fonts, those IE8- only rules are only growing in numbers and before you know it, they'll take up half your screen (okay, so I might be exaggerating a bit).

I want to use a method of embedding fonts the Google Font library while maintaining a somewhat cleaner code. This is the part where my function comes in handy.

**Note**: if you only want to use one weight of a single font, *don't use this code*.


How to use it?
-----------------

Insert this line of code where you would normally put &lt;link href="…" /&gt;:

	<?php loadGoogleFonts($fonts); ?>

The function accepts 2 options. See the description for each variable below, or check the demo files for a few examples.

**1. An array of one or more fonts**

Example with multiple fonts:

	$fonts = array(
		array(
			"name" => "Droid Sans",
			"weight" => "400, 700"
		),
		array(
			"name" => "Poiret One",
			"subset" => "latin",
			"weight" => "700"
		)
	);

When you only want to use one font, you can use a shorter notation:

	$fonts = array(
		"name" => "Droid Sans",
		"weight" => "400, 700"
	);

**2. Debugging mode**

This is *false* by default. When it is set to *true*, output is rendered with `&lt;` and `&gt;` in stead of < and >. In this case the output is plain text.
This is a function that I used while writing this function and it was very useful to me during that time. It will remain supported in this script as long as I'm extending its functionality. When I'm done with version 1.0, I will probably remove this feature.

Other functionality
-------------------

**The IE8- conditional comment notation**

If the user works with IE8- (checked by using `$_SERVER["HTTP_USER_AGENT"]`), a fallback notation is automatically added.

**Performance optimized method of requesting Google Fonts**

To load several fonts with one query, the function simply takes URLs and combines with a '|' character.

Upcoming
--------

- A GoogleFontLoader class

Version history
---------------
**v.0.8.2** *latest change: October 10th, 2014*
- changed name to `loadGoogleFonts`
- I decided I like double quotes now
- added some comments
- minor syntax changes

**v.0.8.1** *latest change: June 16th, 2014*
- removed default value of *weight*, since Google will provide the default values
- removed parameter for fallback mode. Now IE8- is detected automatically
- added new param *subset* to load different subsets of one font
- added optimization to load as much as possible fonts in one query

**v.0.8** *latest change: May 25nd, 2013*
- *weight* is now optional and defaults to 400
- Combined IE compatible notation URLs within a single conditional comment

**v.0.7.5** *latest change: May 22nd, 2013*
- Support for loading a single font or multiple fonts from the Google Webfont library
- Option to include a fallback method for IE8 and below
- Option to debug the output
