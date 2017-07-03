<?php
      $id=$_GET['id'];
      //mt_rand();
      //$id=mt_rand();
      mt_srand($id);

	$pixelsize = 2;
	$size = 64*$pixelsize;

      //create the "canvas"
      $img = imagecreatetruecolor($size, $size);
/*
      $ncol=60;//min_colore 0
      $xcol=250;//max_colore 255

      //colors
      $coloreR=mt_rand($ncol,$xcol);
      $coloreG=mt_rand($ncol,$xcol);
      $coloreB=mt_rand($ncol,$xcol);

      $colore = imagecolorallocate($img,$coloreR,$coloreG,$coloreB);

*/
      $colore = imagecolorallocate($img,255,255,255);
      //backround color
      $coloresnf = imagecolorallocate($img,30,30,30);
      imagefilledrectangle($img, 0, 0, $size, $size, $coloresnf);
      //imagecolortransparent($img, $coloresnf); //toggle transparent background

      //draw the hexagon:
      //hexagon's center coordinates and radius
      $hex_x=($size/2);
      $hex_y=($size/2);
      $radius=($size/2)*3/4;

      imagearc($img,$size/2,$size/2,$radius*2,$radius*2,0,360,$colore);

      $lati=mt_rand(4,8);
      imagepolygon($img, drawPoly($lati,$colore,0,$radius,$size), $lati, $colore);

      for ($l=0; $l < $lati; $l++) {
            $ang=deg2rad((360/($lati)))*$l;
            imageline($img, ($size/2), ($size/2), ($size/2)+$radius*cos($ang), ($size/2)+$radius*sin($ang), $colore);
      }

      if($lati%2==0){
            $latis=mt_rand(2,6);
            while($latis%2!=0) $latis=mt_rand(3,6);
            imagefilledpolygon($img, drawPoly($latis,$coloresnf,180,$radius,$size), $latis, $coloresnf);
            imagepolygon($img, drawPoly($latis,$colore,180,$radius,$size), $latis, $colore);

            for ($l=0; $l < $latis; $l++) {
                  $ang=deg2rad((360/($latis)))*$l;
                  imageline($img, ($size/2), ($size/2), ($size/2)+$radius*cos($ang), ($size/2)+$radius*sin($ang), $colore);
            }
      }else{
            $latis=mt_rand(2,6);
            while($latis%2==0) $latis=mt_rand(3,6);
            imagefilledpolygon($img, drawPoly($latis,$coloresnf,180,$radius,$size), $latis, $coloresnf);
            imagepolygon($img, drawPoly($latis,$colore,180,$radius,$size), $latis, $colore);
      }




if(mt_rand(0,1)%2==0){
$ronad=mt_rand(0,4);
if($ronad%2==1){
            for ($l=0; $l < $lati+4; $l++) {
                  $ang=deg2rad((360/($lati+4)))*$l;
                  imageline($img, ($size/2), ($size/2), ($size/2)+((($radius/8)*5)+2)*cos($ang), ($size/2)+((($radius/8)*5)+2)*sin($ang), $colore);
            }
imagefilledpolygon($img, drawPoly($lati+4,$colore,0,$radius/2,$size),$lati+4,$coloresnf);
imagepolygon($img, drawPoly($lati+4,$colore,0,$radius/2,$size),$lati+4,$colore);
}elseif($ronad%2==0){
            for ($l=0; $l < $lati-2; $l++) {
                  $ang=deg2rad((360/($lati-2)))*$l;
                  imageline($img, ($size/2), ($size/2), ($size/2)+((($radius/8)*5)+2)*cos($ang), ($size/2)+((($radius/8)*5)+2)*sin($ang), $colore);
            }
imagefilledpolygon($img, drawPoly($lati-2,$colore,0,$radius/4,$size),$lati-2,$coloresnf);
imagepolygon($img, drawPoly($lati-2,$colore,0,$radius/4,$size),$lati-2,$colore);
}
}





      if(mt_rand(0,4)%2==0){
            imagearc($img,$size/2,$size/2,($radius/8)*11,($radius/8)*11,0,360,$colore);
            if($lati%2==0){
                  $latis=mt_rand(2,8);
                  while($latis%2!=0) $latis=mt_rand(3,8);
                  imagepolygon($img, drawPoly($latis,$colore,180,($radius/3)*2,$size), $latis, $colore);
            }else{
                  $latis=mt_rand(2,8);
                  while($latis%2==0) $latis=mt_rand(3,8);
                  imagepolygon($img, drawPoly($latis,$colore,180,($radius/3)*2,$size), $latis, $colore);
            }
      }

      $case=mt_rand(0,3);
      if($case==0){
          for ($i=0; $i < $latis; $i++) {
              $angdiff = deg2rad(360/($latis));
              $posax=(($radius/18)*11)*cos($i*$angdiff);
              $posay=(($radius/18)*11)*sin($i*$angdiff);
              imagefilledarc($img,$size/2+$posax,$size/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$size/2+$posax,$size/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$colore);
          }
      }elseif($case==1){
          for ($i=0; $i < $latis; $i++) {
              $angdiff = deg2rad(360/($latis));
              $posax=$radius*cos($i*$angdiff);
              $posay=$radius*sin($i*$angdiff);
              imagefilledarc($img,$size/2+$posax,$size/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$size/2+$posax,$size/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$colore);
          }
      }elseif($case==2) {
          imagearc($img,$size/2,$size/2,($radius/18)*12,($radius/18)*12,0,360,$colore);
          imagefilledarc($img,$size/2,$size/2,($radius/22)*12,($radius/22)*12,0,360,$coloresnf,IMG_ARC_PIE);
          imagearc($img,$size/2,$size/2,($radius/22)*12,($radius/22)*12,0,360,$colore);
      }elseif($case==3) {
          for ($i=0; $i < $latis; $i++) {
              $ang=deg2rad((360/($latis)))*$i;
              imageline($img, ($size/2)+(($radius/3)*2)*cos($ang), ($size/2)+(($radius/3)*2)*sin($ang), ($size/2)+$radius*cos($ang), ($size/2)+$radius*sin($ang), $colore);
          }
          if($latis==$lati){
          }else{
              imagefilledarc($img,$size/2,$size/2,(($radius/3)*4),(($radius/3)*4),0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$size/2,$size/2,(($radius/3)*4),(($radius/3)*4),0,360,$colore);
                    $lati=mt_rand(3,6);
                    imagepolygon($img, drawPoly($lati,$colore,0,(($radius/4)*5),$size), $lati, $colore);
                    imagepolygon($img, drawPoly($lati,$colore,180,(($radius/3)*2),$size), $lati, $colore);
          }
      }

imagecolortransparent($img, $coloresnf);

      header("Content-type: image/png");
      imagepng($img);
      imagedestroy($img);

      function drawPoly($sides,$colore,$rot,$radius,$size){
            //data graph values
            $values = array();
            $angdiff = deg2rad(360/($sides*2));
            $rot=deg2rad($rot);
            for ($i=0; $i < $sides*2; $i++) {
                  //trova i punti sulla circonferenza
                  $values[$i]=($size/2)+$radius*cos($i*$angdiff+$rot);    // X
                  $i++;
                  $values[$i]=($size/2)+$radius*sin(($i-1)*$angdiff+$rot);    // Y
            }
            return $values;
      }




























      /*<?php
      $id=$_GET['id'];
      //mt_rand();
      //$id=mt_rand();
      mt_srand($id);

	$pixelsize = 2;
	$height = 80*$pixelsize;
	$width = 80*$pixelsize;

      //create the "canvas"
      $img = imagecreatetruecolor($width, $height);

      $ncol=60;//min_colore 0
      $xcol=250;//max_colore 255

      //colors
      $coloreR=mt_rand($ncol,$xcol);
      $coloreG=mt_rand($ncol,$xcol);
      $coloreB=mt_rand($ncol,$xcol);

      $colore_lama = imagecolorallocate($img,$coloreR,$coloreG,$coloreB);
      $colore = imagecolorallocate($img,$coloreR,$coloreG,$coloreB);


      //backround color
      $coloresnf = imagecolorallocate($img,30,30,30);
      imagefilledrectangle($img, 0, 0, $width, $height, $coloresnf);
      //imagecolortransparent($img, $coloresnf); //toggle transparent background

      //draw the hexagon:
      //hexagon's center coordinates and radius
      $hex_x=80;
      $hex_y=80;
      $radius=60;

      imagearc($img,$height/2,$width/2,$radius*2,$radius*2,0,360,$colore);

      $lati=mt_rand(4,8);
      imagepolygon($img, drawPoly($lati,$colore_lama,0,$radius), $lati, $colore);

      for ($l=0; $l < $lati; $l++) {
            $ang=deg2rad((360/($lati)))*$l;
            imageline($img, 80, 80, 80+$radius*cos($ang), 80+$radius*sin($ang), $colore);
      }

      if($lati%2==0){
            $latis=mt_rand(2,6);
            while($latis%2!=0) $latis=mt_rand(3,6);
            imagefilledpolygon($img, drawPoly($latis,$coloresnf,180,$radius), $latis, $coloresnf);
            imagepolygon($img, drawPoly($latis,$colore_lama,180,$radius), $latis, $colore_lama);

            for ($l=0; $l < $latis; $l++) {
                  $ang=deg2rad((360/($latis)))*$l;
                  imageline($img, 80, 80, 80+$radius*cos($ang), 80+$radius*sin($ang), $colore);
            }
      }else{
            $latis=mt_rand(2,6);
            while($latis%2==0) $latis=mt_rand(3,6);
            imagefilledpolygon($img, drawPoly($latis,$coloresnf,180,$radius), $latis, $coloresnf);
            imagepolygon($img, drawPoly($latis,$colore_lama,180,$radius), $latis, $colore_lama);
      }




if(mt_rand(0,1)%2==0){
$ronad=mt_rand(0,4);
if($ronad%2==1){
            for ($l=0; $l < $lati+4; $l++) {
                  $ang=deg2rad((360/($lati+4)))*$l;
                  imageline($img, 80, 80, 80+((($radius/8)*5)+2)*cos($ang), 80+((($radius/8)*5)+2)*sin($ang), $colore);
            }
imagefilledpolygon($img, drawPoly($lati+4,$colore_lama,0,$radius/2),$lati+4,$coloresnf);
imagepolygon($img, drawPoly($lati+4,$colore_lama,0,$radius/2),$lati+4,$colore);
}elseif($ronad%2==0){
            for ($l=0; $l < $lati-2; $l++) {
                  $ang=deg2rad((360/($lati-2)))*$l;
                  imageline($img, 80, 80, 80+((($radius/8)*5)+2)*cos($ang), 80+((($radius/8)*5)+2)*sin($ang), $colore);
            }
imagefilledpolygon($img, drawPoly($lati-2,$colore_lama,0,$radius/4),$lati-2,$coloresnf);
imagepolygon($img, drawPoly($lati-2,$colore_lama,0,$radius/4),$lati-2,$colore);
}
}





      if(mt_rand(0,4)%2==0){
            imagearc($img,$height/2,$width/2,($radius/8)*11,($radius/8)*11,0,360,$colore);
            if($lati%2==0){
                  $latis=mt_rand(2,8);
                  while($latis%2!=0) $latis=mt_rand(3,8);
                  imagepolygon($img, drawPoly($latis,$colore_lama,180,($radius/3)*2), $latis, $colore_lama);
            }else{
                  $latis=mt_rand(2,8);
                  while($latis%2==0) $latis=mt_rand(3,8);
                  imagepolygon($img, drawPoly($latis,$colore_lama,180,($radius/3)*2), $latis, $colore_lama);
            }
      }

      $case=mt_rand(0,3);
      if($case==0){
          for ($i=0; $i < $latis; $i++) {
              $angdiff = deg2rad(360/($latis));
              $posax=(($radius/18)*11)*cos($i*$angdiff);
              $posay=(($radius/18)*11)*sin($i*$angdiff);
              imagefilledarc($img,$height/2+$posax,$width/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$height/2+$posax,$width/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$colore);
          }
      }elseif($case==1){
          for ($i=0; $i < $latis; $i++) {
              $angdiff = deg2rad(360/($latis));
              $posax=$radius*cos($i*$angdiff);
              $posay=$radius*sin($i*$angdiff);
              imagefilledarc($img,$height/2+$posax,$width/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$height/2+$posax,$width/2+$posay,($radius/44)*12,($radius/44)*12,0,360,$colore);
          }
      }elseif($case==2) {
          imagearc($img,$height/2,$width/2,($radius/18)*12,($radius/18)*12,0,360,$colore);
          imagefilledarc($img,$height/2,$width/2,($radius/22)*12,($radius/22)*12,0,360,$coloresnf,IMG_ARC_PIE);
          imagearc($img,$height/2,$width/2,($radius/22)*12,($radius/22)*12,0,360,$colore);
      }elseif($case==3) {
          for ($i=0; $i < $latis; $i++) {
              $ang=deg2rad((360/($latis)))*$i;
              imageline($img, 80+(($radius/3)*2)*cos($ang), 80+(($radius/3)*2)*sin($ang), 80+$radius*cos($ang), 80+$radius*sin($ang), $colore);
          }
          if($latis==$lati){
          }else{
              imagefilledarc($img,$height/2,$width/2,(($radius/3)*4),(($radius/3)*4),0,360,$coloresnf,IMG_ARC_PIE);
              imagearc($img,$height/2,$width/2,(($radius/3)*4),(($radius/3)*4),0,360,$colore);
                    $lati=mt_rand(3,6);
                    imagepolygon($img, drawPoly($lati,$colore_lama,0,(($radius/4)*5)), $lati, $colore);
                    imagepolygon($img, drawPoly($lati,$colore_lama,180,(($radius/3)*2)), $lati, $colore);
          }
      }


      header("Content-type: image/png");
      imagepng($img);
      imagedestroy($img);

      function drawPoly($sides,$colore_lama,$rot,$radius){
            //data graph values
            $values = array();
            $angdiff = deg2rad(360/($sides*2));
            $rot=deg2rad($rot);
            for ($i=0; $i < $sides*2; $i++) {
                  //trova i punti sulla circonferenza
                  $values[$i]=80+$radius*cos($i*$angdiff+$rot);    // X
                  $i++;
                  $values[$i]=80+$radius*sin(($i-1)*$angdiff+$rot);    // Y
            }
            return $values;
      }
?>
*/
?>
