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
    $query = 'select distinct S.fldFirstName, S.fldLastName, count(*), E.fldGrade from tblEnrolls E, tblStudents S, tblCourses C

where E.fnkStudentId = S.pmkStudentId and E.fnkCourseId = C.pmkCourseId and S.fldState = "VT" and E.fldGrade > (select avg(fldGrade) from tblEnrolls E, tblStudents S where E.fnkStudentId = S.pmkStudentId and S.fldState = "VT")

group by fldGrade,fldFirstName order by fldGrade desc, fldLastName, fldFirstName';
    $info2 = $thisDatabaseReader->testquery($query, "", 1, 5, 4, 1, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 5, 4, 1, false, false);
    $columns = 4;
    print '<p>Total Records: '. count($info2). '</p>';
    print '<p>SQL: '. $query. '</p>';
    $highlight = 0; // used to highlight alternate rows
    
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