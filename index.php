<?php
include_once ("getArticles.php");
$articleCount = countArticles();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
		<script type="text/javascript" src="main.js"></script>
		<link rel='stylesheet' href='style-1.css' type='text/css' media='screen' />
		<title>Infinite Scroll with Page Jump 1.0</title>
	</head>

	<body>
		<div id="menuContainer">
			<div id="mainMenu">
				<div class="items">
					<a href="#">new</a>
					<a href="#">browse</a>
					<a href="#" class="selected">articles</a>
					<a href="#">contact</a>
					<a href="#">links</a>
				</div>
			</div>
		</div>

		<div id="content">
			<div id="pageMenu">
				<span class="message">type page number and press ENTER</span>
				<div class="jumpTo">
					<form>
						<input type="text" maxlength="3" value="1"/>

					</form>
					&nbsp;/&nbsp;<span class="totalPageCount"><?php print ceil($articleCount/$GLOBALS['articlesPerPage']); ?></span>
				</div>
			</div>
<?php
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
		displayArticles($page);
	} else {
		displayArticles(1);
	}
?>
		</div>
	</body>



</html>



