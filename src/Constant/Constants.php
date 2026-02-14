<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Constant;

class Constants
{
    const PARAM_USERID = "userid";
    const PARAM_PASSWORD = "password";
    const PARAM_APIKEY = "apikey";
    const PARAM_PHONE = "mobile";
    const PARAM_MESSAGE = "msg";
    const PARAM_SENDERID = "senderid";
    const PARAM_SCHEDULE = "scheduleTime";

    const PARAM_MEDIUM = "medium"; 
    const PARAM_CODETYPE = "codeType"; 
    const PARAM_CODEEXPIRY = "codeExpiry"; 
    const PARAM_CODELENGTH = "codeLength"; 

    const PARAM_CHECK_DUPLICATE = "duplicatecheck";
    const CHECK_DUPLICATE = true;

    const PARAM_SSL_VERIFY = "verify";
    const PARAM_TIMEOUT = "timeout";
    const PARAM_CONNECT_TIMEOUT = "connect_timeout";
    const PARAM_HTTP_ERRORS = "http_errors";
    const PARAM_DEBUG = "debug";

    const PARAM_MESSAGE_TYPE = "msgType";
    const TYPE_TEXT_MESSAGE = "text";
    const TYPE_UNICODE_MESSAGE = "unicode";
    const TYPE_FLASH_MESSAGE = "flash";
    
    const PARAM_FORMAT = "output";
    const FORMAT_JSON = "json";
    const FORMAT_PLAIN = "plain";
    const FORMAT_XML = "xml";

    const PARAM_SEND_METHOD = "sendMethod";
    const QUICK_MESSAGE = "quick";
    const SIMPLE_MESSAGE = "simpleMsg";
    const GROUP_MESSAGE = "groupMsg";
    const BULK_MESSAGE = "excelMsg";
    
    const PARAM_PATTERNS = [
        'PHONE_NUMBER' => '/(\+254|254)([7][0-9]|[1][0-1]){1}[0-9]{1}[0-9]{6}/',
    ];


    protected function validPhone(string $phone)
    {
        if (isset($phone)) {
            if (preg_match(self::PARAM_PATTERNS['PHONE_NUMBER'], $phone)) {
                return true;
            }
        }

        throw new MessagerException("The mobile phone: {$phone} is invalid. All phones must start with +254 or 254");
    }

    /**
     * Helper method to check if the response indicates success.
     */
    protected function is_successful(array $result): array
    {
        if ($result['status'] === 200 && isset($result['body']['status']) && $result['body']['status'] === 'success') 
        {
            return [
                'status'  => 'success',
                'message' => 'Message sent successfully!',
            ];
        }

        return [
            'status'  => 'error',
            'message' => $result['body']['error'] ?? 'Failed to send message',
        ];
    }
    
    protected function is_connected($host = 'www.google.com'): bool
    {
        $connected = @fsockopen($host, 80); 
        //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }
}
