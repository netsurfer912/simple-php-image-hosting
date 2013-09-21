<?php
// Configuration
$title = 'Image Uploader';
$maxsize = 52428800; //max size in bytes
$allowedExts = array('png', 'jpg', 'jpeg', 'gif');
$allowedMime = array('image/png', 'image/jpeg', 'image/pjpeg', 'image/gif');
$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])
?>
<html>
<head>
	<!-- This simple image service is brought to you by netsurfer912, based on https://github.com/Spittie/simple-php-image-hosting-->
    <title><?php print $title; ?></title>
<link rel='stylesheet' href='normal.css' />
<link rel='stylesheet' media='(max-width: 800px)' href='small.css' />
</head>
<body>
	<h1>Upload your image. </h1>
	<div id="upload">
		<form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="52428800" />
		Choose a file to upload: <br />
		<input size="62"  name="file" type="file" accept="image/*" />
		<input type="submit" value="Upload Image" />
		</form>
		<div id="info">
		Maximal file size: 50MB <br/>
		All images allowed <br/>
		</div>
	</div>
	<div id="image">
	<a name="image">
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

		if ((in_array($_FILES['file']['type'], $allowedMime))
		&& (in_array(strtolower($ext), $allowedExts)) 
		&& (@getimagesize($_FILES['file']['tmp_name']) !== false)
		&& ($_FILES['file']['size'] <= $maxsize)) {
			$md5 = substr(md5_file($_FILES['file']['tmp_name']), 0, 7);
			$newname = time().$md5.'.'.$ext;
			move_uploaded_file($_FILES['file']['tmp_name'], $newname);
			$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
			$imgurl = 'http://'.$baseurl.'/'.$newname;
			print '<br />';
			print 'Direct link:<br />';
			print '<input type="text" value="'.$imgurl.'" readonly="readonly"><br /><br />';
			print 'BB-Code:<br />';
			print '<input type="text" value="[img]'.$imgurl.'[/img]" readonly="readonly"><br /><br />';
			print 'Preview:<br />';
			print '<a href="'.$imgurl.'"><img src="'.$imgurl.'" /></a><br />';
		}

		else {
			print '<p>';
			print '<strong lass="error">Something went wrong. If this keeps happening, please contact me. </strong>';
			print '</p>';
		}
		
	}
?>
	</div>
	<div id="footnote">This simple image sharing service is brought to you by netsurfer912. </div>
</body>
</html>

