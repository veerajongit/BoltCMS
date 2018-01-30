<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 18/04/17
 * Time: 8:57 AM
 */
include_once "routes.php";

function sanitize_output($buffer) {
    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );
    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}


$newrouter = new router();
$controller = new UserControllers();

if (!isset($_GET["path"])) {
    $_GET["path"] = "";
}

ob_start();
function setview($arr){
    if (file_exists("Views/" . $arr . ".html")) {
        return $output = file_get_contents("Views/" . $arr . ".html");
    } else {
        echo "The file \"Views/\" . $arr . \".html\" does not exist";
        exit;
    }
}
$presenturlcount = count(explode('/', $_GET["path"]));
$output = "";
foreach ($newrouter->routes as $route) {
    $routerurlcount = count(explode('/', $route[0]));
    if ($presenturlcount == $routerurlcount) {
        if (substr($route[0], -1) == "*") {
            $match = "/" . str_replace('/*', '\/(.*)', $route[0]) . "/";
            if (preg_match($match, $_GET["path"])) {
                $route[1];
                $output = setview($route[2]);
            }
        } else {
            if ($route[0] == $_GET["path"]) {
                $route[1];
                $output = setview($route[2]);
            }
        }
    }
}

$controllerarray = get_object_vars($newrouter->controller);

foreach ($controllerarray as $ckey => $cvar) {
    if (!is_array($cvar) && !is_object($cvar)) {
        $output = str_replace("%" . $ckey . "%", $cvar, $output);
    }
}
if (isset($output)) {
    echo $output;
}

$finaloutput = trim(ob_get_clean());

if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT == "YES") {
    header('location:http:/' . ROOT . '404error');
} else {
    if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT != "YES") {
        echo "Page Error";
    } else {
        echo sanitize_output($finaloutput);
    }
}