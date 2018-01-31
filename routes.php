<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 8:55 AM
 */

//Route will work without controller but view is compulsory
class router {
    function __construct() {
        include_once "definations.php";
        $this->routes = array();
        //Define all your routes here
        //array_push($this->routes, array(route_name, controllerfunction_name, viewfunction_name));
        array_push($this->routes, array("blank", 'blank', "blank", "UserControllers"));
        array_push($this->routes, array("", 'login', "login", "UserControllers"));
        array_push($this->routes, array("trial", 'trial', "trial", "TrialController"));

        if (PAGENOTFOUNDREDIRECT == "YES") {
            array_push($this->routes, array("404error", "error", "error", "UserControllers"));
        }

        //End of all routes definitions
        $this->checkduplicate($this->routes);
    }

    function checkduplicate($array) {
        $elementarray = array();

        foreach ($array as $arr) {
            $elementarray[] = $arr[0];
        }
        foreach (array_count_values($elementarray) as $key => $value) {
            if ($value == 2) {
                echo "Route has redundant value of " . $key . ". Please Check the routing contructor.";
                exit;
            }
        }

    }
}


function ob_html_compress($buf) {
    return str_replace(array("\n", "\r", "\t"), '', $buf);
}


function loader() {
    $output = "";
    $newrouter = new router();
    $presenturlcount = count(explode('/', $_GET["path"]));
    foreach ($newrouter->routes as $route) {
        $routerurlcount = count(explode('/', $route[0]));
        if ($presenturlcount == $routerurlcount) {
            if (substr($route[0], -1) == "*") {
                $match = "/" . str_replace('/*', '\/(.*)', $route[0]) . "/";
                if (preg_match($match, $_GET["path"])) {
                    $output = file_get_contents("Views/" . $route[2] . ".html");

                    if ($route[1] != "") {
                        $className = $route[3];
                        $controller = new $className();
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
                        $className = $route[3];
                        $controller = new $className();
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
    return $output;
}