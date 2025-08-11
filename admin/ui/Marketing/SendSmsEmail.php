<?php
$Sec = new secure();
$Sec->DDOS('admin');

if (isset($_POST['submit'])) {
    $campaign_name = $_POST['shahkar_campaign_name'];
    $send_type = $_POST['SendType'];
    $orders_status = $_POST['OrdersStatus'];
    $notification_text = $_POST['shahkar_notification_text'];

    $user_ids = array();

    if ($orders_status == "allusers") {
        $user_query = new WP_User_Query(array('fields' => 'ID'));
        $user_ids = $user_query->get_results();
    } elseif ($orders_status == "yes") {
        $user_query = new WP_User_Query(array(
            'meta_key' => '_order_count',
            'meta_value' => 0,
            'meta_compare' => '>',
            'fields' => 'ID'
        ));
        $user_ids = $user_query->get_results();
    } elseif ($orders_status == "no") {
        $user_query = new WP_User_Query(array(
            'meta_key' => '_order_count',
            'meta_value' => 0,
            'meta_compare' => '=',
            'fields' => 'ID'
        ));
        $user_ids = $user_query->get_results();
    }

    if ($send_type == "email") {
        $sent_count = 0;
        foreach ($user_ids as $user_id) {
            $user_info = get_userdata($user_id);
            $user_email = $user_info->user_email;
            
            $subject = $campaign_name;
            $message = '
            <html>
            <body>
                <div style="text-align: center;">
                    <img src="URL_OF_YOUR_LOGO" alt="Logo" style="width: 100px; height: auto;">
                </div>
                <div>
                    ' . $notification_text . '
                </div>
            </body>
            </html>';
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . $campaign_name . ' <no-reply@yourdomain.com>');
            
            if (wp_mail($user_email, $subject, $message, $headers)) {
                $sent_count++;
            }
        }
        
        ?>
<div class="notice notice-success is-dismissible">
        <p><?php _e( ' ایمیل با موفقیت ارسال شد ، تعداد ایمیل های شناسایی شده :  ' . $sent_count, 'text-domain' ); ?></p>
    </div>
        <?php
    } elseif ($send_type == "sms") {
        $user = new user();
        $phone_numbers = array();
        foreach ($user_ids as $user_id) {
            $phone_number = $user->Shahkar_getNumber($user_id);
            if (!empty($phone_number)) {
                $phone_numbers[] = $phone_number;
            }
        }
        
        if (!empty($phone_numbers)) {
            $sms = new sms(); 
            $sms->SendToUsers($notification_text, $phone_numbers);
            $sent_count = count($phone_numbers);    

           ?>
 <div class="notice notice-success is-dismissible">
        <p><?php _e( ' درخواست ارسال با موفقیت به سرور سامانه پیامک ارسال شد  ، تعداد شماره های شناسایی شده :  ' . $sent_count, 'text-domain' ); ?></p>
    </div>
           <?php
        } else {
            echo "<div class='sms-status'>";
            echo "<p>هیچ شماره‌ای برای ارسال پیامک پیدا نشد.</p>";
            echo "</div>";
        }
    }
}
?>
    <link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/styles/toastify.min.css">

<style>
        body ,#tinymce{
            font-family: 'regular' !important;
            font-size: 18px;
        }
  .panel-form .input {
    width: 100%;
    margin-bottom: 10px;
}

.panel-form .half-input {
    width: 49%;
    margin-bottom: 10px;
}

.panel-form label span {
    font-family: 'extra-bold', serif;
    font-size: .8em;
    margin: 10px 0;
    display: inline-block;
}

.panel-form input[type="text"], .panel-form input[type="file"], .panel-form select, .panel-form textarea, .panel-form input[type="submit"], .panel-form button {
    width: calc(100% );
    resize: none;
    border: 1px solid #ddd;
    background: white;
    padding: 10px;
    border-radius: 5px;
    font-family: 'regular', serif;
    font-size: .8em;
}

.panel-form .inputs {
    display: flex;
    justify-content: space-between;
}

.panel-form input[type="submit"], .panel-form button {
    width: auto;
    margin-top: 20px;
    cursor: pointer;
    background: var(--primary-color);
    border: none;
    color: white;
    font-family: 'extra-bold', serif;
    padding: 10px;
}
.shahkar_status {
    font-family: 'bold';
    margin: 20px auto;
}
.shahkar_container {
    width: calc(90% - 30px);
    margin: 0 auto;
}
@media screen and (max-width: 768px) {
    .shahkar_container {
        width: calc(100% - 10px) !important;
        margin: 0 !important;
    }
}
</style>
<form method="POST" action="">
    <div class="shahkar_container">
        <div class="shahkar_status panel-form">
            <div style="background:white;padding:10px;border-radius:10px;margin-bottom:15px;font-size: 15px;">
                💡 این نوع ارسال ، تنها به کاربرانی که ایمیل یا شماره آنها در سیستم شناسایی شده باشد ارسال خواهد شد
            </div>

            <div style="background:white;padding:10px;border-radius:10px;margin-bottom:15px;font-size: 15px;">
                💡 در ارسال گروهی پیامک ، شماره هایی که پیامک های تبلیغاتی را مسدود کرده باشند پیام شمارا دریافت نخواهد کرد 
            </div>


            <div class="input">
                <label>
                    <span> نام کمپین </span>
                    <input name="shahkar_campaign_name" placeholder="نام کمپین  خود را وارد نمایید ..." type="text" class="regular-text">
                </label>
            </div>
            <div class="inputs">
                <div class="half-input">
                    <label>
                        <span> نوع ارسال </span>
                        <select name="SendType">
                            <option /selected> انتخاب کنید </option>
                            <option value="email"> ایمیل </option>
                            <option value="sms"> پیامک </option>
                            <option /disabled> ایمیل و پیامک ( به زودی ) </option>
                        </select>
                    </label>
                </div>
                <div class="half-input">
                    <label>
                        <span> وضعیت خرید <?php if(!ShahkarIs_Woo()){ echo " نیاز به ووکامرس دارد "; } ?></span>
                        <select name="OrdersStatus">
                            <option /selected value="allusers"> انتخاب کنید </option>
                            <?php if(ShahkarIs_Woo()){ ?>
                                <option value="allusers"> همه کاربران </option>
                                <option value="no"> افراد بدون سابقه خرید </option>
                                <option value="yes"> افرادی که سابقه خرید دارند </option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <?php wp_editor('', 'shahkar_notification_text'); ?>
        <div class="panel-form">
            <div class="input">
                <label>
                    <button type="submit" name="submit" id="send">ارسال اعلان</button>
                </label>
            </div>
        </div>
    </div>
</form>


<script src="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/js/toastify-js.js"></script>
<script>
      function showmsg(tx, rgb) {
            Toastify({
                text: tx,
                duration: 5000,
                destination: "#",
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                backgroundColor: rgb,
                stopOnFocus: true, // Prevents dismissing of toast on hover
                onClick: function() {} // Callback after click
            }).showToast();
        }
    
    $("#send").click(function() {
              var color = 'linear-gradient(to right, #95a5a6, #7f8c8d)';
        showmsg('در حال ارسال اعلان', color);
            //Send request Shahkar SUpport

            var title = $('#shahkar_notification_title').val();
            var text = tinymce.get('shahkar_notification_text').getContent();
      		var SendByStates = $("#SendByStates").val();
      		var SendByGender = $("#SendByGender").val();
            const httpURL = '<?php echo site_url(); ?>';

            $.ajax({
                type: 'POST',
                url: httpURL + '/wp-content/plugins/Shahkar/includes/AJAX/Administrator/Notifications/Send.php',
                data: {
                    title: title,
                    text: text,
                  	SendByStates: SendByStates,
                  	SendByGender: SendByGender
                },
                success: function(data) {
                    var res = JSON.parse(data);
          	var response = res.response;
          	var status = res.status;
          	var title = res.title;
          	var color = res.color;
                    
                    showmsg('' + response + '', '' + color + '');
                    
                    if (res.redirect == 1) {
                        setTimeout(function() {
                             location.reload(); 
                        }, 1500)

                    }
                }
            });
        });
</script>