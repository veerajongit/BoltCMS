<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 18/04/17
 * Time: 8:57 AM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once "routes.php";
include_once "controller.php";
/* Define all controllers here */
include_once "model/user_controllers.php";
include_once "model/trialcontroller.php";


//$trial = new TrialController();
if (!isset($_GET["path"])) {
    $_GET["path"] = "";
}

ob_start();

$output = loader();
if (isset($output)) {
    echo $output;
}


$finaloutput = trim(ob_get_clean());

//Compressing html output, by removing whitespace, comments etc
if (HTMLCOMPRESSION == "YES") {
    $finaloutput = ob_html_compress($finaloutput);
    $finaloutput = preg_replace('/<!--(.|\s)*?-->/', '', $finaloutput);
}

if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT == "YES") {
    header('location:http:/' . ROOT . '404error');
} else {
    if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT != "YES") {
        echo "Page Error";
    } else {
        echo $finaloutput;
    }
}