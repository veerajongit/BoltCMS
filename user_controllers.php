<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:39 PM
 */

include_once "controller.php";

class UserControllers extends Controller {

    //Define all your controllers here

    function blank() {
        $this->notification();
        $this->breadcrumbs();
        $this->userimage = 'http:/' . ROOT . "Views/AdminLTE/dist/img/user2-160x160.jpg";
        $this->userimage2 = 'http:/' . ROOT . "Views/AdminLTE/dist/img/user2-160x160.jpg";
        $this->h1 = "
        <h1>
            Blank page
            <small>it all starts here</small>
        </h1>
        ";

        $this->title = "Title";

        $this->body = "Start creating your amazing application!";
        $this->footer = "Footer";
    }

    function notification() {
        $this->notificationcountlabel = "";
        $this->notificationcount = 0;
    }

    function breadcrumbs() {
        $this->breadcrumb = "
        <ol class=\"breadcrumb\">
                <li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
                <li class=\"active\">Blank page</li>
            </ol>
        ";
    }

    function login() {
        $this->session->destroyall();
    }

    function error() {

    }
}