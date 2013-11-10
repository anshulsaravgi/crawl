 <?php
    $urls = array("dbms-project\lawand-order\index.html");
    $parsed = array();
set_time_limit(0);
    $sitesvisited = 0;

    mysql_connect("localhost", "root", "");
    mysql_select_db("phpdb");

    mysql_query("DROP TABLE simplesearch;");
    mysql_query("CREATE TABLE simplesearch (URL CHAR(255), Contents TEXT);");
    mysql_query("ALTER TABLE simplesearch ADD FULLTEXT(Contents);");

    function parse_site() {
        GLOBAL $urls, $parsed, $sitesvisited;

        $newsite = array_shift($urls);

        echo "\n Now parsing $newsite...\n<br>";

        // the @ is because not all URLs are valid, and we don't want
        // lots of errors being printed out
        $ourtext = @file_get_contents($newsite);
        if (!$ourtext) return;

        $newsite = addslashes($newsite);
        $ourtext = addslashes($ourtext);

        mysql_query("INSERT INTO simplesearch VALUES ('$newsite', '$ourtext');");

        // this site has been successfully indexed; increment the counter
        ++$sitesvisited;

       // echo $ourtext;
		// this extracts all hyperlinks in the document
        preg_match_all("/http:\/\/[A-Z0-9_\-\.\/\?\#\=\&]*/i", $ourtext, $matches);
		//preg_match_all("/location:[A-Z0-9_\-\.\/\?\#\=\&]*/i", $ourtext, $matches);
		//preg_match_all("/href[A-Z0-9_\-\.\/\?\#\=\&]*/i", $ourtext, $matches);
		//preg_match_all("/action=\"[A-Z0-9_\-\.\/\?\#\=\&]*/i", $ourtext, $matches);

        if (count($matches)) {
            $matches = $matches[0];
            $nummatches = count($matches);

            echo "Got $nummatches from $newsite\n";
			
            foreach($matches as $match) {
				$match=str_replace("http://", "dbms-project\\lawand-order\\", $match);
				$match=str_replace("location:", "dbms-project\\lawand-order\\", $match);
				ECHO "CHECKING $match"."<br>";
                // we want to ignore all these strings
               
					if (stripos($match, "http://") !== false) continue;

                // yes, these next two are very vague, but they do cut out
                // the vast majority of advertising links.  Like I said,
                // this indexer is far from perfect!
               
				//echo $match;
                // this URL looks safe
                if (!in_array($match, $parsed)) 
				{ // we haven't already parsed this URL...
				//echo "check 1";
                    if (!in_array($match, $urls)) 
					{ // we don't already plan to parse this URL...
                  //     echo "check 2";
					   array_push($urls, $match);
                        echo "Adding $match...\n<br>";
                    }
                }
				$m=addslashes($match);
				echo $m;
            mysql_query("INSERT INTO sitegraph VALUES ('$newsite', '$m','1');");
        
			}
			} 
		else {
            echo "Got no matches from $newsite\n";
        }

        // add this site to the list we've visited already
        $parsed[] = $newsite;
    }

    while ($sitesvisited < 5000 && count($urls) != 0) {
        parse_site();

        // this stops us from overloading web servers
        sleep(5);
    }
?> 