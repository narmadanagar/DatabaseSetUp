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

    $query = 'SELECT fldDesc,fldTitle,fldContent ';
    $query .= 'FROM tbl_posts WHERE pmkID = ?';
    //$results = $thisDatabase->testquery($query, array(fldUsername), 1, 0, 0, 0, false, false);
    $results = $thisDatabase->select($query, "", 1, 0, 0, 0, false, false);

    $desc = $results[0]["fldUsername"];
    $title = $results[0]["fldEmail"];
    $content = $results[0]["fldPassword"];
} else {
    $pmkID = -1;
    $desc = "";
    $title = "";
    $content = "";
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$descERROR = false;
$titleERROR = false;
$contentERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
$data = array();
$dataEntered = false;

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
    if ($pmkID > 0) {
        $update = true;
    }
    // I am not putting the ID in the $data array at this time

    $title = htmlentities($_POST["txtTitle"], ENT_QUOTES, "UTF-8");
    $data[] = $title;

    $desc = htmlentities($_POST["txtDesc"], ENT_QUOTES, "UTF-8");
    $data[] = $desc;

    $content = htmlentities($_POST["txtContent"], ENT_QUOTES, "UTF-8");
    $data[] = $content;


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//

    if ($title == "") {
        $errorMsg[] = "Please enter the title";
        $titleERROR = true;
    } elseif (!verifyAlphaNum($title)) {
        $errorMsg[] = "Title appears to have extra character.";
        $titleERROR = true;
    }

    if ($desc == "") {
        $errorMsg[] = "Please enter the description";
        $descERROR = true;
    } elseif (!verifyAlphaNum($desc)) {
        $errorMsg[] = "The description appears to have extra character.";
        $descERROR = true;
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

            $query = 'INSERT INTO tbl_posts (fldTitle, fldDesc, fldContent) VALUES ("'
                    . $title . '","' . $desc . '","' . $content . '") ';

            $data = array($title, $desc, $content);

            $thisDatabaseWriter->insert($query, "", 0, 0, 6, 0, false, false);
            $primaryKey = $thisDatabaseWriter->lastInsert();

            $dataEntered = $thisDatabaseWriter->db->commit();
        } catch (PDOExecption $e) {
            $thisDatabaseWriter->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
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
                <legend>Members</legend>

                <input type="hidden" id="hidID" name="hidID"
                       value="<?php print $pmkID; ?>"
                       >

                <label for="txtTitle" class="required">Title
                    <input type="text" id="txtTitle" name="txtTitle"
                           value="<?php print $title; ?>"
                           tabindex="100" maxlength="45" placeholder="Enter the title"
                           <?php if ($titleERROR) print 'class="mistake"'; ?>
                           onfocus="this.select()"
                           autofocus>
                </label>

                <label for="txtDesc" class="required">Description
                    <input type="text" id="txtDesc" name="txtDesc"
                           value="<?php print $desc; ?>"
                           tabindex="100" maxlength="45" placeholder="Enter the description"
                           <?php if ($descERROR) print 'class="mistake"'; ?>
                           onfocus="this.select()"
                           >
                </label> 

                <label for="txtContent" class="required">Content
                    <input type="text" id="txtContent" name="txtContent"
                           value="<?php print $content; ?>"
                           tabindex="100" maxlength="45" placeholder="Enter the content"
                           <?php if ($contentERROR) print 'class="mistake"'; ?>
                           onfocus="this.select()"
                           >
                </label> 
            </fieldset> <!-- ends contact -->
            </fieldset> <!-- ends wrapper Two -->
            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Save" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->
            </fieldset> <!-- Ends Wrapper -->
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