<?php
require_once "../provider.php";
require_once "../settings.php";
require_once "smtp/Mail.php";

class ModelConnectionEmail extends Model
{
    public function sendEmail($from,$to,$subject,$text,$costumer_id,$admin_id)  // Add Admin_ID  ... Costumer_ID
    {

       $host = "ms.codebox.ir";
       $username = '';
       $password =  '';

       $host = "ms.codebox.ir";
       $port = 2225;
       
       $headers = array (
                                 'From' => $from,
                                 'To' => $to,
                                 'Subject' => $subject
                              );
       $smtp = Mail::factory('smtp', array (
                                                       'host' => $host,
                                                       'port' => $port
                                                       )
                                   );
        $mail = $smtp->send($to, $headers, $text);

        if (PEAR::isError($mail)) {
                    echo("<p>" . $mail->getMessage() . "</p>");
        } else {
          $con_PU_db = $GLOBALS['con_PU_db'];
          $sql = "INSERT INTO `pu_email_sent` (
                                                                                `admin_id`,
                                                                                `costumer_id`,
                                                                                `from`,
                                                                                `to`, 
                                                                                `subject`, 
                                                                                `text`
                                                                ) VALUES (
                                                                                '$admin_id', 
                                                                                '$costumer_id', 
                                                                                '$from', 
                                                                                '$to',
                                                                                '$subject',
                                                                                '$text'
                                                                                )";
          $result = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
          }

    }

}

?>
