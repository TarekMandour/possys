<?php
use App\Models\Language;
$language_data = Language::get()->toArray();

foreach ($language_data as $lang) {
	$return_array[$lang['slug']] = $lang['ar_name'];
}

return $return_array;