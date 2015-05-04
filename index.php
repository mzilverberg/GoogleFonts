<?php
// Require class
include_once("includes/script/php/GoogleFonts.class.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Maarten Zilverberg" />
    <title>GoogleFonts PHP Class</title>
    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-xs-12">

                <h1>GoogleFonts</h1>
                <?php
                // Get fonts
                $fonts = array(
                    array(
                        "name"      => "Droid Sans"/*,
                        "weight"    => array(400, 700)*/
                    ),
                    array(
                        "name"      => "Roboto Sans"
                    ),
                    array(
                        "name"      => "Open Sans",
                        "weight"    => "300, 500, 700",
                        "subset"    => "latin"
                    )
                );
                $fonts = new GoogleFonts($fonts);
                $fonts->load(true);
                $fonts->fallback(true);

                /*
                echo "<h1>BREAK</h1>";
                // Load font
                $font = new GoogleFonts(
                    array(
                        "name"      => "Open Sans",
                        "weight"   => array(300, 400, "400italic"),
                        "subset"    => "latin"
                    )
                );
                $font->load(true);
                $font->fallback(true);
                */
                ?>

            </div>
        </div>

    </div><!-- .container -->

</body>
</html>
