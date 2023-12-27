<!DOCTYPE html>
<html lang="en">
<head>
<?php
	foreach($css as $file){ 
	echo "\n\t\t"; 
	?><link rel="stylesheet" href="<?php echo $file.'?v='.time();?>" type="text/css"/><?php
	} echo "\n\t"; 
?>
<?php
	if(!empty($meta)) 
	foreach($meta as $name=>$content){
		echo "\n\t\t"; 
		?><meta name="<?php echo $name;?>" content="<?php echo is_array($content) ? implode(", ", $content) : $content; ?>" /><?php
	}
?>
</head>
<body>
	<div class="card" style="padding:10px;">
		<?php echo $output;?>
	</div>
<?php
	foreach($js as $file){
	echo "\n\t\t"; 
	?><script src="<?php echo $file.'?v='.time(); ?>"></script><?php
	} echo "\n\t"; 
?>	
</body>
</html>