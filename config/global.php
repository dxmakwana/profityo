<?php

return [
    'superAdminURL' => env('SUPERADMINURL','admin'),
    'businessAdminURL' => env('BUSADMINURL','business'),
    'default_user_role' => env('DEF_USER_ROLE','Master Admin'),
    'default_user_role_alert_msg' => env('DEF_USER_ROLE_ALERT_MSG','Master is not the deleted.'),
];