<?php
require_once('../../../../../../wp-load.php');
if (get_option('Shahkar_Ai_Support_Answer_status') == "on") {

global $wpdb;

$ticket = $wpdb->get_row("
    SELECT * FROM Shahkar_tickets 
    WHERE vt_status = 0 
    ORDER BY vt_id DESC 
    LIMIT 1
");
if ($ticket) {
    $systemPrompt  = get_option('Shahkar_AI_Support_Learn') ?: 'شما یک دستیار هوش مصنوعی هستید.';
    //$responseTitle = ' تو به عنوان فروشنده فعالیت می کنی و باید کاربر رو راضی نگه داری ';
    $userMessage   = $ticket->vt_title . "\n\n" . $ticket->vt_message;

    $apiKey = get_option('Shahkar_Ai_Support_Answer_Token');
    $apiUrl = get_option('Shahkar_Ai_Support_Base_Url');

    $payload = [
        "model" => "deepseek-chat",
        "max_tokens" => (int)get_option('Shahkar_Ai_Support_Answer_Max_Token'),
        "temperature" => (float)get_option('Shahkar_Ai_Support_Answer_Creativity'),
        "messages" => [
            ["role" => "system", "content" => $systemPrompt],
            ["role" => "user", "content" => $userMessage]
        ]
    ];

    // 3. ارسال به DeepSeek
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    $aiReply = $result['choices'][0]['message']['content'] ?? null;
    if(!empty($aiReply)){

        $wpdb->insert("Shahkar_tickets_reply", [
            'vtr_uid'        => '092210',
            'vtr_time'       => "2025",
            'vtr_ticket_id'  => $ticket->vt_id,
            'vtr_message'        => $aiReply
        ]);

         $wpdb->update("Shahkar_tickets", ['vt_status' => 1], ['vt_id' => $ticket->vt_id]);
    }
  }
}
