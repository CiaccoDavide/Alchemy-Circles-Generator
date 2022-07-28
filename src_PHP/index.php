<?php 
	$URL='./alchemy.php'; 
	$SVG='./alchemy-svg.php';

	if ($_GET['SVG'])
		$URL = $SVG;
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body{background:#111;color:#ddd;text-align: center;}
        .cerchio{background:#242424;display:inline-block;margin:6px;padding:6px;border:1px solid #333;transition-duration:1s;}
        .cerchio small{display:block;padding-bottom:3px;}
        .cerchio img{display:block;border:1px solid #161616;}
        a{color:#ddd;text-decoration: none;}
        a:hover .cerchio {border:1px solid #999;transition-duration:0s;}
        a:hover .cerchio small{color:#ddd;text-decoration:underline;}
        a:visited{color:#ddd;text-decoration:line-through;}
        a:visited .cerchio small{color:#ddd;text-decoration:line-through;}
    </style>
</head>
<body>
<?php
    for ($i=isset($_GET['n'])?$_GET['n']:100; $i > 0; $i--) {
        mt_srand();
        $id=mt_rand();
        //$id=$i;
        echo '<a href="'. $URL. '?id='.$id.'" target="_blank"><div class="cerchio"><small>#'.$id.'</small><img src="'.$URL.'?id='.$id.'"></div></a>';
    }
?>
</body>
</html>
