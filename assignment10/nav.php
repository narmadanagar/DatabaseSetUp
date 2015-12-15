<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ul>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="index.php">Home</a></li>';
        }
        if ($path_parts['filename'] == "quotes") {
            print '<li class="activePage">Quotes</li>';
        } else {
            print '<li><a href="quotes.php">Quotes</a></li>';
        }

        

        if ($path_parts['filename'] == "posts") {
            print '<li class="activePage">Posts</li>';
        } else {
            print '<li><a href="posts.php">Posts</a></li>';
        }

        if ($path_parts['filename'] == "best") {
            print '<li class="activePage">Most liked Posts</li>';
        } else {
            print '<li><a href="best.php">Most liked Posts</a></li>';
        }

        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Form</li>';
        } else {
            print '<li><a href="form3.php">Form</a></li>';
        }

        if ($path_parts['filename'] == "aboutMe") {
            print '<li class="activePage">AboutMe</li>';
        } else {
            print '<li><a href="aboutMe.php">AboutMe</a></li>';
        }
        
        ?>
    </ul>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

