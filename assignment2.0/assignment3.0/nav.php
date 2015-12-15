<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="join.php">Home</a></li>';
        }
       
        if ($path_parts['filename'] == "Query #1 ") {
            print '<li class="activePage">Query #1</li>';
        } else {
            print '<li><a href="q01.php">Query #1</a></li>';
        }
        
        if ($path_parts['filename'] == "Query #2 ") {
            print '<li class="activePage">Query #2</li>';
        } else {
            print '<li><a href="q02.php">Query #2</a></li>';
        }
        if ($path_parts['filename'] == "Query #3 ") {
            print '<li class="activePage">Query #3</li>';
        } else {
            print '<li><a href="q03.php">Query #3</a></li>';
        }
        if ($path_parts['filename'] == "Query #4 ") {
            print '<li class="activePage">Query #4</li>';
        } else {
            print '<li><a href="q04.php">Query #4</a></li>';
        }
        if ($path_parts['filename'] == "Query #5 ") {
            print '<li class="activePage">Query #5</li>';
        } else {
            print '<li><a href="q05.php">Query #5</a></li>';
        }
        if ($path_parts['filename'] == "Query #6 ") {
            print '<li class="activePage">Query #6</li>';
        } else {
            print '<li><a href="q06.php">Query #6</a></li>';
        }
        if ($path_parts['filename'] == "Query #7 ") {
            print '<li class="activePage">Query #7</li>';
        } else {
            print '<li><a href="q07.php">Query #7</a></li>';
        }
        if ($path_parts['filename'] == "Query #8 ") {
            print '<li class="activePage">Query #8</li>';
        } else {
            print '<li><a href="q08.php">Query #8</a></li>';
        }
//        if ($path_parts['filename'] == "Query #9 ") {
//            print '<li class="activePage">Query #9</li>';
//        } else {
//            print '<li><a href="q09.php">Query #9</a></li>';
//        }
//        if ($path_parts['filename'] == "Query #10 ") {
//            print '<li class="activePage">Query #10</li>';
//        } else {
//            print '<li><a href="q10.php">Query #10</a></li>';
//        }
//        if ($path_parts['filename'] == "Query #11 ") {
//            print '<li class="activePage">Query #11</li>';
//        } else {
//            print '<li><a href="q11.php">Query #11</a></li>';
//        }
//        if ($path_parts['filename'] == "Query #12 ") {
//            print '<li class="activePage">Query #12</li>';
//        } else {
//            print '<li><a href="q12.php">Query #12</a></li>';
//        }
//        
         
        
//        if ($path_parts['filename'] == "populate-table.php") {
//            print '<li class="activePage">Populate Tables</li>';
//        } else {
//            print '<li><a href="populate-table.php">Populate Tables</a></li>';
//        }
//        
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

