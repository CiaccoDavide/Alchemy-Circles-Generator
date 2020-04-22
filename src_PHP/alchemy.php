<?php
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    mt_srand($id);

    $pixelsize = 2;
    $size = 64 * $pixelsize;

    // create the "canvas"
    $img = imagecreatetruecolor($size, $size);

    // for the coloured version, colors used will be between $ncol and $xcol. It must hold that $ncol < $xcol. 
    $ncol = 60;
    $xcol = 250;

    // we only use one color for the circle, $colore. Default is white
    $colore = imagecolorallocate($img, 255, 255, 255);

    // if user requested a coloured image, we generate a random color between our min and max values
    if(!empty($_GET['coloured']))
    {
        $coloreR = mt_rand($ncol, $xcol);
        $coloreG = mt_rand($ncol, $xcol);
        $coloreB = mt_rand($ncol, $xcol);

        $colore = imagecolorallocate($img, $coloreR, $coloreG, $coloreB);
    }

    // background color - if the three values are the same, a shade of grey
    $coloresnf = imagecolorallocate($img, 30, 30, 30);
    imagefilledrectangle($img, 0, 0, $size, $size, $coloresnf);
    // imagecolortransparent($img, $coloresnf); // toggle transparent background

    // draw the circle:
    // circle's center coordinates and radius
    $center_x = $size / 2; //for readability
    $center_y = $size / 2; //for readability
    $radius = ($size / 2) * 3 / 4;

    // draw a full circle in the foreground color
    imagearc($img, $center_x, $center_y, $radius * 2, $radius * 2, 0, 360, $colore);

    // draw a n-sided polygon with n between 4 and 8
    $lati = mt_rand(4, 8);
    imagepolygon($img, drawPoly($lati, $colore, 0, $radius, $size), $lati, $colore);

    for ($l = 0; $l < $lati; $l++)
    {
        $ang = deg2rad((360 / ($lati))) * $l;
        imageline($img, $center_x, $center_y, $center_x + $radius * cos($ang), $center_y + $radius * sin($ang), $colore);
    }

    // if polygon has even number of sides
    if($lati%2 == 0)
    {

	// generate 2 with a probability of 1/5, or something from {4, 6} with probability 2/5 each
        $latis = mt_rand(2, 6);
        while($latis%2 != 0) $latis = mt_rand(3, 6);
        
        imagefilledpolygon($img, drawPoly($latis, $coloresnf, 180, $radius, $size), $latis, $coloresnf);
        imagepolygon($img, drawPoly($latis, $colore, 180, $radius, $size), $latis, $colore);

        for ($l = 0; $l < $latis; $l++)
        {
            $ang = deg2rad((360 / $latis)) * $l;
            imageline($img, $center_x, $center_y, $center_x + $radius * cos($ang), $center_y + $radius * sin($ang), $colore);
        }
    }
    else
    {
	// generate random number from the set {4, 6} by generating 2 or 3 and multiplying it by 2
	$latis = mt_rand(2, 3) * 2;

        imagefilledpolygon($img, drawPoly($latis, $coloresnf, 180, $radius, $size), $latis, $coloresnf);
        imagepolygon($img, drawPoly($latis, $colore, 180, $radius, $size), $latis, $colore);
    }

    // with a 50% chance:
    if(mt_rand(0, 1)%2 == 0)
    {
        $ronad = mt_rand(0, 4);

	// some trigonometry magic happens below
        if($ronad%2 == 1)
        {
            for ($l = 0; $l < $lati + 4; $l++)
            {
                $ang = deg2rad((360 / ($lati + 4))) * $l;
                imageline($img, $center_x, $center_y, $center_x + ((($radius / 8) * 5) + 2) * cos($ang), $center_y + ((($radius / 8) * 5) + 2) * sin($ang), $colore);
            }
            imagefilledpolygon($img, drawPoly($lati + 4, $colore, 0, $radius / 2, $size), $lati + 4, $coloresnf);
            imagepolygon($img, drawPoly($lati + 4, $colore, 0, $radius / 2, $size), $lati + 4, $colore);
        }
        elseif($ronad%2 == 0 && $lati > 5)
        {
            for ($l = 0; $l < $lati - 2; $l++)
            {
                $ang = deg2rad((360 / ($lati - 2))) * $l;
                imageline($img, $center_x, $center_y, $center_x + ((($radius / 8) * 5) + 2) * cos($ang), $center_y + ((($radius / 8) * 5) + 2) * sin($ang), $colore);
            }
            imagefilledpolygon($img, drawPoly($lati - 2, $colore, 0, $radius / 4, $size), $lati - 2, $coloresnf);
            imagepolygon($img, drawPoly($lati - 2, $colore, 0, $radius / 4, $size), $lati - 2, $colore);
        }
    }

    // with a 60% chance:
    if(mt_rand(0,4)%2 == 0)
    {
        imagearc($img, $center_x, $center_y, ($radius / 8) * 11, ($radius / 8) * 11, 0, 360, $colore);

        if($lati%2 == 0)
        {
	    // generate 2 with a probability of 1/7, or something from {4, 6, 8} with probability 2/7 each
            $latis = mt_rand(2, 8);
            while($latis%2 != 0) $latis = mt_rand(3, 8);

            imagepolygon($img, drawPoly($latis, $colore, 180, ($radius / 3) * 2, $size), $latis, $colore);
        }
        else
        {
	    // generate random number from the set {3, 5, 7} by calculating 2*x+1, where x is in {1, 2, 3}
	    $latis = 2 * mt_rand(1, 3) + 1;

            imagepolygon($img, drawPoly($latis, $colore, 180, ($radius / 3) * 2, $size), $latis, $colore);
        }
    }

    $case = mt_rand(0, 3);
    if($case == 0)
    {
        for ($i = 0; $i < $latis; $i++)
        {
            $angdiff = deg2rad(360 / ($latis));
            $posax = (($radius / 18) * 11) * cos($i * $angdiff);
            $posay = (($radius / 18) * 11) * sin($i * $angdiff);
            imagefilledarc($img, $center_x + $posax, $center_y + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $coloresnf, IMG_ARC_PIE);
            imagearc($img, $center_x + $posax, $center_y + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $colore);
        }
    }
    elseif($case == 1)
    {
        for ($i=0; $i < $latis; $i++)
        {
            $angdiff = deg2rad(360 / $latis);
            $posax = $radius * cos($i * $angdiff);
            $posay = $radius * sin($i * $angdiff);
            imagefilledarc($img, $center_x + $posax, $center_y + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $coloresnf, IMG_ARC_PIE);
            imagearc($img, $center_x + $posax, $center_y + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $colore);
        }
    }
    elseif($case == 2)
    {
        imagearc($img, $center_x, $center_y, ($radius / 18) * 12, ($radius / 18) * 12, 0, 360, $colore);
        imagefilledarc($img, $center_x, $center_y, ($radius / 22) * 12, ($radius / 22) * 12, 0, 360, $coloresnf, IMG_ARC_PIE);
        imagearc($img, $center_x, $center_y, ($radius / 22) * 12, ($radius / 22) * 12, 0, 360, $colore);
    }
    elseif($case == 3)
    {
        for ($i = 0; $i < $latis; $i++)
        {
            $ang = deg2rad((360 / ($latis))) * $i;
            imageline($img, $center_x + (($radius / 3) * 2) * cos($ang), $center_y + (($radius / 3) * 2) * sin($ang), $center_x + $radius * cos($ang), $center_y + $radius * sin($ang), $colore);
        }
        if($latis != $lati)
        {
            imagefilledarc($img, $center_x, $center_y, ($radius / 3) * 4, ($radius / 3) * 4, 0, 360, $coloresnf, IMG_ARC_PIE);
            imagearc($img, $center_x, $center_y, ($radius / 3) * 4, ($radius / 3) * 4, 0, 360, $colore);
            $lati = mt_rand(3, 6);
            imagepolygon($img, drawPoly($lati, $colore, 0, ($radius / 4) * 5, $size), $lati, $colore);
            imagepolygon($img, drawPoly($lati, $colore, 180, ($radius / 3) * 2, $size), $lati, $colore);
        }
    }

    imagecolortransparent($img, $coloresnf);

    header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);

    function drawPoly($sides, $colore, $rot, $radius, $size){
        // data graph values
        $values = array();
        $angdiff = deg2rad(360 / ($sides * 2));
        $rot = deg2rad($rot);

        for ($i = 0; $i < $sides * 2; $i++)
        {
            // find the points on the circumference
            $values[$i] = ($size / 2) + $radius * cos($i * $angdiff + $rot); // X
            $i++;
            $values[$i] = ($size / 2) + $radius * sin(($i - 1) * $angdiff + $rot); // Y
        }

        return $values;
    }
