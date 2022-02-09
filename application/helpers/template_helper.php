<?php
    defined('BASEPATH') or exit ('No direct script access allowed');
    
	function otp_message($otp, $otp_for)
    {
        $sms = "{$otp} is your OTP for {$otp_for} into Foxbox. It is usable once and valid for 15 mins.";
        return $sms;
    }