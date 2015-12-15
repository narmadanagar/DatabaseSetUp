<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="select.php">Home</a></li>';
        }
       
        if ($path_parts['filename'] == "friday") {
            print '<li class="activePage">Friday</li>';
        } else {
            print '<li><a href="friday.php">Friday</a></li>';
        }
        
        
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

