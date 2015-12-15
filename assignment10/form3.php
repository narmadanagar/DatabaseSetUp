<?php
/* the purpose of this page is to display a form to allow a poet and allow us
 * to add a new poet or update an existing poet 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu

 */

include "top.php";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
$update = false;

// SECTION: 1a.
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>"; //
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form

if (isset($_GET["id"])) {
    $pmkID = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");
    $fnkID = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");
    $fnkPostID = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");

    $query = 'SELECT fldFirstName,fldLastName, fldEmail ';
    $query .= 'FROM tbl_members WHERE pmkID = ?';
    $query2 = 'SELECT fldTitle,fldDesc,fldContent ';
    $query2 .= 'FROM tbl_posts WHERE fnkID = ?';
    $query3 = 'SELECT fldLikes';
    $query3 .= 'FROM tbl_likes WHERE fnkPostID = ?';

    $results = $thisDatabase->select($query, "", 1, 0, 0, 0, false, false);
    $results2 = $thisDatabase->select($query2, "", 1, 0, 0, 0, false, false);
    $results3 = $thisDatabase->select($query3, "", 1, 0, 0, 0, false, false);

    $firstName = $results[0]["fldFirstName"];
    $lastName = $results[0]["fldLastName"];
    $email = $results[0]["fldEmail"];
    $title = $results2[0]["fldTitle"];
    $desc = $results2[0]["fldDesc"];
    $content = $results2[0]["fldContent"];

    $speaker1 = false; //checkbox
    $speaker2 = false;
    $speaker3 = false;
    $speaker4 = false;
    $speaker5 = false;
    $speaker6 = false;

    $desc = "Faith"; //radio buttons

    $happiest = ""; //listbox pick the option
} else {
    $pmkID = -1;
    $firstName = "";
    $lastName = "";
    $email = "";
    $fnkID = -1;
    $fnkPostID = -1;
    $title = "";
    $desc = "";
    $content = "";
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$titleERROR = false;
$descERROR = false;
$contentERROR = false;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
$data = array();
$dataEntered = false;
$mailed = false; //have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    if (!securityCheck($path_parts, $yourURL, true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
    $pmkID = (int) htmlentities($_POST["hidID"], ENT_QUOTES, "UTF-8");
    $fnkID = (int) htmlentities($_POST["hidID"], ENT_QUOTES, "UTF-8");

    if ($pmkID > 0) {
        $update = true;
    }

    // I am not putting the ID in the $data array at this time

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $data[] = $firstName;

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $data[] = $lastName;

    $email = htmlentities($_POST["txtEmail"], ENT_QUOTES, "UTF-8");
    $data[] = $email;

    $title = htmlentities($_POST["txtTitle"], ENT_QUOTES, "UTF-8");
    $data[] = $title;

    $desc = htmlentities($_POST["radDesc"], ENT_QUOTES, "UTF-8");
    $data[] = $desc;

    $content = htmlentities($_POST["txtContent"], ENT_QUOTES, "UTF-8");
    $data[] = $content;

    $happiest = htmlentities($_POST["lstHappiest "], ENT_QUOTES, "UTF-8");
    $data[] = $happiest;

    if (isset($_POST["chkSpeaker1"])) {
        $speaker1 = true;
        $dataRecord[] = "Courage";
    }


    if (isset($_POST["chkSpeaker2"])) {
        $speaker2 = true;
        $dataRecord[] = "Motivation";
    }

    if (isset($_POST["chkSpeaker3"])) {
        $speaker3 = true;
        $dataRecord[] = "Self Confidence";
    }

    if (isset($_POST["chkSpeaker4"])) {
        $speaker4 = true;
        $dataRecord[] = "Kindness";
    }

    if (isset($_POST["chkSpeaker5"])) {
        $speaker5 = true;
        $dataRecord[] = "Faith";
    }

    if (isset($_POST["chkSpeaker6"])) {
        $speaker6 = true;
        $dataRecord[] = "Other";
    }




//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//

    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra character.";
        $lastNameERROR = true;
    }

    if ($email == "") {
        $errorMsg[] = "Please enter your email";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email appears to have extra character.";
        $emailERROR = true;
    }

    if ($title == "") {
        $errorMsg[] = "Please enter the title";
        $titleERROR = true;
    } elseif (!verifyAlphaNum($title)) {
        $errorMsg[] = "Title appears to have extra character.";
        $titleERROR = true;
    }

    if ($content == "") {
        $errorMsg[] = "Please enter Content";
        $contentERROR = true;
    } elseif (!verifyAlphaNum($content)) {
        $errorMsg[] = "The content appears to have extra character.";
        $contentERROR = true;
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid</p>";
        }


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2e Save Data
//

        $dataEntered = false;
        try {
            $thisDatabaseWriter->db->beginTransaction();

            $query = 'INSERT INTO tbl_members (fldFirstName, fldLastName, fldEmail) VALUES ("'
                    . $firstName . '","' . $lastName . '","' . $email . '") ';

            $data = array($firstName, $lastName, $email);

            $thisDatabaseWriter->insert($query, "", 0, 0, 6, 0, false, false);
            //$primaryKey = $thisDatabaseWriter->lastInsert();

            $query2 = 'INSERT INTO tbl_posts (fldTitle, fldDesc, fldContent) VALUES ("'
                    . $title . '","' . $desc . '","' . $content . '") ';

            $data2 = array($title, $desc, $content);

            $thisDatabaseWriter->insert($query2, "", 0, 0, 6, 0, false, false);
            //$primaryKey = $thisDatabaseWriter->lastInsert();

            $query3 = 'INSERT INTO tbl_likes (fldLikes) VALUES (0) ';

            $data3 = array($title, $desc, $content);

            $thisDatabaseWriter->insert($query3, "", 0, 0, 0, 0, false, false);


            $dataEntered = $thisDatabaseWriter->db->commit();
        } catch (PDOExecption $e) {
            $thisDatabaseWriter->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accepting your data please contact us directly.";
        }


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2f Create message
//
// build a message to display on the screen in section 3a and to mail
// to the person filling out the form (section 2g).
        $message = '<h2>Thanks for your time!</h2>';
        foreach ($_POST as $key => $value) {
            if ($key != "btnSubmit") {
                $message .= "<p>";
                $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
        }
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2g Mail to user
//
// Process for mailing a message which contains the forms data
// the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Nidhi Singh <noreply@yoursite.com>";
// subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Motivational Blog: " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if ($dataEntered) { // closing of if marked with: end body submit
        print "<h1>Record Saved</h1> ";
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print '<h1>Your form has the following mistakes</h1>';

            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
            <fieldset class="wrapper">
                <h1>Post anything you like</h1><br><br>


                <input type="hidden" id="hidID" name="hidID"
                       value="<?php print $pmkID; ?>"
                       >
                <fieldset class="wrapperTwo">
                    <fieldset class="contact">

                        <label for="txtFirstName" class="required">FirstName
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $firstName; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter first name"
                                   <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>

                        <label for="txtLastName" class="required">LastName
                            <input type="text" id="txtLastName" name="txtLastName"
                                   value="<?php print $lastName; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter last name"
                                   <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label> 

                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter your email"
                                   <?php if ($emailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label> 
                    </fieldset> <!-- ends contact -->
                    <fieldset class="post">

                        <label for="txtTitle" class="required">Title
                            <input type="text" id="txtTitle" name="txtTitle"
                                   value="<?php print $title; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter the title"
                                   <?php if ($titleERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        <fieldset class="radio">
                            <legend>Please select the description</legend>

                            <label><input type="radio" 
                                          id="radDesc1" 
                                          name="radDescription" 
                                          value="Faith"
                                          <?php if ($desc == "Faith") print 'checked' ?>
                                          tabindex="330">Faith</label><br>
                            <label><input type="radio" 
                                          id="radDesc2" 
                                          name="radDescription" 
                                          value="Happiness"
                                          <?php if ($desc == "Happiness") print 'checked' ?>
                                          tabindex="380">Happiness</label><br>
                            <label><input type="radio" 
                                          id="radDesc3" 
                                          name="radDescription" 
                                          value="Courage"
                                          <?php if ($desc == "Courage") print 'checked' ?>
                                          tabindex="350">Courage</label><br>
                            <label><input type="radio" 
                                          id="radDesc4" 
                                          name="radDescription" 
                                          value="Kindness"
                                          <?php if ($desc == "Kindness") print 'checked' ?>
                                          tabindex="350">Kindness</label><br>
                            <label><input type="radio" 
                                          id="radDesc5" 
                                          name="radDescription" 
                                          value="Forgiveness"
                                          <?php if ($desc == "Forgiveness") print 'checked' ?>
                                          tabindex="390">Forgiveness</label><br>
                            <label><input type="radio" 
                                          id="radDesc6" 
                                          name="radDescription" 
                                          value="None"
                                          <?php if ($desc == "None") print 'checked' ?>
                                          tabindex="330">None</label><br>
                        </fieldset>


                        <label for="txtContent" class="required">Content
                            <input type="text" id="txtContent" name="txtContent"
                                   value="<?php print $content; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter the content"
                                   <?php if ($contentERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>

                    </fieldset>
                    <fieldset class="checkbox">
                        <legend>Who is your inspiration?</legend>
                        <label><input type="checkbox" 
                                      id="chkSpeaker1" 
                                      name="chkSpeaker:1" 
                                      value="Martin Luther King Jr."
                                      <?php if ($speaker1) print ' checked '; ?>
                                      tabindex="420">Martin Luther King Jr.</label><br>

                        <label><input type="checkbox" 
                                      id="chkSpeaker2" 
                                      name="chkSpeaker:2" 
                                      value="Mahatma Gandhi"
                                      <?php if ($speaker2) print ' checked '; ?>
                                      tabindex="420">Mahatma Gandhi</label><br>

                        <label><input type="checkbox" 
                                      id="chkSpeaker3" 
                                      name="chkSpeaker:3" 
                                      value="Steve Jobs"
                                      <?php if ($speaker3) print ' checked '; ?>
                                      tabindex="420">Steve Jobs</label><br>

                        <label><input type="checkbox" 
                                      id="chkSpeaker4" 
                                      name="chkSpeaker:4" 
                                      value="Albert Einstein"
                                      <?php if ($speaker4) print ' checked '; ?>
                                      tabindex="420">Albert Einstein</label><br>

                        <label><input type="checkbox" 
                                      id="chkSpeaker5" 
                                      name="chkSpeaker:5" 
                                      value="Abraham Lincoln"
                                      <?php if ($speaker5) print ' checked '; ?>
                                      tabindex="420">Abraham Lincoln</label><br>

                        <label><input type="checkbox" 
                                      id="chkSpeaker6" 
                                      name="chkSpeaker:6" 
                                      value="Barack Obama"
                                      <?php if ($speaker6) print ' checked '; ?>
                                      tabindex="420">Barack Obama</label><br>

                    </fieldset>
                    <fieldset  class="listbox">	
                        <label for="lstHappiest">Which country do you think is the happiest?</label>
                        <select id="lstHappiest" 
                                name="lstHappiestCountry" 
                                tabindex="520" >
                            <option <?php if ($country == "Denmark") print " selected "; ?>
                                value="Denmark">Denmark</option>

                            <option <?php if ($country == "United States") print " selected "; ?>
                                value="United States">United States</option>

                            <option <?php if ($country == "United Kingdom") print " selected "; ?>
                                value="United Kingdom" >United Kingdom</option>

                            <option <?php if ($country == "Switzerland") print " selected "; ?>
                                value="Switzerland" >Switzerland</option>

                            <option <?php if ($country == "Canada") print " selected "; ?>
                                value="Canada" >Canada</option>

                            <option <?php if ($country == "Bhutan") print " selected "; ?>
                                value="Bhutan" >Bhutan</option>


                        </select>
                    </fieldset>


                </fieldset> <!-- ends contact -->
            </fieldset> <!-- ends wrapper Two -->
            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Save" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->
        </form>
        <?php
    } // end body submit
    ?>
</article>

<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>
</body>
</html>