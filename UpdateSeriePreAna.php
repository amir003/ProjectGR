<?php

$serie = $argv[1];

$panel_name = getRunPanelName($serie);
$serie_p = ($panel_name != "") ? "$panel_name / $serie" : $serie;

$patients = GetPatient($serie);

$pdo = new PDO('mysql:host=localhost;dbname=Genetics_panelgenes', 'diagnostic', 'genpatho');

foreach($patients as $num_prlvt){

	$pdo->exec("update patients_from_libstock set serie = '$serie_p' where num_prlvt = '$num_prlvt'");
}


function GetPatient($serie){

	$patients = array();

	$pdo = new PDO('mysql:host=localhost;dbname=Genetics_panelgenes', 'diagnostic', 'genpatho');

	$query = $pdo->prepare("select distinct patient_id from library_$serie");

	$query->execute();

	while($row=$query->fetch()){
		$patient_id = explode("_S", $row['patient_id'])[0];

		array_push($patients, $patient_id);
	}

	return $patients;

}

function getRunPanelName($serie){
	$pdo = new PDO('mysql:host=localhost;dbname=Genetics_panelgenes', 'diagnostic', 'genpatho');

	$query1 = $pdo->prepare("SELECT run_serie FROM RUN_$serie;");
	
	$query1->execute();
	while($row1=$query1->fetch()){
		$run_serie = $row1['run_serie'];

		$info = "$run_serie";
	}
	
	return $info;
}

?>
