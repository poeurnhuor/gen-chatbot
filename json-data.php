<?php

function displayData(){
	$myBio = array(
		"first-name" => "Huor",
		"last-name" => "Poeurn",
		"phone" => "0966707122",
		"gender" => "M",
		"dob" => "04/03/1996",
		"pob" => "Banteay Mean Chey Province",
		"social" => array(
			"fb" => array(
				"name" => "Poeurn Huor",
				"link" => "",
				),
			"github" => array(
				"name" => "Huor Poeurn",
				"link" => "",
				),
			),
	);

	return json_encode($myBio);
}
print_r(displayData());
?>