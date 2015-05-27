<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
     <meta charset="UTF-8" />
     <title></title>
     <meta name="description" content=" " />
     <meta name="viewport" content="width=device-width, initial-scale=0.8">
     <link rel="stylesheet" href="style.css" type="text/css" />

<script type="text/javascript" src="../catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>

     <script type="text/javascript">
          $(document).ready(function() {

   
               $( "#nw-e" ).hide();
               $( "#nw-s" ).hide();
               $( "#nw-em" ).hide();
               $( "#nw-em-r" ).hide();
               
               $('#search-bt').click(function() {
                  var url = 'http://sarfejoo.com/index.php?route=search/search&q=';
                  var inputURL = $('#search-input').val();
                  window.location.href = url + inputURL;
                  return false;
               });
               
               $('#search-input').keypress(function (e) {
                var key = e.which;
                if(key == 13)  // the enter key code
                 {
                  var url = 'http://sarfejoo.com/index.php?route=search/search&q=';
                  var inputURL = $('#search-input').val();
                  window.location.href = url + inputURL;
                  return false;
                 }
               }); 

               $('.c-bt').click(function() {
                    $( "#nw-e" ).hide();
                    $( "#nw-s" ).hide();
                    $( "#nw-em" ).hide();
                    $( "#nw-em-r" ).hide();
               });
               $('#sociale').click(function() {
                    $( "#nw-em" ).show();
               });
               
            $("form").submit(function() {
                 $( "#nw-em" ).hide();
                 $( "#nw-em-r" ).show();
                  var email=$('#semail').val();
                  var name=$('#name').val();
                  var url = 'mail.php?e=' + email + '&s=' + name;
                    $.ajax({
                              type: "GET",
                              url: url,
                              success: function (data) {
                                   $('#nw-email-r').text(data);
                              } 
                     });
               });
               
            $('#subscribe').click(function() {
                  var email=$('#email').val();
                  var name=$('#subject').val();
                  $.ajax({
                      url: '../index.php?route=module/newsletter/validateNewsletter',
                      type: 'post',
                      data: {
                          email: email,
                          subject: name
                      },
                      dataType: 'json',
                      beforeSend: function() {
                      },
                      complete: function() {
                      },
                      success: function(json) {
                          if (json['error']) {
                              $( "#nw-e" ).show();
                              $('#nw-error').text(json['error']['warning']);
                          } else {
                              $( "#nw-s" ).show();
                              $('#nw-success').text(json['success']);
                          }
                      }
                  });
             });

          });
     </script>		
</head>
<body>
          <div id="header">
               
          </div>
          <div id="body">
               <div id="tags">
                    <p>
                         <span class="grey">آیا تا به حال این اتفاق برای شما افتاده است که:</span><br />
                         <span>کالایی را از فروشگاهی بخرید و بعد از آن متوجه شودید که همان کالا در فروشگاه دیگری <span class="joo">ارزان تر</span>بوده است؟</span>
                    </p>
                    <img src="sarfejoo.png" alt="Sarfejoo" />
               </div>
                    <p>
                         هدف ما کاهش هزینه های زندگی مردم است. شما می توانید قبل از اقدام به خرید کالا یا خدمات، ابتدا در وب سایت 
                         <span class="sarfe">صرفه </span><span class="joo"> جو</span>
                         جست و جو کنید و قیمت و مزایای مربوط به اصناف مختلف را با هم مقایسه کنید و بهترین گزینه را انتخاب کنید.
                    </p>
               <div id="gifbox">
                    <div class="right">
                         <span class="tablets-tx"></span>
                         <p class="f-news">
                         <span style="font-size: 60px;color: #ec2c2c;">هدیه</span>
                         <span>به دوستانی که در خبرنامه</span>
                         <span class="sarfe">صرفه</span>
                         <span class="joo">جو</span>
                         <span>ثبت نام کردند.</span>
                         </p>
                         <p class="f-news-cc">
                       از اینکه با انتخاب صرفه جو، ما را در قلب و خانه خود مهمان می کنید سپاسگذاریم.
                         </p>
                    </div>
                    <div class="newsletter">
                         <input type="hidden" id="subject" value="LandingPage" />
                         <input id="email" class="input-email"type="email" placeholder="نشانی ایمیلتان را اینجا وارد کنید..." />
                         <span id="subscribe" class="nwkey">عضویت در خبرنامه</span>
                    </div>
               </div>
               <div id="tag-2">
                    <p>
                      این خبر را به گوش دوستانتان هم برسانید ...
                    </p>
                    <p>
                         <span id="sociale" class="social E"></span></a>
<a href="https://pinterest.com/pin/create/button/?url=Sarfejoo&media=http://blog.sarfejoo.com/wp-content/themes/sarfejoo/images/sarfejoo.png&description=صرفه جو" target="_blank">
                         <span class="social P"></span></a>
<a href="https://plus.google.com/share?url=http://sarfejoo.com&t=صرفه جو" target="_blank">
                         <span class="social G"></span></a>
<a href="http://twitter.com/?status=http://sarfejoo.com" target="_blank">
                         <span class="social T"></span></a>
<a href="http://www.facebook.com/sharer.php?u=http://sarfejoo.com&t=صرفه جو" target="_blank">
                         <span class="social F"></span></a>
                    </p>
               </div>
               <div id="character">
                    <span class="charac"></span>
               </div>
               <div id="search">
                    <input id="search-input" type="text" class="search" placeholder="حالا جستجو کنید ..." />
                    <span id="search-bt"></span>
                    <span id="search-baloon">جستجو در سایت</span>
                    <span id="search-baloon-a"></span>
               </div>
          </div>
          <div id="hr"></div>
          <div id="footer">
               <div id="fconta">
                    <div class="right">
                         <span class="gcar"></span>
                         <span>
                          با ما در ارتباط باشید: 
                         </span><span dir="ltr">
                              071 32341338
                         </span>
                         <div class="flinks">
                              <a href="http://sarfejoo.com/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87-%D8%B5%D8%B1%D9%81%D9%87-%D8%AC%D9%88">درباره ما</a>
                              |
                              <a href="http://sarfejoo.com/%DA%86%D8%B1%D8%A7-%D8%B5%D8%B1%D9%81%D9%87-%D8%AC%D9%88">چرا صرفه جو؟</a>
                              |
                              <a href="http://sarfejoo.com/contact">تماس با ما</a>
                         </div>
                    </div>
                    <div class="left">
                         <span class="copy">
                              <img class="foot-logo" src="sarfejoo.png" alt="Sarfejoo" />
                              Copyright © 2015 Sarfejoo.com
                         </span>
                    </div>
               </div>
          </div>
     </div>


     <div id="nw-e">
          <div id="nw-error"></div>
          <span class="c-bt">بازگشت</span>
     </div>
     <div id="nw-s">
          <div id="nw-success"></div>
          <span class="c-bt">بازگشت</span>
     </div>
     <div id="nw-em">
          <p id="nw-ppp"></p>
          <p>معرفی صرفه جو به دوستان:</p>
          <div id="nw-email">
          <form name="shem" id="shem">
               <input id="name" class="input-semail"type="text" dir="rtl" placeholder="نام کامل شما" required /><br /><br />
               <input id="semail" class="input-semail"type="email" dir="ltr" placeholder="email@example.com" required />
               <br />
               <button class="c-bts" type="submit">ارسال</button>
          </form>
          </div>
          <span class="c-bt">بازگشت</span>
     </div>
     <div id="nw-em-r">
          <div id="nw-email-r">
          </div>
          <span class="c-bt">بازگشت</span>
     </div>
</body>
</html>