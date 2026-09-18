<?php

namespace App\Http\Services;

use App\Http\Channels\Sms\SmsTemplate;
use App\Http\Interfaces\SmsServiceInterface;
use InvalidArgumentException;

class SmsService implements SmsServiceInterface
{
    private array $templates = [
        SmsTemplate::LOGIN_OTP->value => 'Your one time password for login is :otp. Do not share with anyone. Parcelcounter.',

        SmsTemplate::DELIVERY_OTP->value => 'Please share this OTP with the delivery agent to complete the order. Your OTP is :otp. Parcelcounter.',

        SmsTemplate::LOCAL_LOGIN_OTP->value => 'Your OTP is: :otp. @localhost #:otp. Please do not share it with anyone. Parcel Counter.',

        SmsTemplate::WEB_LOGIN_OTP->value => 'Your OTP is: :otp. @parcelcounter.in #:otp. Please do not share it with anyone. Parcel Counter.',

        SmsTemplate::AUTO_READ_LOGIN_OTP->value => 'Your OTP is: :otp. Please do not share it with anyone. :hash. Parcel Counter.',
    ];

    public function send(string $phone, string $templateId, array $data = []): bool
    {
        if (! isset($this->templates[$templateId])) {
            throw new InvalidArgumentException("Unknown template.");
        }

        $message = $this->templates[$templateId];

        foreach ($data as $key => $value) {
            $message = str_replace(":{$key}", $value, $message);
        }

        return $this->sendSms(
            $phone,
            $message,
            $templateId
        );
    }

    private function sendSms(int $phone, string $msg, string $templateId)
    {
        if (!((bool) config('services.sms.enabled'))) {
            return true;
        }

        $data = [
            "message"    => $msg,
            "number"     => ['91'.(string)$phone],
            "senderId"   => "PRCCTR",
            "templateId" => $templateId
        ];

        $key = config('services.sms.key');
        $url = config('services.sms.url');

        //new code
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'apikey: ' . $key
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // Process your response here
        if ($err) {
            // throw $err;
            return false;
        }
        return true;
    }

    // public function sendDeliveryConfirmation(string $phone, string $otp): bool
    // {
    //     $message = "Please share this OTP with the delivery agent to complete the order. Your OTP is " . $otp . ". Parcelcounter.";
    //     return $this->send('91' . $phone, $message, "1207172174594168131");
    // }

    // public function sendLoginOtp(string $phone, string $otp): bool
    // {
    //     $message = "Your one time password for login is " . $otp . ". Do not share with anyone. Parcelcounter.";
    //     return $this->send('91' . $phone, $message, "1207172174139756075");
    // }

    // public function sendLoginOtpLocal(string $phone, string $otp): bool
    // {
    //     $message = "Your OTP is: " . $otp . ". @localhost #" . $otp . ". Please do not share it with anyone. Parcel Counter.";
    //     return $this->send('91' . $phone, $message, "1207173631334457559");
    // }

    // public function sendLoginOtpWeb(string $phone, string $otp): bool
    // {
    //     $message = "Your OTP is: " . $otp . ". @parcelcounter.in #" . $otp . " Please do not share it with anyone. Parcel Counter.";
    //     return $this->send('91' . $phone, $message, "1207173631631414784");
    // }

    // public function sendLoginOtpAutoRead(string $phone, string $otp, string $hash): bool
    // {
    //     $message = "Your OTP code is: " . $otp . ". Please do not share it with anyone. " . $hash . ". Parcel Counter.";
    //     return $this->send('91' . $phone, $message, "1207173631218395102");
    // }
}
