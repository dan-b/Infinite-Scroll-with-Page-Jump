<?php

/************************ Function calls and declarations ************************/
$articlesPerPage = 10;
checkArgs();

/***********************************************************/



function checkArgs() {
	if (isset($_GET['rel']) &&  isset($_GET['page'])) {
		$page = $_GET['page'];
		if (preg_match("#^\d+$#", $page)) {
			displayArticles($page);
		}
	} else if (isset($_GET['page']) && !isset($_GET['rel'])) {
//		print "<p>Not an AJAX request</p>";
	}
}

function getArticles($page) {
	--$page;
	if ($page<0) {
		$page = 0;
	}
	$offset = $page * $GLOBALS['articlesPerPage'];
	$where = "WHERE `entryID` <= (SELECT `entryID` FROM `demo_infinite_scroll_with_page_jump_view`LIMIT $offset, 1)";
	$query = "SELECT `entryID`, `date`, `title`, `body` FROM `demo_infinite_scroll_with_page_jump_view` $where LIMIT 0 , " . $GLOBALS['articlesPerPage'];
	$mysqliObj = makeMysqliObj("rubbishb_db1");
	$result = runMyslqliQuery($mysqliObj, $query);
	return $result;
}

function displayArticles($page) {
	$res = getArticles($page);
	$htmlString = "<div class='page $page'>
	<span class='pageLabel'>page $page</span>";
	$entryNum = ($page-1)*$GLOBALS['articlesPerPage'];
	while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
		$entryID = $row["entryID"];
		++$entryNum;
		$date = new DateTime($row["date"]);
		$date = $date->format('j M Y @ g:i a');
		$title = $row["title"];
		$body = $row["body"];
		$htmlString .= "<div class='article'>
		<div class='id'>#$entryID</div>
		<div class='date'>$date</div>
		<div class='title'>$title</div>
		<div class='body'>$body</div>
	</div>";
	}
	$htmlString .= "</div>";
	print $htmlString;
}

function countArticles() {
	$query = "SELECT count(`entryID`) as article_count FROM `demo_infinite_scroll_with_page_jump_view`";
	$mysqliObj = makeMysqliObj("db_name");
	$result = runMyslqliQuery($mysqliObj, $query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	return (int) $row["article_count"];
}

/************************Database functions************************/

function makeMysqliObj($dbName) {
	$mObj = new mysqli('localhost', 'user', 'pass', $dbName);
	return $mObj;
}

/*	Return TRUE on successful INSERT, UPDATE, DELETE, DROP
	Return mysqli_result object on successful SELECT, SHOW, DESCRIBE, EXPLAIN
	Return FALSE on query error
*/
function runMyslqliQuery($mObj, $query) {
	if ($mObj->connect_errno) {
		print "<p>Database connection error: " . $mObj->connect_errno . " " . $mObj->connect_error . "</p>";
	} else {
		$res = $mObj->query($query);
		if ($res===false) {
			print "<p>Query error: " . $mObj->error . "</p>";
		} else if ($res===true) {
			print "<p>Query success</p>";
		} else {
			return $res;
		}
	}
}

?>