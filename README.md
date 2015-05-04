# GoogleFonts

A PHP Class for loading [Google Fonts](https://www.google.com/fonts) in an orderly manner.

## Why?

This class is useful when requesting fonts hosted by Google. You can request multiple font families (and font weights as well as subsets per family) in just one call.

- Easy-to-use
- Supports widely used Google Fonts
- Supports IE8 and older browsers with a fallback function

## How does it work?

When a new instance is made, this script will check per font if a specific subset (i.e. "latin") is defined. Font family requests are divided in those with a subset, and those without a specified subset.
The last group will be loaded in a combined request. The other fonts each require a load.
This script will output the HTML needed to load the font files from Google when the `load()` function is called.

## Basic usage

The `GoogleFonts` class accepts 1 array with font information:
Each font `array` accepts a couple of arguments:

<dl>
    <dt>name</dt>
    <dd>
        `string` - Name of the font family
    </dd>
    <dt>weight</dt>
    <dd>
        `mixed` - A string or array with all requested font weights<br />
        <small>Example: `"300,400,400italic"` or `array(300, 400, "400italic")`</small>
    </dd>
    <dt>subset</dt>
    <dd>
        `string` - Subset parameter code<br />
        <small>Example: _"latin"_ or _"cyrillic-ext"_</small>
    </dd>
</dl>

_Note: You can request multiple fonts in one call by wrapping all font arrays with another array_

## Examples

### Loading a single font

Requesting a single font family, with no further weight(s) or subset(s) specified.

_Important note:_ First of all, I would like to say that this is probably the worst possible scenario for using this class, since you can do this simply by adding Google's standard code as standalone HTML. That is less, and therefore better code. But, since it is possible, I might as well show how it works:

```php
<head>
    ...
    <?php
    // Require class
    require_once("/path/to/GoogleFonts.class.php");
    // Load font
    $font = new GoogleFonts(
        array(
            "name" => "Open Sans"
        )
    );
    $font->load();
    ?>
</head>
```

### Loading specific font weights and a subset

The same example as above, but now with specific weights and a subset:

```php
<head>
    ...
    <?php
    // Require class
    require_once("/path/to/GoogleFonts.class.php");
    // Load font
    $font = new GoogleFonts(
        array(
            "name"   => "Open Sans",
            "weight" => array(300, 400, "400italic"),
            "subset" => "latin"
        )
    );
    $font->load();
    ?>
</head>
```

### Loading multiple fonts in one call

You can request multiple fonts in one call by wrapping all font arrays with another array:

```php
<head>
    ...
    <?php
    // Require class
    require_once("/path/to/GoogleFonts.class.php");
    // Specify all fonts in an array
    // (stored in a variable for clarity)
    $multiple_fonts = array(
        array(
            "name"   => "Open Sans",
            "weight" => array(300, 400, "400italic"),
            "subset" => "latin"
        ),
        array(
            "name"   => "Roboto",
            "weight" => "400, 700"
        )
    );
    // Load font
    $font = new GoogleFonts($multiple_fonts);
    $font->load();
    ?>
</head>
```

### Loading multiple fonts without subsets

When you request multiple fonts and no subset is specified for more than one font, those fonts will be loaded in a combined request:

```php
<head>
    ...
    <?php
    // Require class
    require_once("/path/to/GoogleFonts.class.php");
    // Specify all fonts in an array
    // (stored in a variable for clarity)
    $multiple_fonts = array(
        array("name" => "Droid Sans"),
        array("name" => "Roboto Sans"),
        array("name" => "Open Sans", "subset" => "latin")
    );
    // Load font
    $font = new GoogleFonts($multiple_fonts);
    $font->load();
    /*
    *  Output:
    *  <link href='https://fonts.googleapis.com/css?family=Droid+Sans|Roboto+Sans' rel='stylesheet' />
    *  <link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin' rel='stylesheet' />
    */
    ?>
</head>
```

### Legacy browser support

Google's shorthand notations for loading font files aren't supported in Internet Explorer versions 8 and below. This is easily fixed in a conditional comment, which can be added to the DOM by using the `fallback()` function:

```php
<head>
    ...
    <?php
    // Require class
    require_once("/path/to/GoogleFonts.class.php");
    // Load font
    $font = new GoogleFonts(
        array(
            "name"   => "Open Sans",
            "weight" => array(300, 400, "400italic"),
            "subset" => "latin"
        )
    );
    $font->load();
    $font->fallback();
    /*
    *  Output:
    *  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic&subset=latin' rel='stylesheet' />
    *  <!--[if lte IE8]>
    *    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300&subset=latin' rel='stylesheet' />
    *    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400&subset=latin' rel='stylesheet' />
    *    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic&subset=latin' rel='stylesheet' />
    *  <![endif]-->
    */
    ?>
</head>
```

### "Debugging"

If there is a scenario where you would like to check the HTML output that would be added to the DOM, you can! Just pass `true` as an argument in the `load()` and/or `fallback()` functions. The output will then be printed as a string.
