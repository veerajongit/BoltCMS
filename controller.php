<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 9:17 AM
 */
//header('location:http:/'.ROOT.'pagename'); <- Use this incase session not present on to redirect to a particular page
class Controller {

    function __construct() {
        include_once "definations.php";
        if (isset($urlarray)) {
            $this->urlarray = $urlarray;
        } else {
            $this->urlarray = array();
        }
        $this->session = new Session();
        $this->get = new Get();
        $this->post = new Post();
        $this->request = new Request();

        include_once "user_model.php";
        $this->model = new UserModel();

        $this->ROOT = 'http:/' . ROOT;


        //Some common defaults
        $this->head = '
        <link rel="shortcut icon" href="http:/' . ROOT . 'favicon.ico" type="image/x-icon" />
        <!-- Tell the browser to be responsive to screen width -->
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <!-- Bootstrap 3.3.7 -->
          <link rel="stylesheet" href="http:/' . ROOT . 'Views/AdminLTE/bootstrap/css/bootstrap.min.css">
          <!-- Font Awesome -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
          <!-- Ionicons -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
          <!-- Theme style -->
          <link rel="stylesheet" href="http:/' . ROOT . 'Views/AdminLTE/dist/css/AdminLTE.min.css">
          <!-- AdminLTE Skins. Choose a skin from the css/skins
               folder instead of downloading all of them to reduce the load. -->
          <link rel="stylesheet" href="http:/' . ROOT . 'Views/AdminLTE/dist/css/skins/_all-skins.min.css">
        
          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
          <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        ';

        $this->foot = '
        <!-- jQuery 2.2.3 -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
            <!-- Bootstrap 3.3.7 -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
            <!-- SlimScroll -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
            <!-- FastClick -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/plugins/fastclick/fastclick.js"></script>
            <!-- AdminLTE App -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/dist/js/app.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="http:/' . ROOT . 'Views/AdminLTE/dist/js/demo.js"></script>
        ';

        $this->rights = '
        <strong>Copyright &copy; ' . date("Y") . ' <a href="http://3iology.com">3iology</a>.</strong> All rights
        reserved.
        ';

        $this->header = "
            <header class=\"main-header\">
        <!-- Logo -->
        <a href=\"#\" class=\"logo\">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class=\"logo-mini\"><b>B</b>MS</span>
            <!-- logo for regular state and mobile devices -->
            <span class=\"logo-lg\"><b>Bolt</b>CMS</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class=\"navbar navbar-static-top\">
            <!-- Sidebar toggle button-->
            <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </a>

            <div class=\"navbar-custom-menu\">
                <ul class=\"nav navbar-nav\">
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class=\"dropdown notifications-menu\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                            <i class=\"fa fa-bell-o\"></i>
                            <span class=\"label label-warning\">%notificationcountlabel%</span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li class=\"header\">You have %notificationcount% notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class=\"menu\">
                                    <li>
                                        <a href=\"#\">
                                            <i class=\"fa fa-users text-aqua\"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"footer\"><a href=\"#\">View all</a></li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class=\"dropdown user user-menu\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                            <img src=\"%userimage2%\" class=\"user-image\" alt=\"User Image\">
                            <span class=\"hidden-xs\">Alexander Pierce</span>
                        </a>
                        <ul class=\"dropdown-menu\" style=\"width: 100px\">
                            <!-- Menu Footer-->
                            <li class=\"\">
                                <a href=\"" . $this->ROOT . "\">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
        ";
    }
}
