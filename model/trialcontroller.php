<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 31/01/18
 * Time: 1:10 PM
 */

class TrialController extends Controller {

    function __construct() {
        parent::__construct();
    }

    function trial(){
        $this->trial = "something";
    }
}