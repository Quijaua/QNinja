<?php
$template = '<li><a href="##INLINE_CONTENT_ID#" class="inline" data-submission-id="#SUBMISSION_ID#">#SUBMISSION_TITLE#</a>';
$template .= '<div style="display:none">';
$template .= '<div id="#INLINE_CONTENT_ID#" style="padding:10px; background:#fff;">';
$template .= '#SUBMISSION_DETAILS#';
$template .= '</div>';
$template .= '</li>';

$detailsTemplate = '<strong>#META_KEY#</strong>#META_VALUE#';

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
				$details_markup .= str_replace("#META_KEY#", $detail->meta_key, $detailsTemplate);
				$details_markup .= str_replace("#META_VALUE#", $detail->meta_value, $details_markup);
			}

		}
		$li    = str_replace("#SUBMISSION_DETAILS#", $details_markup, $li);
		$html .= $li;

	}
}
$html .= "</ul>";
echo $html;