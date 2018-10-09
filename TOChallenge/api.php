<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bolt htaccess tester.</title>
    <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body id="home">
<?php
include_once 'ObjectAthlete.php';
include_once 'ObjectAttempt.php';
include_once 'ObjectChallenge.php';

#htaccess tester, version 1.0

/*
echo "<h1>Bolt Apache <tt>.htaccess</tt> tester.</h1>";

echo $_SERVER['REQUEST_URI'];
echo '<br/>';
echo $_GET['request'];
echo '<br/>';
*/


if (strpos($_SERVER['REQUEST_URI'], 'api.php') === false) {

    // echo "<p><tt>mod_rewrite</tt> is working! You used the path <tt>" . $_SERVER['REQUEST_URI'] . "</tt> to request this page.</p>";
    $pieces = explode("/", $_GET['request']);
    
    /*
    $test = array("challenge", "all", "get");
    echo  $test."<br>";
    echo  count($test)."<br>";
    echo TestRoute($pieces, $test)."<br>";
   */
    
    if (TestRoute($pieces, array("challenge", "current", "get"))) {
        echo Challenge::GetCurrentAsJson();
    } elseif (TestRoute($pieces, array("challenge", "all", "get"))) {
        echo Challenge::GetAllAsJson();
    } elseif (TestRoute($pieces, array("athlete", "all", "get"))) {
        echo Athlete::GetAllAsJson();
    } else{
        echo count($pieces).'<br/>';
        foreach ($pieces as $piece) {
            echo $piece.'<br/>';
        }
    }
} elseif (is_readable(__DIR__.'/.htaccess') ) {

    echo "<p>The file .htaccess exists and is readable to the webserver. These are its contents: </p>\n<textarea style='width: 700px; height: 200px;'>";
    echo file_get_contents(__DIR__.'/.htaccess');
    echo "</textarea>";

} else {

    echo "<p><strong>Error:</strong> The file .htaccess does not exist or it is not readable to the webserver. <br><br>Retieve a new version of the file here, and place it in your webroot. Make sure it is readable to the webserver.</p>";
    die();

}

function TestRoute(array $pieces, array $test)
{
    if (count($pieces) == count($test)) {
        $last = count($pieces) - 1;
        for ($x = 0; $x <= $last; $x++) {
            if ($x == $last)  {
                return True;
            } elseif ($pieces[$x] !== $test[$x]) {
                return False;
            }
        }
    } else {
        return False;
    }
    
    return True;
    
}
?>
</body>
</html>

