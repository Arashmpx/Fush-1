<?php
class WalletChargeHandler
{
    private $userId;
    private $amount;

    public function __construct()
    {
        $this->userId = get_current_user_id();
        $this->amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    }

    public function handleChargeRequest()
    {
        if ($this->validateAmount()) {
            $this->processCharge();
        } else {
            $this->response('مبلغ وارد شده معتبر نمی‌باشد', false);
        }

        $this->sendResponse();
    }

    private function validateAmount()
    {
        $minimumAmount = get_option('shahkar_minimum_amount_wallet_charge');
        $maximumAmount = get_option('shahkar_maximum_amount_wallet_charge');

        if (!empty($minimumAmount) && $this->amount < $minimumAmount) {
            $this->response(ShahkarGetTranslateText('ShahkarMinWalletChargeAmountResponse') . number_format($minimumAmount) . ShahkarGetTranslateText('ShahkarUnitAmountWalletChargeResponse'), false);
            return false;
        }

        if (!empty($maximumAmount) && $this->amount > $maximumAmount) {
            $this->response(ShahkarGetTranslateText('ShahkarMaxWalletChargeAmountResponse') . number_format($maximumAmount) . ShahkarGetTranslateText('ShahkarUnitAmountWalletChargeResponse'), false);
            return false;
        }

        return true;
    }

    private function processCharge()
    {
        $merchantId = get_option('shahkar_zarinpal_code');
        $callbackURL = get_site_url() . '/' . get_option('shahkar_indexpage_url') . '/?p=wallet';
        $sandbox = false;

        $zarinpal = new Shahkarzarinpal();
        $result = $zarinpal->request($merchantId, $this->amount, "تراکنش توسط کاربر با شناسه: {$this->userId}", '', '', $callbackURL, $sandbox);

        if (isset($result['Status']) && $result['Status'] == 100) {
            $this->saveTransactionToDatabase($result['Authority']);
            $this->response(ShahkarGetTranslateText('ShahkarWalletChargeTransferringPaymentGatewayResponse'), true, $result['StartPay']);
        } else {
            $this->response(ShahkarGetTranslateText('ShahkarWalletChargeTransferringErrorResponse'), false);
        }
    }

    private function saveTransactionToDatabase($authority)
    {
        global $wpdb;

        $tableName = 'Shahkar_transaction';
        $time = time();
        $data = [
            'vtr_uid' => $this->userId,
            'vtr_auth' => $authority,
            'vtr_time' => $time,
            'vtr_amount' => $this->amount,
        ];

        $wpdb->insert($tableName, $data);
    }

    private function response($message, $success, $url = '')
    {
        $color = $success ? 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))' : 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
        $redirect = $success ? 1 : 0;
        echo json_encode(["status" => $success, 'response' => $message, "redirect" => $redirect, "url" => $url, "color" => $color]);
        exit();
    }

    private function sendResponse()
    {
        $this->response(ShahkarGetTranslateText('ShahkarWalletChargeErrorResponse'), false);
    }
}
?>