<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 18/04/17
 * Time: 8:57 AM
 */
include_once "routes.php";
include_once "user_controllers.php";

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

$presenturlcount = count(explode('/', $_GET["path"]));
foreach ($newrouter->routes as $route) {
    $routerurlcount = count(explode('/', $route[0]));
    if ($presenturlcount == $routerurlcount) {
        if (substr($route[0], -1) == "*") {
            $match = "/" . str_replace('/*', '\/(.*)', $route[0]) . "/";
            if (preg_match($match, $_GET["path"])) {
                $output = file_get_contents("Views/" . $route[2] . ".html");

                if ($route[1] != "") {
                    $controller->{$route[1]}();
                    $controllerarray = get_object_vars($controller);

                    foreach ($controllerarray as $ckey => $cvar) {
                        if (!is_array($cvar) && !is_object($cvar)) {
                            $output = str_replace("%" . $ckey . "%", $cvar, $output);
                        }
                    }
                }
            }
        } else {
            if ($route[0] == $_GET["path"]) {
                $output = file_get_contents("Views/" . $route[2] . ".html");

                if ($route[1] != "") {
                    $controller->{$route[1]}();
                    $controllerarray = get_object_vars($controller);

                    foreach ($controllerarray as $ckey => $cvar) {
                        if (!is_array($cvar) && !is_object($cvar)) {
                            $output = str_replace("%" . $ckey . "%", $cvar, $output);
                        }
                    }
                }
            }
        }
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