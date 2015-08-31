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
		$li    = str_replace("#SUBMISSION_ID#", $submission->ID, $template);
		$li    = str_replace("#SUBMISSION_TITLE#", $submission->submissionTitle, $li);
		$li    = str_replace("#INLINE_CONTENT_ID#", 'inline-content-'.$submission->ID, $li);
		$details = getSubmissionDetails($submission->ID);

		if(is_array($details)) {
			$details_markup = "";
			foreach($details as $detail) {

				$label = getLabelByMetaKey($detail->meta_key);
				//if($label !== "Submit") {
					$details_markup .= "<strong>{$label}</strong> $detail->meta_value<br />";
				//}
				
			}
		$li    = str_replace("#SUBMISSION_DETAILS#", $details_markup, $li);	
		}
		$html .= $li;

	}
}
$html .= "</ul>";
echo $html;