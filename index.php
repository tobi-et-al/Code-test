<?php
require_once "vendor/autoload.php";

use App\Lib\ApiConnectClass as ApiConnectClass;

$deathStarConnect = new ApiConnectClass();

//Delete reactor
$deathStarConnect->deleteExhaust(0);

//get Prisoner
print_r($deathStarConnect->getPrisoner("leia"));
