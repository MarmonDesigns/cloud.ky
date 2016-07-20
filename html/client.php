<?php

if(isset($_POST['submit']))
{
// $output_form = false; // Set output_form variable to false by default.
$fileInfo = $_FILES['uploadedfile'];  // Make an array out of the file information.       tore in $fileInfo
$filePath = $fileInfo['tmp_name'];  // Take the file path name and store in $filePath.

$fileName = basename($_FILES['uploadedfile']['name']);  // Get filename from path

// Add a check for file name for spaces or dashes - - -   <---Those things.  Return an error message if spaces/dashes are found.

// Add a check form for valid fields.

$destination_path = "/.$fileName";   // The location where you will upload the file on the server.

// FTP Connection Settings
$ftp_server = "http://magentowork.co.in/realestate/";  // Address of FTP server
$ftp_user_name = trim($_REQUEST['data']);
$ftp_user_pass = trim($_REQUEST['dataman123']);

// Setup Connection
$connect_id = ftp_connect($ftp_server) or die("<h2>Couldn't connect to $ftp_server</h2>"); // Try connection
// Try username and password with connection.  Give die message if failed.
$login_result = ftp_login($connect_id, $ftp_user_name, $ftp_user_pass) or die("<h2>You do not have access to this ftp server!</h2>");
if ((!connect_id) || (!login_result))    // Check Connection
{   
    echo "<h2>FTP Connection has failed! <br />";
    echo "Atttempted to connect to $ftp_server for user $ftp_user_name</h2>";
    exit;
}
else
{   
    echo "Connected to $ftp_server, as $ftp_user_name <br />";
}

// Upload file
$upload = ftp_put($connect_id, $destination_path, $filePath, FTP_BINARY); 
if (!$upload)
{
    echo "<h2>FTP upload of $file_name has failed!</h2><br />";
}
else
{
    echo "<h2>$file_name has been uploaded successfully!</h2><br />";
}

// Close the ftp stream
ftp_close($connect_id);


$con = mysql_connect("localhost","root","");
if (!$con)
{
 die('Could not connect: ' . mysql_error());
}

mysql_select_db("magentow_realdb", $con);

$sql="INSERT INTO usertbl (FirstName, LastName, Email, VideoName, DateTime, CourseCode,   VideoDescription)
VALUES
('$_POST[firstname]','$_POST[lastname]','$_POST[email]','$vidname',    Now(),'$_POST[coursecode]','$_POST[videodescription]')";

if (!mysql_query($sql,$con))
{
die('Error: ' . mysql_error());
}
echo "1 record added";

mysql_close($con);
}   

?>

<html>

<head></head>

<body>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    Firstname: <input type="text" name="firstname" />
    Lastname: <input type="text" name="lastname" /><br><br>
    <center>Email: <input type="text" name="email" /></center><br>
    <center>Course Code: <input type="text" name="coursecode" /></center><br>
    <center>Video Description: <input type="text" name="videodescription" /></center><br>
    Server Username: <input name="username" type="text" id="username" size="15" value=""/><br>
    Server Password: <input name="password" type="text" id="password" size="15" value=""/><br>
    Choose a file to upload: <input name="uploadedfile" type="file" id="uploadedfile" onChange="uploadedfileName.value=uploadedfile.value"/><br /><br>
    <input name="uploadedfileName" type="hidden" id="uploadedfileName" tabindex="99" size="1" />
    <input type="submit" name="submit" value="Upload File" />
    <br>
</form>

</body>