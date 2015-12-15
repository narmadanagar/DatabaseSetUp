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



    print'<article>';

    print '<h1>Most Popular Posts</h1>';

    print '<table>';
    //now print out each record
    $query = 'select M.fldFirstName,M.fldLastName,P.fldDesc,P.fldTitle,P.fldContent,P.fldDate,P.fnkID from tbl_members M,tbl_posts P, tbl_likes L where M.pmkID=P.fnkID and L.fnkPostID = P.fnkID order by L.fldLikes desc';
    //$info2 = $thisDatabaseReader->testquery($query, "", 1, 2, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 2, 0, 0, false, false);
    $columns = 7;
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
        

        print'</td></tr>';
    }
    print '</table>';
    print '</article>';

    include "footer.php";
?>
</body>
</html>