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
loadGoogleWebfonts(array('name' => 'Droid Sans'));
// example 1.1 fonts
loadGoogleWebfonts(array('name' => 'Poiret One', 'subset'=>'cyrillic,latin'));
// example 2 font
loadGoogleWebfonts(array('name' => 'Cabin', 'weight' => '400italic, 700'));
// example 3 fonts
loadGoogleWebfonts(array(array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'weight' => '100, 300, 400')));
?>
<link href="demo.css" rel="stylesheet" media="screen" />
<title>A simple demo page | loadGoogleWebfonts.php</title>
</head>

<body>
<h1>LoadGoogleWebfonts examples</h1>
<p>For more information, be sure to check out the <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">LoadGoogleWebfonts GitHub repository</a>.</p>
<ul>
	<li><a href="#example1">Example 1: Loading a single font</a></li>
  <li><a href="#example11">Example 1.1: Loading multiple font subsets</a></li>
   <li><a href="#example2">Example 2: Loading multiple font weights and/or styles</a></li>
   <li><a href="#example3">Example 3: Loading multiple fonts with different weights and/or styles</a></li>
   <li><a href="#example4">Example 4: The IE8- compatible notation</a></li>
</ul>
<p>For example purposes I set the debugging option to <em>true</em> in all examples, so you can view the actual output without having to view the source code.</p>
<p>Because I want to show how function works with normal browsers and IE8-, I will simulate <i>Mozilla</i> and <i>IE5</i>.</p>

<div id="example1">
   <h2>Example 1: Loading a single font</h2>
   <p>If you do not request specific weight of font the function will load all available weights by default.</p>

   <pre><code>&lt;?php
  $font = array(
    'name' => 'Droid Sans'
  );
  loadGoogleWebfonts($font);
?&gt;</code></pre>

   <p>If you only want to use the normal weight of a font, you can use the notation below. .</p>
   <p>To be honest, <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">loadGoogleWebfonts</a> isn't really necessary when you only want to load a single font and only one weight of that font. But since it works for loading one font, I figured: might as well describe this, too.</p>
   
   <pre><code>&lt;?php
  $font = array(
    'name' => 'Droid Sans',
    'weight' => '400'
  );
  loadGoogleWebfonts($font);
?&gt;</code></pre>

   <div class="output">
      <h3>Output</h3>
            
      <pre><code><?php $_SERVER['HTTP_USER_AGENT']='Mozilla'; loadGoogleWebfonts(array('name' => 'Droid Sans', 'weight'=> '400'), true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview">This text is in Droid Sans (400).</p>
   </div>

</div><!-- #example1 -->

<div id="example11">
   <h2>Example 1.1: Loading multiple font subsets</h2>
   <p>If you only want to use the normal weight of a font, you can use the notation below. The function will set the default weight to 400 if no specific font weights are requested.</p>
   <p>To be honest, <a href="https://github.com/mzilverberg/LoadGoogleWebfonts">loadGoogleWebfonts</a> isn't really necessary when you only want to load a single font and only one weight of that font. But since it works for loading one font, I figured: might as well describe this, too.</p>
   
   <pre><code>&lt;?php
  $font = array(
    'name' => 'Poiret One',
    'subset' => 'cyrillic,latin'
  );
  loadGoogleWebfonts($font);
?&gt;</code></pre>

   <div class="output">
      <h3>Output</h3>
      <pre><code><?php $_SERVER['HTTP_USER_AGENT']='Mozilla'; loadGoogleWebfonts(array('name' => 'Poiret One', 'subset'=>'cyrillic,latin'), true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview poiret">This text is in <b>Poiret One</b>. <br /> Этот текст написан шрифтом <b>Poiret One</b>.</p>
   </div>
</div><!-- #example11 -->


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
      
      <pre><code><?php $_SERVER['HTTP_USER_AGENT']='Mozilla'; loadGoogleWebfonts(array('name' => 'Cabin', 'weight' => '400italic, 700'), true, true); ?></code></pre>
      
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
      'weight' => array('100, 300, 400')
    )
  );
  loadGoogleWebfonts($multiple_fonts);
?&gt;</code></pre>
	<p>Note the the optimization of loading fonts without subset. </p>
   
   <div class="output">
      <h3>Output</h3>
      
      <pre><code><?php $_SERVER['HTTP_USER_AGENT']='Mozilla'; loadGoogleWebfonts(array(array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'weight' => '100, 300, 400'), array('name' => 'Poiret One', 'subset' => 'cyrillic,latin', 'weight' => '400, 700')), true); ?></code></pre>
      
      <h3>Live example</h3>
      <p class="preview lobster">This is the Lobster Two font (400) and <strong>this is what Lobster Two bold (700) looks like</strong>.</p>
      <p class="preview roboto"><span class="ultralight">This is Roboto Slab ultra-light (100)</span>, <span class="book">This is Roboto Slab book (300)</span> and this is the normal weight (400).</p>
      <p class="preview poiret">Этот текст написан с помощью шрифта <b>Poiret One</b>. </p>
   </div>
</div>

<div id="example4">
  <h2>Example 4: Disabling the IE8- compatible notation</h2>
  <p>Let's simulate IE8-.</p>
  
  <div class="output">
      <h3>Output</h3>
      <pre><code>&lt;?php
        $multiple_fonts = array(
          array(
            'name' => 'Droid Sans'
          ), array(
            'name' => 'Lobster Two',
            'weight' => '400, 700',
          ), array(
            'name' => 'Roboto Slab',
            'subset' => 'latin'
          ), array(
            'name' => 'Poiret One',
            'subset' => 'cyrillic,latin',
            'weight' => '400, 700'
          )
        );
        loadGoogleWebfonts($multiple_fonts, true);
      ?&gt;</code></pre>

    <pre><code><?php $_SERVER['HTTP_USER_AGENT']='msie 5'; loadGoogleWebfonts(array(array('name' => 'Droid Sans'), array('name' => 'Lobster Two', 'weight' => '400, 700'), array('name' => 'Roboto Slab', 'subset' => 'latin'), array('name' => 'Poiret One', 'subset' => 'cyrillic,latin', 'weight' => '400, 700')), true); ?></code></pre>

  </div>
  
</div>

</body>
</html>