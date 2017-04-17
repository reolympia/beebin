<?php

$dir    = 'uploads';
$files  = scandir($dir);

?>
<html>
<head>   
<title>Beebin</title>
 
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="dropzone.css" type="text/css" rel="stylesheet">
<link href="mini-default.min.css" type="text/css" rel="stylesheet">
 
<script src="dropzone.js"></script>
 
<style>
.center {
    margin-left: auto;
    margin-right: auto;
    width: 3.7em
}
.dropzone { border: 2px dashed #0087F7; border-radius: 5px; background: white; }
.dropzone .dz-message { font-weight: 400; }
.dropzone .dz-message .note { font-size: 0.8em; font-weight: 200; display: block; margin-top: 1.4rem; }

</style>
</head>
 
<body>
<header>
  <a href="#" class="logo">Beebin</a>
  <span>Temporary file storage</span>
</header>
<div class="container">
 
<form action="/process.php" class="dropzone" id="dropzone">
  <div class="fallback">
    <input name="file" type="file" multiple>
  </div>
</form>

<table>
	<th>File Name</th>
	<th>Size (Bytes)</th>
	<th>Direct URL</th>
	<th>Uploaded</th>
	<th>Expires</th>
	<?php foreach($files as $file) { 
		if (($file == '.') || ($file == '..')) {
			continue;
		}
		$filename = 'uploads/'.$file;
		$filedate = date("F d Y H:i:s", filemtime($filename));
		$exp_date = date( "F d Y", strtotime($filedate." +1 week" ) ); 
		$todays_date = date("F d Y"); 
		$today = strtotime($todays_date); 
		$expiration_date = strtotime($exp_date);
		if ($expiration_date < $today) { 
			unlink($filename);
			continue; 
		} 
	?>
	<tr>
		<td><?php echo $file; ?></td>
		<td><?php echo filesize($filename); ?></td>
		<td><a href="http://beebin.com/uploads/<?php echo $file; ?>">http://beebin.com/uploads/<?php echo $file; ?></a></td>
		<td><?php echo $filedate; ?></td>
		<td><?php echo $exp_date; ?></td>
	</tr>

	<?php  } ?>
</table>
   
<div class="center">
	<a href="/" class="button inverse center">Refresh</a>
</div>

</div>
<script type="text/javascript">

Dropzone.options.dropzone = {
  maxFilesize: 2000,
  dictDefaultMessage: "Drop files here to upload<br>(or click to select a file)"
};
</script>


</body>
</html>
