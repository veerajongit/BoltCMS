<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:43 PM
 */

include_once "model.php";

class UserModel extends Model {
    //Define all the functions to access data here
    function __construct() {
        parent::__construct();
    }


    function getuserbyemailid($emailid) {
        /*
         * Fetching all users by email id from db
         */
        $sql = "SELECT * FROM `users` WHERE isdelete IS NULL AND emailid = '$emailid' ";
        return $this->retrievemysql($sql)['data'];
    }

}