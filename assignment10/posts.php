<?php
include "lib/constants.php";
require_once('lib/custom-functions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Blog</title>
        <meta charset="utf-8">
        <meta name="author" content="Nidhi Singh">
        <meta name="description" content="UVM course, teachers, student list">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/base.css" type="text/css" media="screen">

        <?php
        $debug = false;

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries. Note some are in lib and some are in bin
        // bin should be located at the same level as www-root (it is not in 
        // github)
        // 
        // yourusername
        //     bin
        //     www-logs
        //     www-root


        $includeDBPath = "../bin/";
        $includeLibPath = "../lib/";


        require_once($includeLibPath . 'mailMessage.php');

        require_once('lib/security.php');

        require_once($includeDBPath . 'Database.php');

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // PATH SETUP
        //  
        // sanitize the server global variable
        $_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        foreach ($_SERVER as $key => $value) {
            $_SERVER[$key] = sanitize($value, false);
        }

        $domain = "//"; // let the server set http or https as needed

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }

        $yourURL = $domain . $phpSelf;

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        // sanatize global variables 
        // function sanitize($string, $spacesAllowed)
        // no spaces are allowed on most pages but your form will most likley
        // need to accept spaces. Notice my use of an array to specfiy whcih 
        // pages are allowed.
        // generally our forms dont contain an array of elements. Sometimes
        // I have an array of check boxes so i would have to sanatize that, here
        // i skip it.

        $spaceAllowedPages = array("form.php");

        if (!empty($_GET)) {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
            foreach ($_GET as $key => $value) {
                $_GET[$key] = sanitize($value, false);
            }
        }

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Process security check.
        //
        
        if (!securityCheck($path_parts, $yourURL)) {
            print "<p>Login failed: " . date("F j, Y") . " at " . date("h:i:s") . "</p>\n";
            die("<p>Sorry you cannot access this page. Security breach detected and reported</p>");
        }

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Set up database connection
        //
        
        $dbUserName = get_current_user() . '_reader';
        $whichPass = "r"; //flag for which one to use.
        $dbName = DATABASE_NAME;

        $thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = get_current_user() . '_writer';
        $whichPass = "w";
        $thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = get_current_user() . '_admin';
        $whichPass = "a";
        $thisDatabaseAdmin = new Database($dbUserName, $whichPass, $dbName);
        ?>	
        <script type="text/javascript">

            var xmlhttp;
            var num;

// this function gets the file specified in the url
            function loadXMLDoc($num) {
                xmlhttp = null;
                if (window.XMLHttpRequest) {// code for Firefox, Opera, IE7, etc.
                    xmlhttp = new XMLHttpRequest();
                } else if (window.ActiveXObject) {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }

                if (xmlhttp != null) {
                    xmlhttp.onreadystatechange = state_Change;
                    xmlhttp.open("GET", "likes.php?id=" + $num, true);
                    xmlhttp.send();
                } else {
                    alert("Your browser does not support XMLHTTP.");
                }
            }

            function state_Change() {
                if (xmlhttp.readyState == 4) {// 4 = "loaded"
                    if (xmlhttp.status == 200) {// 200 = "OK"
                        document.getElementById('putTextHere').innerHTML = xmlhttp.responseText;
                    } else {
                        alert("Problem retrieving data:" + xmlhttp.statusText);
                    }
                }
            }
        </script>


    </head>

    <!-- **********************     Body section      ********************** -->
    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    include "header.php";
    include "nav.php";

    /* the purpose of this page is to display a form to allow a poet and allow us
     * to add a new poet or update an existing poet 
     * 
     * Written By: Robert Erickson robert.erickson@uvm.edu

     */

    //include "top.php";


    print'<article>';

    print '<h1>Motivational Posts</h1>';

    print '<table>';

    $query = 'select M.fldFirstName,M.fldLastName,P.fldDesc,P.fldTitle,P.fldContent,P.fldDate,P.fnkID from tbl_members M,tbl_posts P where M.pmkID=P.fnkID order by P.fldDate desc';
    $info2 = $thisDatabaseReader->select($query, "", 1, 1, 0, 0, false, false);
    foreach ($info2 as $rec) {
//print'<p>'.$info2[0][6].'</p>';
//print_r ($info2);

        $recd = 2;
        print'<tr><td>';
        print '<header>';
        print '<h2>' . $rec[3] . '</h2>';
        print '<p>posted by: ' . $rec[0] . ' ' . $rec[1] . '</p>';
        print 'Date created: ' . $rec[5];
        print '</header>';
        print'<p><br>' . $rec[4] . '</p>';
        print'</header>';
        //print'<button onclick="'.loadXMLDoc().'">Like</button>';
        echo "<input type = 'button' onclick = 'loadXMLDoc($rec[6])' value = 'Like'>";

        //$fnkPostID = $rec[6];

        print'</td></tr>';
    }

// all done
    print '</table>';
    print '</article>';

    include "footer.php";
    ?>
</body>
</html>