<?php

//##############################################################################
//
// This page lists your tables and fields within your database. if you click on
// a database name it will show you all the records for that table. 
// 
// 
// This file is only for class purposes and should never be publicly live
//##############################################################################
include "top.php";



print '<table>';
//now print out each record
$query = 'select F.pmkPlanId, F.fldDateCreated, F.fldCatalogYear, s.pmkNetID, a.pmkNetID,
              spc.fnkYear, spc.fnkTerm, c.fldDepartment, c.fldCourseNumber, c.fldCourseName, c.fldCredits

              From tblAdvisors a, tblStudents s, tblFourYearPlan F, tblSemPlan sp, tblSemPlanCourses spc, tblCourses c

              where F.pmkPlanId = sp.fnkPlanID and spc.fnkPlanID = F.pmkPlanId 
              and spc.fnkYear = sp.pmkYear 
              and spc.fnkTerm = sp.pmkTerm
              and c.pmkCourseID = spc.fnkCourseID
              and F.pmkPlanID = 1
              and s.pmkNetID = "nsingh4"

              Order by sp.fldDisplayOrder, c.fldCourseName';
//$info2 = $thisDatabaseReader->testquery($query, "", 1, 7, 2, 0, false, false);
$info2 = $thisDatabaseReader->select($query, "", 1, 7, 2, 0, false, false);
$columns = 11;
print '<p><br>Total Records: ' . count($info2) . '</p>';
print '<p>SQL: ' . $query . '</p>';
$highlight = 0; // used to highlight alternate rows

print '<h1>Four Year Plan</h1>';
print '<tr>
    		<th>PlanID</th>
   		<th>Date Created</th> 
    		<th>Catalog Year</th>
		<th>Student NetId</th>
		<th>Advisor NetId</th>
		<th>Year</th>
		<th>Term</th>
		<th>Department</th>
		<th>Course Number</th>
		<th>Course Name</th>
		<th>Credits</th>

          </tr>';

foreach ($info2 as $rec) {
    $highlight++;
    if ($highlight % 2 != 0) {
        $style = ' odd ';
    } else {
        $style = ' even ';
    }
    print '<tr class="' . $style . '">';
    for ($i = 0; $i < $columns; $i++) {
        print '<td>' . $rec[$i] . '</td>';
    }
    print '</tr>';
}

// all done
print '</table>';
print '</aside>';

print '</article>';
include "footer.php";
?>