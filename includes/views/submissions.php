<?php
$template = '<li><a href="javascript:void(0);" data-submission-id="#SUBMISSION_ID#">#SUBMISSION_TITLE#</a></li>';
$html = "<ul>";
if(is_array($submissions)) {
	foreach($submissions as $submission) {
		$li    = str_replace("#SUBMISSION_ID#", $submission->ID, $template);
		$li    = str_replace("#SUBMISSION_TITLE#", $submission->submissionTitle, $li);
		$html .= $li;
	}
}
$html .= "</ul>";
echo $html;