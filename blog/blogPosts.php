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
    $query = 'select * from tbl_posts';
    $info2 = $thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $columns = 5;
    print '<p><br>Total Records: '. count($info2). '</p>';
    print '<p>SQL: '. $query. '</p>';
    $highlight = 0; // used to highlight alternate rows
    //print '<h1> Four Year Plan </h1>';
    print '<h1>Blog members</h1>';
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