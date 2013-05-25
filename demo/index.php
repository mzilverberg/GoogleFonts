<?php
// we need the function in order to make this work
require('../loadgooglewebfonts.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
// example 1 font
loadGoogleWebfonts(array('name' => 'Droid Sans', 'weight' => '400'));
// example 2 font
loadGoogleWebfonts(array('name' => 'Cabin', 'weight' => '400italic, 700'));
// example 3 fonts
loadGoogleWebfonts(array(array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'weight' => array('100', '300', '400'))));
?>
<link href="demo.css" rel="stylesheet" media="screen" />
<title>A simple demo page | loadGoogleWebfonts.php</title>
</head>

<body>
<h1>LoadGoogleWebfonts examples</h1>
<p>For more information, be sure to check out the <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">LoadGoogleWebfonts GitHub repository</a>.</p>

<ul>
	<li><a href="#example1">Example 1: Loading a single font</a></li>
   <li><a href="#example2">Example 2: Loading multiple font weights and/or styles</a></li>
   <li><a href="#example3">Example 3: Loading multiple fonts with different weights and/or styles</a></li>
   <li><a href="#example4">Example 4: Disabling the IE8- compatible notation</a></li>
</ul>

<div id="example1">
   <h2>Example 1: Loading a single font</h2>
   <p>Note that I set the debugging option to <em>true</em> in all examples, so you can view the actual output without having to view the source code.</p>
   
   <pre><code>&lt;?php
  $font = array(
    'name' => 'Droid Sans',
    'weight' => '400'
  );
  loadGoogleWebfonts($font);
?&gt;</code></pre>

   <div class="output">
      <h3>Output</h3>
      <p>Because I'm only requesting the normal weight of this font, the fallback notation for IE8- isn't part of the output HTML, even though the option is set to <em>true</em> by default.</p>
      <p>To be honest, <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">loadGoogleWebfonts</a> isn't really necessary when you only want to load a single font and only one weight of that font. But since it works for loading one font, I figured: might as well describe this, too.</p>
      
      <pre><code><?php loadGoogleWebfonts(array('name' => 'Droid Sans', 'weight' => '400'), true, true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview">This text is in Droid Sans (400).</p>
   </div>
</div><!-- #example1 -->

<div id="example2">
   <h2>Example 2: Loading multiple font weights and/or styles</h2>
   
   <pre><code>&lt;?php
  $multiple_styles = array(
    'name' => 'Cabin',
    'weight' => '400italic, 700'
  );
  loadGoogleWebfonts($multiple_styles);
?&gt;</code></pre>

   <div class="output">
      <h3>Output</h3>
      
      <pre><code><?php loadGoogleWebfonts(array('name' => 'Cabin', 'weight' => '400italic, 700'), true, true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview"><strong>This text is in Cabin bold (700)</strong> <em>and this text is normal italic (400italic)</em>.</p>
   </div>
</div>

<div id="example3">
   <h2>Example 3: Loading multiple fonts with different weights and/or styles</h2>
   
   <pre><code>&lt;?php
  $multiple_fonts = array(
    array(
      'name' => 'Lobster Two',
      'weight' => '400, 700'
    ), array(
      'name' => 'Roboto Slab',
      'weight' => array('100', '300', '400')
    )
  );
  loadGoogleWebfonts($multiple_fonts);
?&gt;</code></pre>
	<p>Note the difference in notation for the weights. <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">loadGoogleWebfonts</a> accepts both the string and array notation.
   
   <div class="output">
      <h3>Output</h3>
      
      <pre><code><?php loadGoogleWebfonts(array(array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'weight' => array('100', '300', '400'))), true, true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview lobster">This is the Lobster Two font (400) and <strong>this is what Lobster Two bold (700) looks like</strong>.</p>
      <p class="preview roboto"><span class="ultralight">This is Roboto Slab ultra-light (100)</span>, <span class="book">This is Roboto Slab book (300)</span> and this is the normal weight (400).</p>
   </div>
</div>

<div id="example4">
   <h2>Example 4: Disabling the IE8- compatible notation</h2>
   
   <pre><code>&lt;?php
  $multiple_fonts = array(
    array(
      'name' => 'Lobster Two',
      'weight' => '400, 700'
    ), array(
      'name' => 'Roboto Slab',
      'weight' => array('100', '300', '400')
    )
  );
  loadGoogleWebfonts($multiple_fonts, false);
?&gt;</code></pre>
	<p>It's as easy as passing the second variable as <em>false</em>.</p>
   
   <div class="output">
      <h3>Output</h3>
      
      <pre><code><?php loadGoogleWebfonts(array(array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'weight' => array('100', '300', '400'))), false, true); ?></code></pre>
      
   </div>
</div>

</body>
</html>