<?php
$info = file_get_contents("http://orange.cfapps.io/data");
$json = json_decode($info, true);
//print_r($json);

# Sensor variable mapping

$count = array(
			"homeSmokeAlarmOn" => 0,
			"homeSmokeAlarmBatteryLow" => 0,
			"homeDoorUnlocked" => 0,
			"homeWindowOpenNight" => 0,
			"homeGarageOpen" => 0,
			"homeWaterSensorOn" => 0,
			"homeTemperatureHigh" => 0
	);
$waterRisk=0;
foreach ($json as $data){
	$entry = $data["data"];
	$value = $entry["data"];
	if (!empty($value['homeSmokeAlarmOn'])){
		$count["homeSmokeAlarmOn"] = $count["homeSmokeAlarmOn"] + 1;
	}
	if (!empty($value['homeSmokeAlarmBatteryLow'])){
		$count["homeSmokeAlarmBatteryLow"] = $count["homeSmokeAlarmBatteryLow"] + 1;
	}
	if (!empty($value['homeWindowOpen'])){ 
		$count["homeDoorUnlocked"] = $count["homeDoorUnlocked"] + 1;
	}
	if (!empty($value['homeWindowClosed'])){
		$window = $value['homeWindowClosed'];
		if ($window[1] == "rainy"){
			$waterRisk = $waterRisk + intval($window[0]);
		}
		$count["homeWindowOpenNight"] = $count["homeWindowOpenNight"] + intval($window[0]);
	}
	if (!empty($value['homeGarageOpen'])){
		$count["homeGarageOpen"] = $count["homeGarageOpen"] + 1;
	}
	if (!empty($value['homeWaterSensorAlarmOn'])){
		$count["homeWaterSensorOn"] = $count["homeWaterSensorOn"] + 1;
	}
	if (!empty($value['homeFireAlarmOn'])){
		$count["homeTemperatureHigh"] = $count["homeTemperatureHigh"] + 1;
	}
	if (!empty($value['homeFireAlarmOff'])){
		$count["homeTemperatureHigh"] = $count["homeTemperatureHigh"] + 1;
	}
}

$s1 = 10-$count["homeSmokeAlarmOn"];
$s2 = 10-0.5*$count["homeSmokeAlarmBatteryLow"];
$s3 = 10-$count["homeDoorUnlocked"]/72;
$s4 = 10-$count["homeWindowOpenNight"]/72;
$s5 = 10-$count["homeGarageOpen"]/36;
$s6 = 10-3*$count["homeWaterSensorOn"]-0.5*$waterRisk;
$s7 = 10-$count["homeTemperatureHigh"];

$rate='A';
$score = ($s1+$s2+$s3+$s4+$s5+$s6+$s7)*10/7;
if ($score >90) {
	$rate = 'A';
} else if ($score > 80) {
	$rate = 'B';
} else if ($score >70) {
	$rate = 'C';
} else if ($socre >60) {
	$rate = 'D';
} else {
	$rate = 'F';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title>Blue Orange</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="starter-template.css" rel="stylesheet">
    <script src="ie-emulation-modes-warning.js"></script>
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Blue Orange</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="starter-template">
        <h1>Your Home Risk and Safety Index</h1>
        <p class="lead">Use this web app to track your connected home safety score!<br> Allstate Connected Home Hackathon - UIUC 2015</p>
          <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Overall</h3>
            </div>
            <div class="panel-body">
              <?php echo $rate;?>
            </div>
          </div>
        </div><!-- /.col-sm-3 -->
      </div>
      <div class="page-header">
        <h1>Risk and Safety Index Breakdown</h1>
      </div>      
      <div class="row">
        <div class="col-sm-3">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Smoke Alarm Triggers</h3>
            </div>
            <div class="panel-body">
            <?php echo number_format($s1, 2, '.', '');?>
            </div>
          </div>
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Smoke Alarm Battery</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s2, 2, '.', '');?>
            </div>
          </div>
        </div><!-- /.col-sm-3 -->
        <div class="col-sm-3">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Fire Hazard Awareness</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s7, 2, '.', '');?>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Open Garage Door Awareness</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s5, 2, '.', '');?>
            </div>
          </div>
        </div><!-- /.col-sm-3 -->
        <div class="col-sm-3">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Unlocked Windows Awareness</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s4, 2, '.', '');?>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Unlocked Door Awareness</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s3, 2, '.', '');?>
            </div>
          </div>
        </div><!-- /.col-sm-3 -->
        <div class="col-sm-3">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title">Water Risk Awareness</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($s6, 2, '.', '');?>
            </div>
          </div>
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Overall</h3>
            </div>
            <div class="panel-body">
              <?php echo number_format($score/10, 2, '.', '');?>
            </div>
          </div>
        </div><!-- /.col-sm-3 -->
      </div>
    </div><!-- /.container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
