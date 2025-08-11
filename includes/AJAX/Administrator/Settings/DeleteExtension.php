<?php
include "../../../../../../../wp-load.php";

// امنیت درخواست
$Sec = new secure();
$Sec->DDOS('admin');

// دریافت داده‌ها از POST
$support_id = isset($_POST['support_id']) ? intval($_POST['support_id']) : 0;
$extension = isset($_POST['extension']) ? intval($_POST['extension']) : 0;

$response = '';
$color = '';
$redirect = 0;

// بازیابی تنظیمات IVR از متا
$ivr_settings = get_option('Shahkar_ivr_extensions', []);

// بررسی اگر support_id و extension موجود باشند
if ($support_id > 0 && $extension >= 0) {
    // بررسی وجود دپارتمان مورد نظر
    if (isset($ivr_settings)) {
        // بررسی وجود داخلی برای حذف
        $found = false;
        foreach ($ivr_settings as $key => $value) {
            if (isset($value['support_id']) && $value['support_id'] == $support_id && $value['extension_number'] == $extension) {
                // حذف داخلی از دپارتمان
                unset($ivr_settings[$key]);
                $found = true;
                break;
            }
        }

        if ($found) {
            // ذخیره تغییرات پس از حذف داخلی
            update_option('Shahkar_ivr_extensions', $ivr_settings);

            $response = 'اطلاعات داخلی با موفقیت حذف شد';
            $color = "linear-gradient(to right, #00b09b, #96c93d)";
            $redirect = 1;
        } else {
            $response = 'اطلاعات مربوط به این داخلی پیدا نشد';
            $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
            $redirect = 0;
        }
    } else {
        $response = 'اطلاعات مربوط به این دپارتمان پیدا نشد';
        $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
        $redirect = 0;
    }
} else {
    $response = 'اطلاعات معتبر ارسال نشد';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
}

echo json_encode(["response" => $response, "redirect" => $redirect, "color" => $color]);
?>
