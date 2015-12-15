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
print_r($_GET);
print($_GET[id]);
$idi = $_GET[id];



print '<table>';
if ($idi != 0) {
//now print out each record
    $query1 = "UPDATE tbl_likes SET fldLikes = (select fldLikes) + 1 WHERE fnkPostID = '" . $idi . "'";
    $info = $thisDatabaseAdmin->testquery($query1, "", 1, 0, 2, 0, false, false);
    $info = $thisDatabaseAdmin->select($query1, "", 1, 0, 2, 0, false, false);
}
print '<p><br>Total Records: ' . count($info) . '</p>';
print '<p>SQL: ' . $query1 . '</p>';

$query = 'select * from tbl_likes';
$info2 = $thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
$info2 = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);

$columns = 2;
print '<p><br>Total Records: ' . count($info2) . '</p>';
print '<p>SQL: ' . $query . '</p>';
print '<h1>Blog likes</h1>';
foreach ($info2 as $rec) {
    print '<tr class="' . $style . '">';
    for ($i = 0; $i < $columns; $i++) {
        print '<td>' . $rec[$i] . '</td>';
    }
    print '</tr>';
}

// all done
print '</table>';
include "footer.php";
?>