<?php
$template = '<p><a class="nf_gallery" href="#FILE_URL#" title="#FORM#">#FORM#</a></p>';
$html = "<h1>Galeria de Fotos</h1>";

if(is_array($uploads)) {
	foreach($uploads as $upload) {
		$upload_metadata = unserialize($upload->data);

		$photo    = str_replace("#FILE_URL#", $upload_metadata['file_url'], $template);
		$photo    = str_replace("#FORM#", $upload->meta_value, $photo);
		$html .= $photo;
	}
	
}
 echo $html;