<?php
include "top.php";
include "lib";


/* this example creates a list box from our database.
 * Four step process

  Create your database object using the appropriate database username
  Define your query. In this example we open the file that contains the query.
  Execute the query
  Prepare output and loop through array

 */
//initialize value
$building = "Nidhi";

// Step one: generally code is in top.php
require_once('../bin/Database.php');

$dbUserName = get_current_user() . '_reader';
$whichPass = "r"; //flag for which one to use.
$dbName = strtoupper(get_current_user()) . '_advising';

$thisDatabase = new Database($dbUserName, $whichPass, $dbName);

// Step Two: code can be in initialize variables or where step four needs to be
$query  = "SELECT DISTINCT fldFirstName ";
$query .= "FROM tblStudents ";
$query .= "ORDER BY fldFirstName ";


// Step Three: code can be in initialize variables or where step four needs to be
// $buildings is an associative array
$buildings = $thisDatabase->select($query, "", 0, 1, 0, 0, false, false);

// Step Four: prepare output two methods, only do one of them
/* html looks like this if we were to do this manually (shortened to three 
  buildings

  <label for="lstBuildings">Building
  <select id="lstBuildings"
  name="lstBuildings"
  tabindex="300" >

  <option value="Shawn">Shawn</option>
  <option value="Benjamin">Benjamin</option>
  <option value="Nidhi" selected>Nidhi</option>

  </select></label>


  Here is how to code it */

// coded to store output in a variable, this example i use an array
// in the form i build a message to be mailed so the variable is
// $message, in both cases output is stored before printing
/* same thing just not in an array

  $message  = '<label for="lstBuildings">Building"';
  $message .= '<select id="lstBuildings" ';
  $message .= '        name="lstBuildings"';
  $message .= '        tabindex="300" >';

 */
print "<h2>List box built from Database</h2>";
// or you can print it out
print '<label for="lstBuildings">Building ';
print '<select id="lstBuildings" ';
print '        name="lstBuildings"';
print '        style="width: 200px;"';
print '        tabindex="300" >';


foreach ($buildings as $row) {

    print '<option ';
    if ($building == $row["fldFirstName"])
        print " selected='selected' ";

    print 'value="' . $row["fldFirstName"] . '">' . $row["fldFirstName"];

    print '</option>';
}

print '</select></label>';

print '</form>';