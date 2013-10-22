<?php

/**
 * Script to detect big changes between runs.
 *
 * More useful when running it through CLI
 */

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

require_once(__DIR__ . '/webapp/classes/test_plan_runs.php');
require_once(__DIR__ . '/webapp/classes/report.php');

// TODO: $argv + json_decode to get the array.
// General 2% and specific 1%.
$thresholds = array(
    'bystep' => array(),
    'total' => array()
);

foreach (test_plan_run::$runvars as $var) {
    $thresholds['bystep'][$var] = 5;
    $thresholds['total'][$var] = 5;

}

// TODO: Get timestamps to compare from $argv
$timestamps = array('1382413089482', '1382412922440');
$report = new report();
if (!$report->parse_runs($timestamps)) {
    var_dump($report->get_errors());
    die('The selected runs are not comparable');
}
$changes = $report->get_big_differences($thresholds);

echo 'Differences:' . PHP_EOL;
foreach ($changes as $var => $steps) {
    foreach ($steps as $stepname => $info) {
        echo "$var - $stepname: $info" . PHP_EOL;
    }
}
