<?php

// multiple recipients
error_reporting(0);
//$to = 'raindrip@raindrip.com';
//$to = 'lubiglia@gmail.com';
$from = 'raindrip@raindrip.com';
$//to = 'no-reply@raindrip.com';
$to = 'raindrip@raindrip.com';

// subject
$subject = 'New contact from website';

// message
$message = '
<html>
<head>
  <title> </title>
</head>
<body>
  <p>The following information has been sent from the Raindrip website Contact Form:</p>
  <table>
    <tr>
      <td>First Name:</td><td>' . $_POST['Name'] . '<td>
    </tr>

    <tr>
      <td>Last Name:</td><td>' . $_POST['Lastname'] . '<td>
    </tr>
    <tr>
      <td>Email:</td><td>' . $_POST['Email'] . '<td>
    </tr>
    <tr>
      <td>State:</td><td>' . $_POST['State'] . '<td>
    </tr>

    <tr>
      <td>Gender:</td><td>' . $_POST['Gender'] . '<td>
    </tr>

    <tr>
      <td>How Can we Help?:</td><td>' . $_POST['Help'] . '<td>
    </tr>

    <tr>
      <td>Product:</td><td>' . $_POST['Product'] . '<td>
    </tr>


  </table>
</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: Website Administration <' . $from . '>' . "\r\n";
$headers .= 'To:' . $to . "\r\n";
$headers .= 'Bcc: shaynakrivis@ndspro.com' . "\r\n";
$headers .= 'Bcc: peirano357@gmail.com' . "\r\n";




// Mail it  206.123.118.151
$sent = mail($to, $subject, $message, $headers);

echo $sent;

/*


require '/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'jswan';                            // SMTP username
$mail->Password = 'secret';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'from@example.com';
$mail->FromName = 'Mailer';
$mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    exit;
}

echo 'Message has been sent';
 * */

?>