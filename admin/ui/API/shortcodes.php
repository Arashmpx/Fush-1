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
  .shahkar_container_title{
   	font-family:'extra-bold';
    font-size:18px;
    text-align:center;
  }
  .shahkar_container_des{
   	font-family:'bold';
    font-size:14px;
    text-align:center;
    margin-top:10px;
  }
  .shahkar_container_info{
   	margin:30px 0; 
  }

</style>
<div class="shahkar_container">
  <div class="shahkar_container_info">
  	<div class="shahkar_container_title">لیست شورت کد های اولیه </div>
	<div class="shahkar_container_des"> شورت کد های زیر را می توانید در صفحات ، برگه ها ، مطالب ، و در کد های خود استفاده کنید ، پارامتر های خواسته شده را به دقت بررسی و مطابق آنها از شورت کد ها استفاده کنید  </div>
  </div>

    <div class="panel-form">
        <table class="custom-table">
            <thead>
            <tr>
                <th>نام شورت کد</th>
                <th>کد</th>
                <th>راهنما</th>
                <th>پارامتر</th>
                <th>کد php</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td data-label="نام شورت کد">
                    دریافت اعتبار کیف پول کاربر
                </td>
                <td data-label="کد">
                    [ShahkarUserWalletAmount uid="1"]
                </td>
                <td data-label="راهنما">
                   در پارامتر uid باید آی دی کاربر مورد نظر را ارسال کنید ، می توانید به صورت دستی یا با تابع get_current_user_id() آی دی کاربر را ارسال کنید
                </td>
               <td data-label="پارامتر">
                   uid
                </td>
              <td data-label="کد php">
                     do_shortcode('[ShahkarUserWalletAmount uid="1"]');
                </td>

            </tr>
            <tr>
                <td data-label="نام شورت کد">
                   دریافت تصویر پروفایل کاربر
                </td>
                <td data-label="کد">
                   [ShahkarGetAvatar uid="1"]
                </td>
              <td data-label="راهنما">
                   در پارامتر uid باید آی دی کاربر مورد نظر را ارسال کنید ، می توانید به صورت دستی یا با تابع get_current_user_id() آی دی کاربر را ارسال کنید
                </td>
                <td data-label="پارامتر">
                    uid
                </td>
              <td data-label="کد php">
                     do_shortcode('[ShahkarGetAvatar uid="1"]');
                </td>

            </tr>

              <tr>
                <td data-label="نام شورت کد">
                   دریافت وضعیت احراز هویت کاربر در سامانه امتا
                </td>
                <td data-label="کد">
                   [ShahkarEmtaStatus uid="1"]
                </td>
                <td data-label="راهنما">
                   در پارامتر uid باید آی دی کاربر مورد نظر را ارسال کنید ، می توانید به صورت دستی یا با تابع get_current_user_id() آی دی کاربر را ارسال کنید
                </td>
                <td data-label="پارامتر">
                    uid
                </td>
                <td data-label="کد php">
                     do_shortcode('[ShahkarEmtaStatus uid="1"]');
                </td>

            </tr>


            <tr>
                <td data-label="نام شورت کد">
                   دریافت امتیاز کاربر
                </td>
                <td data-label="کد">
                   [ShahkarUserScore uid="1"]
                </td>
                <td data-label="راهنما">
                   در پارامتر uid باید آی دی کاربر مورد نظر را ارسال کنید ، می توانید به صورت دستی یا با تابع get_current_user_id() آی دی کاربر را ارسال کنید
                </td>
                <td data-label="پارامتر">
                    uid
                </td>
                <td data-label="کد php">
                     do_shortcode('[ShahkarUserScore uid="1"]');
                </td>

            </tr>

            <tr>
                <td data-label="نام شورت کد">
                   افزایش اعتبار کیف پول کاربر
                </td>
                <td data-label="کد">
                   [ShahkarincreaseWallet uid="1" amount="10000"]
                </td>
                <td data-label="راهنما">
                   
                   در پارامتر uid باید آی دی کاربر مورد نظر را ارسال کنید ، می توانید به صورت دستی یا با تابع get_current_user_id() آی دی کاربر را ارسال کنید
            در پارامتر amount مبلغی که میخواهید به اعتبار کیف پول کاربر مورد نظر اضافه شود را وارد کنید ( بدون جدا کننده )    
                </td>
                <td data-label="پارامتر">
                    uid,amount
                </td>
                <td data-label="کد php">
                     do_shortcode('[ShahkarUserScore uid="1" amount="10000"]');
                </td>

            </tr>

            </tbody>
        </table>
    </div>


</div>
