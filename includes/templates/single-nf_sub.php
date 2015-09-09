<?php
$templateHtml = '#SUBMISSION_DETAILS#';
$html = "";
$exclude_fields = [];

get_header();

$current_post_id = $post->ID;
$details = getSubmissionDetails($current_post_id);

			if(is_array($details)) {
				$details_markup = "<p>";
				//
				
				foreach($details as $detail) {
					$label = getLabelByMetaKey($detail->meta_key);
					if(! is_serialized($detail->meta_value)) {
						if(! in_array(str_replace("_field_", "", $detail->meta_key), $exclude_fields))  {
							$details_markup .= "<strong>{$label}</strong> $detail->meta_value<br />";		
							//var_dump($details_markup);die;
						}
					}
					if(is_serialized($detail->meta_value)) {
						$data = unserialize($detail->meta_value);
						$data_keys = array_keys($data);
						if(isset($data[$data_keys[0]]['file_url'])) {
							$file_url = $data[$data_keys[0]]['file_url'];
							if(! in_array(str_replace("_field_", "", $detail->meta_key), $exclude_fields))  {
								$details_markup .= "<strong>{$label}</strong><img src='{$file_url}'><br />";
							}
							
						}

						if(is_array($data)) {
							if(! in_array(str_replace("_field_", "", $detail->meta_key), $exclude_fields))  {
								$details_markup .= "<strong>{$label}</strong><ul>";
								foreach($data as $key => $item) {
									if(isset($item['file_url'])) {
										$file_url = $item['file_url'];
										$details_markup .= "<img src='{$file_url}'>";
									}

									if(! isset($item['file_url'])) {
										$details_markup .= $item;
										if($key != count($data) - 1) {
											$details_markup .= ", ";

										}
									}
								}

								

							}
						}
					}
					
					
				}
				$details_markup .= "</p>";
				$li    = str_replace("#SUBMISSION_DETAILS#", $details_markup, $templateHtml);	
			//
			}
			$html .= $li;
echo $html;	
get_footer();
