<?php

require_once "smtp/Mail.php";

     $from = 'test@localhost.com';
     $to =  'wowrainyman@gmail.com';
     $subject =  'subject Test';
     $text =  'مثال';
     $costumer_id =  '50';
     $admin_id =  '6';

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
          echo("<p>Message successfully sent!</p>");
        }
?>