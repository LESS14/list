<?php
$correct_password = 'I6m,61\@I\z+%vi:w5FfY';
$allowed_ips = array(
    '127.0.0.1',
    '::1',
);
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$message = '';
if (in_array($visitor_ip, $allowed_ips)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])) {
        $entered_password = $_POST["password"];
        if ($entered_password === $correct_password) {
            $ip = $_POST["ip"];
            $port = $_POST["port"];
            if (filter_var($ip, FILTER_VALIDATE_IP) && is_numeric($port)) {
                $file = fopen("list", "a");
                fwrite($file, "$ip:$port\n");
                fclose($file);

                $message = "IP successfully added!";
            } else {
                $message = "Invalid IP/Port. Check if the IP/Port fields are correct.";
            }
        } else {
            $message = "Invalid password.";
        }
    }
} else {
    $message = "<BODY style='background:#fff;'><H1 style='color:#000;'>Forbidden</H1> <H2 style='color:#000;'>Your IP has been logged: " . $visitor_ip . "</H2></BODY>";
}
?>









<!DOCTYPE html>
<html>

<head>
    <title>Add IP to masterlist</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php if (!empty($message)): ?>
        <p>
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <?php if (in_array($visitor_ip, $allowed_ips)): ?>
        <div class="menu" id="cssmenu">
            <ul class="menulist">
                <li class="active menuitem">
                    <a href="/">Home</a>
                </li>
                <li class="menuitem">
                    <a href="/download">Download SA-MP</a>
                </li>
            </ul>
        </div>
        <div class="form-add" id="container">
        <h1>Add IP and port</h1>
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <ul class="labels">
                    <label for="password">Password:</label>
                    <br />
                    <li class="labelinput">
                        <input type="password" id="password" name="password" required><br>
                    </li>

                    <label for="ip">IP:</label>
                    <br />
                    <li class="labelinput">
                        <input type="text" id="ip" name="ip" required><br>
                    </li>

                    <label for="port">Port:</label>
                    <br />
                    <li class="labelinput">
                        <input type="text" id="port" name="port" required><br>
                    </li>
                    <br />
                    <input class="submitbutton" type="submit" value="Add">
            </form>
            <footer id="footer">
            <p>We're not affiliated with SA-MP.</p>
    </footer>
            </div>
    <?php endif; ?>
</body>

</html>