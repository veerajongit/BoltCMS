<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 22/04/17
 * Time: 12:07 PM
 */
//Takes all the routing varibales in array, return blank if none exists
if (isset($_GET["path"]) && $_GET["path"] != '') {
    $urlarray = explode('/', $_GET["path"]);
} else {
    $urlarray = array();
}

//Defining sessions in class
class Session {
    function __construct() {
        session_start();
        foreach ($_SESSION as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }

    function setsessionkey($key, $value) {
        $_SESSION[$key] = $value;
        $this->{$key} = $value;
    }

    function destroysessionkey($key) {
        unset($_SESSION[$key]);
        unset($this->{$key});
    }

    function destroyall() {
        foreach ($_SESSION as $skey => $svalue) {
            unset($_SESSION[$skey]);
            unset($this->{$skey});
        }
        session_destroy();
    }
}

//Defining get, post, files and request
class Get {
    function __construct() {
        foreach ($_GET as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}

class Post {
    function __construct() {
        foreach ($_POST as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}

class Request {
    function __construct() {
        foreach ($_REQUEST as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}

class Files {
    function __construct() {
        foreach ($_FILES as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}

//Database definitions MYSQL
$whitelist = array(
    '127.0.0.1',
    '::1'
);

if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    //WHEN RUNNING ON LOCALHOST
    define("SERVERNAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "localserverdb");
    define("SQLITEDBNAME", "localsqlitedb.sqlite");
} else {
    //WHEN RUNNING ON SERVER
    define("SERVERNAME", "localhost");
    define("USERNAME", "productionusername");
    define("PASSWORD", "productionpassword");
    define("DBNAME", "productionserverdb");
    define("SQLITEDBNAME", "productionserversqlitedb.sqlite");
}


//SET Root location of project
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    //WHEN RUNNING ON LOCALHOST
    define("ROOT", "/localhost/BoltCMS/");
} else {
    //WHEN RUNNING ON SERVER
    define("ROOT", "/");
}

define("USEPDOMYSQL", "NO");
define("USEPDOSQLITE", "NO");

//Enable Pagenot Found
define("PAGENOTFOUNDREDIRECT", "YES"); //SET LINK NAME IN index.php on line no