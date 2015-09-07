<?php
$template = '<li><a href="##INLINE_CONTENT_ID#" class="inline" data-submission-id="#SUBMISSION_ID#">#SUBMISSION_TITLE#</a>';
$template .= '<div style="display:none">';
$template .= '<div id="#INLINE_CONTENT_ID#" style="padding:10px; background:#fff;">';
$template .= '<h1>#SUBMISSION_TITLE#</h1>';
$template .= '#SUBMISSION_DETAILS#';
$template .= '</div>';
$template .= '</li>';



$html = "<ul>";
if(is_array($submissions)) {
	foreach($submissions as $submission) {

		if(empty($form_id)) {
			$show_submission = true;
		}
		
		if(!empty($form_id)) {
			$show_submission = get_post_meta($submission->ID, '_form_id', true) == $form_id;
		}

		if($show_submission) {
			$li    = str_replace("#SUBMISSION_ID#", $submission->ID, $template);
			$li    = str_replace("#SUBMISSION_TITLE#", $submission->submissionTitle, $li);
			$li    = str_replace("#INLINE_CONTENT_ID#", 'inline-content-'.$submission->ID, $li);
			$details = getSubmissionDetails($submission->ID);

			if(is_array($details)) {
				$details_markup = "";
				foreach($details as $detail) {

					$label = getLabelByMetaKey($detail->meta_key);
					if(! is_serialized($detail->meta_value)) {
						$details_markup .= "<strong>{$label}</strong> $detail->meta_value<br />";	
					}
					if(is_serialized($detail->meta_value)) {
						$data = unserialize($detail->meta_value);
						$data_keys = array_keys($data);
						if(isset($data[$data_keys[0]]['file_url'])) {
							$file_url = $data[$data_keys[0]]['file_url'];
							$details_markup .= "<strong>{$label}</strong><img src='{$file_url}'><br />";
						}

						if(is_array($data)) {
							$details_markup .= "<strong>{$label}</strong><ul>";
							foreach($data as $key => $item) {
								if(isset($item['file_url'])) {
									$file_url = $item['file_url'];
									$details_markup .= "<li><img src='{$file_url}'></li>";
								}

								if(! isset($item['file_url'])) {
									$details_markup .= $item;
									if($key != count($data) - 1) {
										$details_markup .= ", ";

									}
								}
							}

							$details_markup .= "<ul>";

						}
					}
					
					
				}
			$li    = str_replace("#SUBMISSION_DETAILS#", $details_markup, $li);	
			}
			$html .= $li;
		}
		
		

	}
}
$html .= "</ul>";
echo $html;
