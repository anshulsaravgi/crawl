<?php
    if (isset($_POST['criteria'])) {
        mysql_connect("localhost", "root", "");
        mysql_select_db("phpdb");

        $criteria = addslashes($_POST['criteria']);

        $result = mysql_query("SELECT URL FROM simplesearch WHERE MATCH(Contents) AGAINST ('$criteria') ORDER BY URL ASC;");

        if (mysql_num_rows($result)) {
            echo "Search found the following matches...<br /><br />";

            echo "<ul>";

            while ($r = mysql_fetch_assoc($result)) {
                extract($r, EXTR_PREFIX_ALL, 'find');
                echo "<li><a href=\"$find_URL\">$find_URL</A></li>";
                
            }

            echo "</ul>";
        } else {
            echo "No matches found for the criteria '$criteria'.<br /><br />";
        }
        
    }
?>

<form method="post">
Search for: <input type="text" name="criteria" />
<input type="submit" value="Go" />
</form>