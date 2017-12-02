<?php

    function statusText($status) {
        switch ($status) {
            case 'ru':
                return 'Registered User';
                break;
            case 'sme':
                return 'Subject Matter Expert';
                break;
            case 'sysadmin':
                return 'System Admin';
                break;
            default:
                return $status;
        }
    }