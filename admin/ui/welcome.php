<?php

$Sec = new secure();
$Sec->DDOS('admin');
?>
<link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css" rel="stylesheet">

<style>
    .shahkar_container{
        width: calc(80% - 30px);
        margin: 0 auto;
    }
    .shahkar_container .shahkar_welcome_poster{
        border-radius:10px;
        margin-top:20px;
        width:100%;
    }


    .shahkar_status{
        font-family:'bold';
        margin:20px auto;
    }

    table.custom-table{
        width:100%;
    }

    table.custom-table thead tr th{
        background:rgb(0, 165, 146);
        color:white;
    }

    table.custom-table tbody tr{
        background:white !important;
    }
    .space-between{
        display:inline-flex !important;
    }

    .success-status,.cancel-status,.disable-status{
        font-size:1em !important;
    }

    /* Shahkar Score Box */
    .shahkar_score{
        background:white;
        border-radius:10px;
        display:flex;
        font-size:1.1em;
        justify-content:space-between;
        align-items:center;
        font-family:'bold';
        padding:10px;
        margin-top:20px;
        box-shadow: rgba(200, 200,200, 0.5) 6px 2px 16px 0px, rgba(255, 255, 255, 0.8) -6px -2px 16px 0px;
    }
    .shahkar_score_right{
        display:flex;
        align-items:center;
    }
    .shahkar_score_right svg{
        margin-left:10px;
    }
    .shahkar_submit_score{
        color:rgb(94, 198, 101);
        border:2px solid rgb(94, 198, 101);
        padding:5px 10px;
        border-radius:7px;
        font-family:'extra-bold';
        margin-right:10px;
        text-align:center;
    }
    a.shahkar_submit_score:hover{
        color:white !important;
        background:rgb(94, 198, 101) !important;
    }
    @media screen and (max-width:768px){
        .shahkar_score,.shahkar_score_right{
            flex-direction:column;
            text-align:center;
        }
        .shahkar_score_right svg{
            margin-left:0;
            margin-bottom:15px;
            width:50px;
            height:50px;
        }
        .shahkar_submit_score{
            margin:15px 0;
        }
    }

    /* Shahkar Score Box */

    @media screen and (max-width: 768px) {
        .shahkar_container{
            width: calc(100% - 10px) !important;
            margin: 0 !important;
        }

    }
    .shahkar_transfer_script_box{
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction:column;
        background:white;padding:10px;margin:20px 0;border-radius:20px;
    }

</style>
<div class="shahkar_container">
    <div class="shahkar_score">
        <div class="shahkar_score_right">
            <svg id="_1" data-name="1" xmlns="http://www.w3.org/2000/svg" width="42" height="38" viewBox="0 0 42 38">
                <rect id="Rectangle_1679" data-name="Rectangle 1679" width="42" height="38" rx="5" fill="#5ec665"/>
                <path id="Path_1371" data-name="Path 1371" d="M197.488,257.768c3.1,8.186,17.593,7.953,20.229-.1a.557.557,0,0,0-.707-.687,32.649,32.649,0,0,1-18.859,0A.566.566,0,0,0,197.488,257.768Z" transform="translate(-186.619 -233.257)" fill="#3e3a40"/>
                <path id="Path_1372" data-name="Path 1372" d="M352.647,93.284c-2.727-4.961-9.036-2.773-3.927,8.01a.693.693,0,0,0,.832.357C360.887,97.918,358.12,91.84,352.647,93.284Z" transform="translate(-323.028 -82.587)" fill="#3e3a40"/>
                <path id="Path_1373" data-name="Path 1373" d="M140.784,93.284c2.728-4.961,9.036-2.773,3.927,8.01a.692.692,0,0,1-.832.357C132.546,97.918,135.31,91.84,140.784,93.284Z" transform="translate(-128.466 -82.587)" fill="#3e3a40"/>
            </svg>
            <div> با ثبت بازخورد  برای شاهکار ، هم از ما حمایت میکنید و هم کد تخفیف 50% برای خرید بعدیتون دریافت میکنید </div>
            <a href="https://www.rtl-theme.com/dashboard/#/downloads" class="shahkar_submit_score">ثبت بازخورد</a>
        </div>
        <svg class="shahkar_score_close" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
            <path d="M24,4C12.954,4,4,12.954,4,24c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20C44,12.954,35.046,4,24,4z M31.561,29.439c0.586,0.586,0.586,1.535,0,2.121C31.268,31.854,30.884,32,30.5,32s-0.768-0.146-1.061-0.439L24,26.121l-5.439,5.439C18.268,31.854,17.884,32,17.5,32s-0.768-0.146-1.061-0.439c-0.586-0.586-0.586-1.535,0-2.121L21.879,24l-5.439-5.439c-0.586-0.586-0.586-1.535,0-2.121s1.535-0.586,2.121,0L24,21.879l5.439-5.439c0.586-0.586,1.535-0.586,2.121,0s0.586,1.535,0,2.121L26.121,24L31.561,29.439z" fill="#121212" />
        </svg>
    </div>
    <a target="_blank" href="https://www.rtl-theme.com/shahkar-wordpress-plugin/">
        <img src="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/welcome.png" alt="welcome poster" class="shahkar_welcome_poster"/>
    </a>
    <div class="shahkar_status panel-form">
        <table class="custom-table">
            <thead>
            <tr>
                <th>#</th>
                <th>وضعیت</th>
                <th>توضیحات</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td data-label="#">وضعیت اس اس ال</td>
                <td data-label="وضعیت">
                    <?php if(is_ssl()){ echo "<div class='success-status'> SSL فعال است  </div>"; }else{ echo "<div class='success-cancel'>SSL غیرفعال است</div>"; } ?>

                </td>
                <td data-label="توضیحات">
                    در صورتی که SSL فعال نباشد برخی از قسمت های افزونه شاهکار مانند ارسال یا پخش ویس ها به طور صحیح کار نمی کنند و همچنین درخواست های AJAX به درستی کار نمی کنند
                </td>

            </tr>
            <tr>
                <td data-label="#">وضعیت دیباگ</td>
                <td data-label="وضعیت">
                    <?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) { echo "<div class='cancel-status'> هشدار ! دیباگ فعال است </div>"; }else{ echo "<div class='success-status'> خوب ! دیباگ غیرفعال است </div>"; } ?>
                </td>
                <td data-label="توضیحات">
                    با توجه به اینکه افزونه شاهکار برای افزایش سرعت و همینطور توسعه اپلیکیشن های بومی در آینده به صورت AJAX پیاده سازی شده است ، فعال بودن Debug وردپرس در افزونه اختلال ایجاد می کند و همچنین متن پاسخ ها به درستی نمایش داده نمی شود
                </td>

            </tr>
            <tr>
                <td data-label="#">site_url() </td>
                <td data-label="وضعیت">
                    <?php if(function_exists( 'site_url' ) && !empty(site_url())) { echo "<div class='success-status'> خوب ! site_url تنظیم شده است </div>"; }else { echo "<div class='cancel-status'> هشدار ! site_url تنظیم نشده است </div>"; } ?>
                </td>
                <td data-label="توضیحات">
                    تنظیم نبودن site_url در بسیاری از قسمت های پروژه از جمله رابط کاربری ، فایل ها ، پخش ویس ها و تصاویر و... اختلال ایجاد می کند
                </td>

            </tr>
            <tr>
                <td data-label="#">وضعیت لایسنس</td>
                <td data-label="وضعیت">
                    <?php if(ShahkarLicenseStatus) { echo " <div class='success-status'>خوب ! لایسنس افزونه شاهکار فعال است</div> "; }else { echo " <div class='cancel-status'> هشدار ! لایسنس افزونه شاهکار غیرفعال است </div>"; } ?>

                </td>
                <td data-label="توضیحات">
                    از اینکه از نسخه قانونی شاهکار استفاده می کنید از شما متشکریم 💙
                </td>

            </tr>
            <tr>
                <td data-label="#">وضعیت نصب افزونه شاهکار</td>
                <td data-label="وضعیت">
                    <div class="success-status"> فعال </div>
                </td>
                <td data-label="توضیحات">
                    افزونه شاهکار به درستی فعال شده است
                </td>

            </tr>
            <tr>
                <td data-label="#"> برگه پنل کاربری </td>
                <td data-label="وضعیت">
                    <?php if( !empty(get_option('shahkar_indexpage_url')) ){ echo "<div class='success-status'> ". site_url() . "/" . get_option('shahkar_indexpage_url') ." </div>"; } ?>
                </td>
                <td data-label="توضیحات">
                    لطفا برگه پنل کاربری را حذف نکنید ، در صورت حذف برگه پیکربندی را یکبار بروزرسانی کنید تا برگه مجدد ایجاد شود ، در صورت موفق نبودن عملیات ، درحال حاظر با پشتیبانی افزونه در راست چین تماس بگیرید
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</div>