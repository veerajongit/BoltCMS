<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:39 PM
 */

class UserControllers extends Controller {

    function __construct() {
        parent::__construct();
    }

    //Define all your controllers here
    function blank() {
        $this->checksession();
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
        $this->loginerror = '';
        if (isset($this->post->email) && isset($this->post->password)) {
            $result = $this->model->getuserbyemailid($this->post->email);
            if (count($result) == 0) {
                $this->loginerror = "Invalid Email Id";
            } else {
                $hash = new hashing();
                if (!$hash->checkhash($this->post->password, $result[0]['password'])) {
                    //Password Mismatched
                    $this->loginerror = "Password does not match";
                } else {
                    $this->loginerror = "Login success";
                    $this->session->setsessionkey('userdetails', $result[0]);
                    header("location:http:/" . ROOT . "blank");
                    exit;
                }
            }
        }
        $this->session->destroyall();
    }

    function error() {

    }
}