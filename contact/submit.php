<?php
/* Set e-mail recipient */
$myemail  = "info@thepeproject.com";
$subject = "Website Enquiry";

/* Check all form inputs using check_input function */
$yourname = check_input($_POST['name']);
/*$contact  = check_input($_POST['number']);*/
/*$guests  = check_input($_POST['guests']); */
/*$date  = check_input($_POST['date']); */
$email    = check_input($_POST['email']);
/*$time   = check_input($_POST['time']); */
$comments = check_input($_POST['message']);

/* If e-mail is not valid show error message */
/*if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("E-mail address not valid");
}*/

/* If URL is not valid set $website to empty
if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i", $website))
{
    $website = '';
}*/

/* Let's prepare the message for the e-mail */
$message = "Hello...

Your website contact form has been completed and submitted by:

Name: $yourname
Email: $email

Message:
$comments

End of message
";

/* headers */
$from = "info@thepeproject.com";
$headers = "From:" . $from."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
/*$headers .= "Content-Type: text/html; charset=UTF-8\r\n"; */

/* Send the message using mail() function */
mail($myemail, $subject, $message, $headers);

/* Redirect visitor to the thank you page */
header('Location: thanks.html');
exit();

/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
<?php
exit();
}
?>
