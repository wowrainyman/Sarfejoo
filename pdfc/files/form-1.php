<?php

     mb_internal_encoding('UTF-8');
     mb_internal_encoding('UTF-8');
     mb_http_output('UTF-8');
     mb_http_input('UTF-8');
     mb_language('uni');
     mb_regex_encoding('UTF-8');
     ob_start('mb_output_handler');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sarfejoo');
$pdf->SetTitle(' ');
$pdf->SetSubject(' ');
$pdf->SetKeywords(' ');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'  ', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/far.php')) {
	require_once(dirname(__FILE__).'/lang/far.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font


$pdf->SetFont('freeserif', '', 11);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);


// JDF
if (file_exists('jdf.php')) {
	require_once('jdf.php');
}  

$date = jstrftime('%e %B %Y');

$customer_id = $_GET['id'];
$number = 'f1-1-' . $customer_id;

$firstname = $_GET['f'];
$lastname = $_GET['l'];

$email = $_GET['e'];


// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '
<style>
.block {
     border:solid 2px #333;
     padding:15px;
}
.tnp {
     width:33%;
     border:solid 1px #888;
     font-size:12px;
     text-align:center;
}
.date {
     position: absolute;
     top:0;
     left:0;
     width:150px;
     display:block;
     border:solid 1px #888;
}
p {
     font-size:12px;
}
</style>
<div>
<table cellspacing="0" cellpadding="8">
     <tr>
          <td style="width:80%">
          <img src="images/sarfejoo.png" width="70" />
          <br>
          تعهدنامه حساب کاربری عرضه کننده کالا / خدمات 
          </td>
          <td>
           تاریخ: ' .
          $date
          . ' <br />
           <br />
           شماره: ' .
          $number
           . ' </td>
     </tr>
</table>
<p>
<table cellspacing="0" cellpadding="8">
     <tr>
          <td>
           نام: ' .
          $firstname 
          . ' </td>
          <td>
          نام خانوادگی: ' .
          $lastname
           . ' </td>
     </tr>
</table>
</p>
<table cellspacing="0" cellpadding="8">
     <tr>
          <td class="tnp">
          آدرس پست الکترونیکی
          </td>
          <td class="tnp">
          شماره تلفن همراه
          </td>
          <td class="tnp">
          شماره تماس در مواقع ضروری
          </td>
     </tr>
     <tr>
          <td class="tnp">' .
          $email
           . '</td>
          <td class="tnp">
           </td>
          <td class="tnp">
           </td>
     </tr>
</table><br />
<p>
1. کلیه اطلاعات مندرج در این تعهدنامه و حساب کاربری اینجانب واقعی و برابر اسناد رسمی کشور (شناسنامه، کارت ملی و پروانه کسب) می باشد و مسئولیت هر گونه تناقضی بین اطلاعات ثبت شده و اسناد رسمی بر عهده اینجانب می باشد.
</p>
<p>
2. استفاده از سایت صرفه جو منوط به رعایت قوانین سایت بوده و در صورت اثبات تخلف از قوانین سایت صرفه جو توسط اینجانب، واحد نظارت سایت صرفه جو اجازه دارد برابر قوانین سایت نسبت به محدود نمودن حساب کاربری اینجانب در هر مقطعی از زمان اقدام نماید.
</p>
<p>
3. کلیه قیمت ها و مشخصات ثبت شده  کالاها و خدمات مربوط به پروفایل تجاری و زیر پروفایل های اینجانب مورد تائید می باشد و متعهد می شوم در صورت اتمام موجودی یا تعیییر قیمت در نزدیکترین زمان ممکن اطلاعات را در سایت صرفه جو به روزرسانی نماینم.
</p>
<p>
4. در صورتی که اطلاعات موجودی و قیمت کالا یا خدمات  برای مدت یک هفته توسط اینجانب به روز رسانی نشده باشد، سایت صرفه جو مجاز است زیر پروفایل مربوط را برای آن محصول یا خدمات در فهرست های موضوعی سایت و جستجو های کاربران نمایش ندهد.
</p>
<p>
5. سایت صرفه جو اختیار عمل نسبت به کسر هزینه خدمات ارائه شده به زیر پروفایل ها را به صورت خودکار در پایان دوره از اعتبار حساب کاربری اینجانب در سایت  را دارد و در صورتی که اعتبار حساب کاربری اینجانب در سایت صرفه جو به میزان کافی نباشد، خدمات مذکور تا زمان شارژ مجدد اعتبار حساب کاربری  توسط اینجانب معلق گردد.
</p>
<p>
6. فعال سازی مجدد خدماتی که به دلیل کافی نبودن اعتبار در حساب کاربری به حالت تعلیق  در آمده اند، همراه با کارمزد فعال سازی مجدد خواهد بود و سایت صرفه جو مجاز است این مبلغ را به صورت خودکار از اعتبار حساب کاربری اینجانب کسر نماید.
</p>
<p>
7.  در صورتی که پس از گذشت 10 روز از زمان تعلیق خدمات سایت صرفه جو اینجانب نسبت به شارژ اعتبار حساب کاربری خود و فعال سازی مجدد اقدام ننمایم، سایت صرفه جو مجاز می باشد که خدمات مورد نظر را متوقف و کلیه اطلاعات مربوط به آن را از سایت حذف نماید.
<br /><br /><br /><br />
</p>
<br /><br /><br /><br /><br /><br />
<table cellspacing="0" cellpadding="8">
     <tr>
          <td  style="border:solid 1px #888;padding:15px;">
          اینجانب .............. در تاریخ  .... / .... / ....... کلیه موارد در این تعهدنامه را مطالعه نموده ام و تعهد می دهم نسبت به اجرای آنها پایبند باشم.
           </td>
     </tr>
</table>
<br /><br /><br /><br /><br />
<table cellspacing="0" cellpadding="8">
     <tr>
          <td></td>
          <td>اثر انگشت ↓</td>
          <td>امضاء ↓</td>
     </tr>
     <tr>
          <td></td>
          <td class="tnp"><br /><br /><br /><br /><br /><br /><br /></td>
          <td class="tnp"><br /><br /><br /><br /><br /><br /><br /></td>
     </tr>
</table>
</div>
';

      // $html = utf8_encode($html);

     //   $html = utf8_decode($html);

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('sarfejoo_form_1.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
