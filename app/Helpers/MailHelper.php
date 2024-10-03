<?php

namespace App\Helpers;

use App\Models\EmailConfiguration;

class MailHelper {


    public static function setMailConfig() {


        $emailConfig = EmailConfiguration::first();

        $config =[
            'transport' => 'smtp',
            'host' => $emailConfig->host ,
            'port' => $emailConfig->port ,
            'encryption' => $emailConfig-> encryption ,
            'username' => $emailConfig->username ,
            'password' => $emailConfig->password ,
            'timeout' => null ,
            'local_domain' => env('MAIL_EHLO_DOMAIN')
        ];

        Config(['mail.mailer.smtp' => $config]);

        Config(['mail.from.address' => $emailConfig->email]);

    }









}