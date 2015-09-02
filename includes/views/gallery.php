<?php
$template = '<p><a class="nf_gallery" href="#FILE_URL#" title="#FORM_ID#">#FORM#</a></p>';
$html = "<h1>Galeria de Fotos</h1>";

if(is_array($uploads)) {
	foreach($uploads as $upload) {
		$upload_metadata = unserialize($upload->data);
		$file_url = $upload_metadata['file_url'];

		$photo    = str_replace("#FILE_URL#", $file_url, $template);
		$photo    = str_replace("#FORM#", '<img src="'.$file_url.'" width="50" height="50" >', $photo);
		$photo    = str_replace("#FORM_ID#", $upload->meta_value, $photo);
		$html .= $photo;
	}
	
}
 echo $html;