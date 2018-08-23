<?php

    use SVG\Nodes\Shapes\SVGCircle;
    use SVG\Nodes\Shapes\SVGLine;
    use SVG\Nodes\Shapes\SVGRect;
    use SVG\SVG;

    require_once __DIR__ . '/vendor/autoload.php';

    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    mt_srand($id);

    $pixelsize = 2;
    $size = 64 * $pixelsize;

    // create the "canvas"
    /** $img = imagecreatetruecolor($size, $size); */
    $image = new SVG($size, $size);
    $doc = $image->getDocument();
    
    $ncol = 60;// min_colore 0
    $xcol = 250;// max_colore 255

    /** $colore = imagecolorallocate($img, 255, 255, 255); */
    $colore = '#ffffff';

    // random color
    if(!empty($_GET['coloured']))
    {
        $coloreR = mt_rand($ncol, $xcol);
        $coloreG = mt_rand($ncol, $xcol);
        $coloreB = mt_rand($ncol, $xcol);

        /** $colore = imagecolorallocate($img, $coloreR, $coloreG, $coloreB); */
        $colore = sprintf("#%02x%02x%02x", $coloreR, $coloreG, $coloreB);
    }

    // backround color
    /** $coloresnf = imagecolorallocate($img, 30, 30, 30); */
    $coloresnf = '#242424';
    /** imagefilledrectangle($img, 0, 0, $size, $size, $coloresnf); */
    $square = new SVGRect(0, 0, $size, $size);
    $square->setStyle('fill', $coloresnf);
    $doc->addChild($square);
    // imagecolortransparent($img, $coloresnf); // toggle transparent background

    // draw the hexagon:
    // hexagon's center coordinates and radius
    $hex_x = $size / 2;
    $hex_y = $size / 2;
    $radius = ($size / 2) * 3 / 4;

    /** imagearc($img, $size / 2, $size / 2, $radius * 2, $radius * 2, 0, 360, $colore); */
    $circle = new SVGCircle($size / 2, $size / 2, ($radius / 2) * 2);
    $circle->setStyle('fill', 'none')
        ->setStyle('stroke', $colore);
    $doc->addChild($circle);

    $lati = mt_rand(4, 8);
    /** imagepolygon($img, drawPoly($lati, $colore, 0, $radius, $size), $lati, $colore); */
    $polygon = drawPolygon($lati, 0, $radius, $size, $colore);
    $doc->addChild($polygon);

    for ($l = 0; $l < $lati; $l++)
    {
        $ang = deg2rad((360 / ($lati))) * $l;
        /** imageline($img, ($size / 2), ($size / 2), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang), $colore); */
        $line = new SVGLine(($size / 2), ($size / 2), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang));
        $line->setStyle('stroke', $colore);
        $doc->addChild($line);
    }

    if($lati%2 == 0)
    {
        $latis = mt_rand(2, 6);
        while($latis%2 != 0) $latis = mt_rand(3, 6);
        
        /** imagefilledpolygon($img, drawPoly($latis, $coloresnf, 180, $radius, $size), $latis, $coloresnf); */
        /** imagepolygon($img, drawPoly($latis, $colore, 180, $radius, $size), $latis, $colore); */
        $polygon = drawPolygon($latis, 180, $radius, $size, $colore);
        $polygon->setStyle('fill', $coloresnf);
        $doc->addChild($polygon);

        for ($l = 0; $l < $latis; $l++)
        {
            $ang = deg2rad((360 / $latis)) * $l;
            /** imageline($img, ($size / 2), ($size / 2), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang), $colore); */
            $line = new SVGLine(($size / 2), ($size / 2), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang));
            $line->setStyle('stroke', $colore);
            $doc->addChild($line);
        }
    }
    else
    {
        while(($latis = mt_rand(3, 6))%2 != 0);

        /** imagefilledpolygon($img, drawPoly($latis, $coloresnf, 180, $radius, $size), $latis, $coloresnf); */
        /** imagepolygon($img, drawPoly($latis, $colore, 180, $radius, $size), $latis, $colore); */
        $polygon = drawPolygon($latis, 180, $radius, $size, $colore);
        $polygon->setStyle('fill', $coloresnf)
            ->setAttribute('class', 'class-1');
        $doc->addChild($polygon);
    }

    if(mt_rand(0, 1)%2 == 0)
    {
        $ronad = mt_rand(0, 4);

        if($ronad%2 == 1)
        {
            for ($l = 0; $l < $lati + 4; $l++)
            {
                $ang = deg2rad((360 / ($lati + 4))) * $l;
                /** imageline($img, ($size / 2), ($size / 2), ($size / 2)+((($radius / 8) * 5) + 2) * cos($ang), ($size / 2) + ((($radius / 8) * 5) + 2) * sin($ang), $colore); */
                $line = new \SVG\Nodes\Shapes\SVGLine(($size / 2), ($size / 2), ($size / 2)+((($radius / 8) * 5) + 2) * cos($ang), ($size / 2) + ((($radius / 8) * 5) + 2) * sin($ang));
                $line->setStyle('stroke', $colore);
                $doc->addChild($line);
            }
            /** imagefilledpolygon($img, drawPoly($lati + 4, $colore, 0, $radius / 2, $size), $lati + 4, $coloresnf); */
            /** imagepolygon($img, drawPoly($lati + 4, $colore, 0, $radius / 2, $size), $lati + 4, $colore); */
            $polygon = drawPolygon($lati + 4, 0, $radius / 2, $size, $colore);
            $polygon->setStyle('fill', $coloresnf);
            $doc->addChild($polygon);
        }
        elseif($ronad%2 == 0 && $lati > 5)
        {
            for ($l = 0; $l < $lati - 2; $l++)
            {
                $ang = deg2rad((360 / ($lati - 2))) * $l;
                /** imageline($img, ($size / 2), ($size / 2), ($size / 2) + ((($radius / 8) * 5) + 2) * cos($ang), ($size / 2) + ((($radius / 8) * 5) + 2) * sin($ang), $colore); */
                $line = new \SVG\Nodes\Shapes\SVGLine(($size / 2), ($size / 2), ($size / 2) + ((($radius / 8) * 5) + 2) * cos($ang), ($size / 2) + ((($radius / 8) * 5) + 2) * sin($ang));
                $line->setStyle('stroke', $colore);
                $doc->addChild($line);
            }
            /** imagefilledpolygon($img, drawPoly($lati - 2, $colore, 0, $radius / 4, $size), $lati - 2, $coloresnf); */
            /** imagepolygon($img, drawPoly($lati - 2, $colore, 0, $radius / 4, $size), $lati - 2, $colore); */
            $polygon = drawPolygon($lati - 2, 0, $radius / 4, $size, $colore);
            $polygon->setStyle('fill', $coloresnf);
            $doc->addChild($polygon);
        }
    }

    if(mt_rand(0,4)%2 == 0)
    {
        /** imagearc($img, $size / 2, $size / 2, ($radius / 8) * 11, ($radius / 8) * 11, 0, 360, $colore); */
        $circle = new SVGCircle($size / 2, $size / 2, (($radius / 2) / 8) * 11);
        $circle->setStyle('fill', 'none')
            ->setStyle('stroke', $colore);
        $doc->addChild($circle);

        if($lati%2 == 0)
        {
            $latis = mt_rand(2, 8);
            while($latis%2 != 0) $latis = mt_rand(3, 8);

            /** imagepolygon($img, drawPoly($latis, $colore, 180, ($radius / 3) * 2, $size), $latis, $colore); */
            $polygon = drawPolygon($latis, 180, ($radius / 3) * 2, $size, $colore);
            $doc->addChild($polygon);
        }
        else
        {
            while(($latis = mt_rand(3, 8))%2 == 0);

            /** imagepolygon($img, drawPoly($latis, $colore, 180, ($radius / 3) * 2, $size), $latis, $colore); */
            $polygon = drawPolygon($latis, 180, ($radius / 3) * 2, $size, $colore);
            $doc->addChild($polygon);
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
            /** imagefilledarc($img, $size / 2 + $posax, $size / 2 + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $coloresnf, IMG_ARC_PIE); */
            /** imagearc($img, $size / 2 + $posax, $size / 2 + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $colore); */
            $circle = new SVGCircle($size / 2 + $posax, $size / 2 + $posay, (($radius/2) / 44) * 12);
            $circle->setStyle('fill', $coloresnf)
                ->setStyle('stroke', $colore);
            $doc->addChild($circle);
        }
    }
    elseif($case == 1)
    {
        for ($i=0; $i < $latis; $i++)
        {
            $angdiff = deg2rad(360 / $latis);
            $posax = $radius * cos($i * $angdiff);
            $posay = $radius * sin($i * $angdiff);
            /** imagefilledarc($img, $size / 2 + $posax, $size / 2 + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $coloresnf, IMG_ARC_PIE); */
            /** imagearc($img, $size / 2 + $posax, $size / 2 + $posay, ($radius / 44) * 12, ($radius / 44) * 12, 0, 360, $colore); */
            $circle = new SVGCircle($size / 2 + $posax, $size / 2 + $posay, (($radius/2) / 44) * 12);
            $circle->setStyle('fill', $coloresnf)
                ->setStyle('stroke', $colore);
            $doc->addChild($circle);
        }
    }
    elseif($case == 2)
    {
        /** imagearc($img, $size / 2, $size / 2, ($radius / 18) * 12, ($radius / 18) * 12, 0, 360, $colore); */
        $circle = new SVGCircle($size / 2, $size / 2, (($radius/2) / 18) * 12);
        $circle->setStyle('fill', 'none')
            ->setStyle('stroke', $colore);
        $doc->addChild($circle);
        /** imagefilledarc($img, $size / 2, $size / 2, ($radius / 22) * 12, ($radius / 22) * 12, 0, 360, $coloresnf, IMG_ARC_PIE); */
        /** imagearc($img, $size / 2, $size / 2, ($radius / 22) * 12, ($radius / 22) * 12, 0, 360, $colore); */
        $circle = new SVGCircle($size / 2, $size / 2, (($radius/2) / 22) * 12);
        $circle->setStyle('fill', $coloresnf)
            ->setStyle('stroke', $colore);
        $doc->addChild($circle);
    }
    elseif($case == 3)
    {
        for ($i = 0; $i < $latis; $i++)
        {
            $ang = deg2rad((360 / ($latis))) * $i;
            /** imageline($img, ($size / 2) + (($radius / 3) * 2) * cos($ang), ($size / 2) + (($radius / 3) * 2) * sin($ang), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang), $colore); */
            $line = new \SVG\Nodes\Shapes\SVGLine(($size / 2) + (($radius / 3) * 2) * cos($ang), ($size / 2) + (($radius / 3) * 2) * sin($ang), ($size / 2) + $radius * cos($ang), ($size / 2) + $radius * sin($ang));
            $line->setStyle('stroke', $colore);
            $doc->addChild($line);
        }
        if($latis == $lati)
        {
        }
        else
        {
            /** imagefilledarc($img, $size / 2, $size / 2, ($radius / 3) * 4, ($radius / 3) * 4, 0, 360, $coloresnf, IMG_ARC_PIE); */
            /** imagearc($img, $size / 2, $size / 2, ($radius / 3) * 4, ($radius / 3) * 4, 0, 360, $colore); */
            $circle = new SVGCircle($size / 2, $size / 2, (($radius/2) / 3) * 4);
            $circle->setStyle('fill', $coloresnf)
                ->setStyle('stroke', $colore);
            $doc->addChild($circle);
            $lati = mt_rand(3, 6);
            /** imagepolygon($img, drawPoly($lati, $colore, 0, ($radius / 4) * 5, $size), $lati, $colore); */
            $polygon = drawPolygon($lati, 0, ($radius / 4) * 5, $size, $colore);
            $doc->addChild($polygon);
            /** imagepolygon($img, drawPoly($lati, $colore, 180, ($radius / 3) * 2, $size), $lati, $colore); */
            $polygon = drawPolygon($lati, 180, ($radius / 3) * 2, $size, $colore);
            $doc->addChild($polygon);
        }
    }

    /** imagecolortransparent($img, $coloresnf); */

    /** header("Content-type: image/png"); */
    /** imagepng($img); */
    /** imagedestroy($img); */
    header('Content-Type: image/svg+xml');
    echo $image;

    function drawPolygon($sides, $rot, $radius, $size, $colore) {
        $values = array();
        $angdiff = deg2rad(360 / ($sides * 2));
        $rot = deg2rad($rot);

        for ($i = 0; $i < $sides * 2; $i+=2)
        {
            $values[] = array(
                ($size / 2) + $radius * cos($i * $angdiff + $rot), // X
                ($size / 2) + $radius * sin(($i) * $angdiff + $rot), // Y
            );
        }

        $polygon = new \SVG\Nodes\Shapes\SVGPolygon($values);
        $polygon->setStyle('fill', 'none')
            ->setStyle('stroke', $colore);

        return $polygon;
    }
