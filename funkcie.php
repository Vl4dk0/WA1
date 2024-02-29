<?php
function vypis_select($zac, $kon, $default = 0) {
	for($i = $zac; $i <= $kon; $i++) {
		echo "<option value='$i'";
		if ($i == $default) echo ' selected';
		echo ">$i</option>\n";
	}
}

function hlavicka($nadpis) {
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php if ($nadpis == '') $nadpis = 'UWT sportcar'; echo $nadpis; ?></title>
    <link href="styly.css" rel="stylesheet">
</head>

<body>
    <div id="dekoracne_obr">
        <img src="obrazky/m_Maserati-GT-Stradale.jpg" alt="Maserati-GranTurismo-MC-Stradale"
            title="Maserati-GranTurismo-MC-Stradale" height="59" width="150"> <img src="obrazky/m_Ferrari-458.jpg"
            alt="Ferrari-458-Italia" title="Ferrari-458-Italia" height="64" width="150"> <img
            src="obrazky/m_Aston-Martin.jpg" alt="Aston-Martin-DBSCoupe" title="Aston-Martin-DBSCoupe" height="63"
            width="150"> <img src="obrazky/m_Lamborghini-Gallardo.jpg" alt="Lamborghini-Gallardo-LP-570-4-Superleggera"
            title="Lamborghini-Gallardo-LP-570-4-Superleggera" height="66" width="150">
    </div>
    <div id="main">
        <header>
            <h1><?php echo $nadpis; ?></h1>
        </header>
        <?php
}

?>