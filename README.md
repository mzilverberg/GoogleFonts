LoadGoogleWebfonts
==================

A PHP script for loading Google Webfonts' css files in an orderly manner


Why this script?
----------------

First, I must admit that I'm a bit of a neat freak. I dislike having to many conditional comments in my template files. While Google's Webfont service allows embedding a font by a single rule of HTML, Internet Explorer 8 and earlier versions don't seem to play along.

**For example:**
When you want to use the normal and bold versions of the Droid Sans font, the rule below will work in most browsers.

&lt;link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'&gt;

In IE8 and below, however, we need to make a call to 2 single CSS files in order to be able to use both font weights. Here is where we need to use conditional comments.

&lt;!--[if lte IE 8]&gt;
	&lt;link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" /&gt;
	&lt;link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" /&gt;
&lt;![endif]--&gt;

Of course, when using multiple Google Webfonts, those IE8- only rules are only growing in numbers and before you know it, they'll take up half your screen (okay, so I might be exaggerating a bit).

I want to use a method of embedding fonts the Google Webfont library while maintaining a somewhat cleaner code. This is the part where my function comes in handy.

Further reading:
- http://stackoverflow.com/questions/3694060/how-to-make-google-fonts-work-in-ie#10885925

How to use it?
-----------------

Insert this line of code where you would normally put &lt;link src="…" /&gt;:

&lt;?php loadGoogleWebfonts($fonts); ?&gt;

The function accepts 3 options. See the description for each variable below, or check demo.html for some examples.

**1. An array of one or more fonts**

Example with multiple fonts:

$fonts = array(

	array(

		'name' => 'Droid Sans',

		'weight' => '400, 700'

	),

	array(

		'name' => 'Cabin',

		'weight' => array('400', '400italic', '500')

	)

);

*Note that you can pass the weights as a string or as an array*

When you only want to use one font, you can use a shorter notation method:

$fonts = array(

	'name' => 'Droid Sans',

	'weight' => '400, 700'

);

**2. The IE8- conditional comment notation**

This is *true* by default, but won't fire if only one font weight is requested

**3. Debugging mode**

This is *false* by default. When it is set to *true*, output is rendered with &lt; and &gt; in stead of < and >. In this case the output is plain text.
This is a function that I used while writing this function and it was very useful to me during that time. It will remain supported in this script as long as I'm extending its functionality. When I'm done with version 1.0, I will probably remove this feature.


Version history
---------------

**v.0.7.5** *latest change: May 22nd, 2013*
- Support for loading a single font or multiple fonts from the Google Webfont library
- Option to include a fallback method for IE8 and below
- Option to debug the output