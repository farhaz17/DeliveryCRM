<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en" lang=“ar” dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Assiging Detail</title>
    <link rel="stylesheet" href="style.css" media="all" />


    <style>
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">--}}


    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 18cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            /*font-family: DejaVu Sans;*/
            /*font-family: 'Tangerine', serif;*/
            font-size: 8px;

        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 1.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            /*margin: 0 0 20px 0;*/

        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
            vertical-align: bottom;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            border: 1px solid #C1CED9;
            font-size: 15px;

        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;

        }

        table th,
        table td {
            border: 1px solid #C1CED9;
        }

        table {
            padding: 5px 05px;
            color: #5D6975;
            border: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }
        .english-th{
            padding: 5px 05px;
            color: #5D6975;
            border: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
            text-align: left;
        }
        .label_color{
            color: #5D6975;
            float:right
        }
        .heading_color{
            color:#001028;
        }

        /*table .service,*/
        /*table .desc {*/
        /*    text-align: right;*/
        /*}*/

        table td {
            padding: 05px;
            text-align: left;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
            text-align: left;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
        /*.bike-detail{*/
        /*    background: #0b192b;*/
        /*    color: #ffffff;*/
        /*    padding: 5px;*/
        /*}*/

        .heading-4{
            background: #0b192b;
            color: #ffffff;
            font-size: 16px;
            text-align: center;
        }
    .heading-5{
            background: #0b192b;
            color: #ffffff;
            font-size: 16px;
            text-align: center;
        }
        .add-comments{
            border: 1px solid #000000;
            width: 700px;
            height: 70px;
        }

        .title-heading{

            font-size: 16px;
            text-align: center;
        }
    i.fa.fa-print {
        font-size: 15px;
    }
    i.i-Receipt-3 {
        font-size: 15px;
    }
    .t-header{
        font-family: DejaVu Sans;
        text-align: right;
        color: #5D6975;
        border: 1px solid #C1CED9;
        white-space: nowrap;
        font-weight: normal;
    }
    .header-span{
        font-family: DejaVu Sans;
        font-size: 16px;
        font-weight: normal;
    }
ul{
    /*list-style-type: none;*/
    text-align: justify;
    /*text-align: left;*/
}
li{
    text-align: justify;
}
.ul-span{
    font-size: 16px;
    font-family: DejaVu Sans;
    direction: rtl;
    text-align: right;
    margin-top: 10px;

}
.ul-span-en{
    font-size: 16px;
    text-align: left;
    margin-top: 10px;
    direction: ltr;

}
* {
    box-sizing: border-box;
}
.column {
    float: left;
    width: 50%;
    height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
.signature{
    position: absolute;
    left: 7%;
    font-size: 10px;
}
.signature-sp{
    float: left;
    display: table;
    direction: ltr;
    font-weight: bold;
}

    </style>
</head>
<body>
<header class="clearfix">

    <h1>ZONE DELIVERY SERVICES</h1>
{{--    <p>Address: 7-12, Opp. Emirates Driving School - Dubai</p>--}}
{{--    <p>Tel : 055 889 3094</p>--}}

</header>
<h1 class="title-heading"> <span class="header-span">اتفاقية التعامل مع الدراجة</span> Bike Handling Agreement  </h1>
<table>
    <tr>
 =
        <th class="t-header">اسم</th>
        <td>{{isset($bike_handle_detail->full_name)?$bike_handle_detail->full_name:"N/A" }} </td>
        <th class="english-th">Name</th>
    </tr>
    <tr>
        <th class="t-header">الجنسية</th>
        <td>{{isset($bike_handle_detail->nationality)?$bike_handle_detail->passport->nation->name:"N/A"}}</td>
        <th class="english-th">Nationality</th>
    </tr>
    <tr> <th class="t-header">تاريخ الولادة</th> <td>{{isset($bike_handle_detail->dob)?$bike_handle_detail->dob:"N/A"}}</td><th class="english-th">Date Of Birth</th></tr>
    <tr> <th class="t-header"> هويه الإمارات</th><td>{{isset($bike_handle_detail->emirates_id)?$bike_handle_detail->emirates_id:"N/A"}}</td> <th class="english-th">Emirates ID</th></tr>
    <tr> <th class="t-header">تاريخ اصدار</th><td>{{ isset($bike_handle_detail->emirates_issue_date)?$bike_handle_detail->emirates_issue_date:"N/A"}}</td><th class="english-th">EID Issue Date</th></tr>
    <tr> <th class="t-header">تاريخ الانتهاء</th><td>{{isset($bike_handle_detail->expiry_date)?$bike_handle_detail->expiry_date:"N/A"}}</td> <th class="english-th">EID Expiry Date</th></tr>
    <tr> <th class="t-header">المحمول</th><td>{{isset($bike_handle_detail->mobile_number)?$bike_handle_detail->mobile_number:"N/A"}}</td> <th class="english-th">Mobile Number</th></tr>
    <tr> <th class="t-header">البريد الإلكتروني</th><td>{{isset( $bike_handle_detail->email)?$bike_handle_detail->email:"N/A"}}</td><th class="english-th">Email</th></tr>
</table>
<br>
<h4 class="heading-4"> <span class="header-span">تفاصيل رخصة القيا</span> Driving License Details </h4>

<table class="table3">
    <tr><th class="t-header">رقم الرخصة</th><td>{{isset($bike_handle_detail->license_number)?$bike_handle_detail->license_number:"N/A"}}</td> <th class="english-th">License Number</th></tr>
    <tr><th class="t-header">قضية المكان</th><td>{{isset($bike_handle_detail->place_issue)?$bike_handle_detail->place_issue:"N/A"}}</td> <th class="english-th"> Place Issue</th></tr>
    <tr><th class="t-header">تاريخ الاصدار</th><td>{{isset($bike_handle_detail->issue_date)?$bike_handle_detail->issue_date:"N/A"}}</td> <th class="english-th">Issue Date</th></tr>
    <tr><th class="t-header">تاريخ الانتهاء</th><td>{{isset($bike_handle_detail->expire_date)?$bike_handle_detail->expire_date:"N/A"}}</td > <th class="english-th">Expiry Date</th></tr>
</table>

<h4 class="heading-4"> <span class="header-span">تفاصيل الدراجة</span> Bike Details </h4>
<br>
<table>
    <tr> <th class="t-header">شركة</th><td>{{isset($bike_handle_detail->company)?$bike_handle_detail->company:"N/A"}}</td> <th class="english-th">Company</th></tr>
    <tr> <th class="t-header">سنة الصنع</th><td>{{isset($bike_handle_detail->model_year)?$bike_handle_detail->model_year:"N/A"}}</td> <th class="english-th">Model Year</th></tr>
    <tr> <th class="t-header">رقم لوحة</th><td>{{isset($bike_handle_detail->plate_no)?$bike_handle_detail->plate_no:"N/A"}}</td> <th class="english-th">Plate No</th></tr>
    <tr> <th class="t-header">اللون</th><td>{{isset($bike_handle_detail->color)?$bike_handle_detail->color:"N/A"}}</td> <th class="english-th">Color</th></tr>
    <tr> <th class="t-header">تاريخ ووقت المغادرة</th><td>{{isset($bike_handle_detail->dep_date)?$bike_handle_detail->dep_date:"N/A"}}</td> <th class="english-th">Departure Date & Time</th></tr>
{{--    <tr> <th class="t-header">تاريخ ووقت العودة المتوقع</th><td>{{isset($bike_handle_detail->exp_date)?$bike_handle_detail->exp_date:"N/A"}}</td> <th class="english-th">Expected Return Date & Time</th></tr>--}}
</table>
<div style="color: #ffffff"  >
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
</div>
<div class="signature" >
    <span class="signature-sp">------------------------------------------------- Name</span>
    <span class="signature-sp">------------------------------------------ Signature</span>
    <span class="signature-sp">------------------------------------------ Officer Signature</span>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <h4 class="heading-5"> <span class="header-span">البنود و الظروف</span> Terms & Conditions </h4>
        <div class="row">
            <div class="column">
                <ul class="terms-ul">
                    <li class="ul-span-en">
                        You must not attempt to transfer bike to other person, if transfer we will charge one amount
                    </li>
                    <li class="ul-span-en">
                        Rider agrees to return the bike in clean, undamaged condition to avoid an additional charges for repair, maintenance or replacement
                        <li  class="ul-span-en">
                        Rider accepts use of the equipment as is in good condition and accepts full responsibility for care of the equipment while under rider possession
                    </li>
                    <li class="ul-span-en">
                        Damaged pass or components will be replaced at the mechanic discretion and customer agree to pay at shop rate for componets replaced
                    </li>
                    <li class="ul-span-en">Bike insurance excess amount is applicable as per insurance company rate
                    </li>
                    <li class="ul-span-en">
                        Alcohal is not allowed
                    </li>
                    <li class="ul-span-en">
                        The rider hereby agree to obey all UAE traffic laws and regulations while riding
                    </li>
                    <li class="ul-span-en"> Any time we  call the bike the bike should be in good condition</li>
                    <li class="ul-span-en">
                        Bike key and registration card is the responsibility of the rider, lost these we will charge from your side
                    </li>
                </ul>
            </div>
            <div class="column">
                <ul class="terms-ul">
                    <li class="ul-span">يجب ألا تحاول نقل الدراجة إلى شخص آخر ، في حالة النقل ، فسنخصم مبلغًا واحدًا </li>
                    <li class="ul-span">يوافق الراكب على إعادة الدراجة في حالة نظيفة وغير تالفة لتجنب رسوم إضافية للإصلاح أو الصيانة أو الاستبدال
                    </li>
                    <li class="ul-span">يقبل الراكب استخدام الجهاز كما هو في حالة جيدة ويتحمل المسؤولية الكاملة عن العناية بالمعدات أثناء امتلاك الراكب</li>
                    <li class="ul-span">سيتم استبدال الممر أو المكونات التالفة وفقًا لتقدير الميكانيكي ويوافق العميل على الدفع بسعر المتجر للمكونات المستبدلة
                    </li>
                    <li class="ul-span">
                        المبلغ الزائد للتأمين على الدراجة قابل للتطبيق حسب سعر شركة التأمين
                    </li>
                    <li class="ul-span">
                        الكوهال غير مسموح به
                    </li>
                    <li class="ul-span">
                        يوافق الراكب بموجب هذا على الامتثال لجميع قوانين وأنظمة المرور الإماراتية أثناء الركوب
                    </li>
                    <li class="ul-span">
                        في أي وقت نسمي فيه الدراجة ، يجب أن تكون الدراجة في حالة جيدة</li>
                    <li class="ul-span">
                        يقع مفتاح الدراجة وبطاقة التسجيل على عاتق الراكب ، إذا فقدهما ، سنقوم بشحنه من جانبك
                    </li>

                </ul>
            </div>
        </div>






{{--</table>--}}



</body>
</html>
