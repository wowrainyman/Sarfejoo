<?php

     $sender = $_GET['s'];
     $mail_from = "info@sarfejoo.com";
     $email = $_GET['e'];
     
               $subject = "Sarfejoo - صرفه جو";
               
              $message = " از سایت صرفه جو دیدن بفرمائید:";
              $message = "<br />";
              $message .= "sarfejoo.com";

                        $from  = $sender . '<' . $mail_from . '>';
                        $headers = 'From: ' . $from . "\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                        $send_email = mail($email,$subject,$message,$headers);
                        if($send_email) {
                            echo 'خطا در ارسال ایمیل، لطفا مجدد تلاش نمائید.';

                       } else {
                            echo 'ارسال شد.';
                      }

?>