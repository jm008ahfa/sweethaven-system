<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Security extends BaseConfig
{
    public $csrfProtection = 'cookie';  // Change from 'session' to 'cookie'
    public $tokenRandomize = false;
    public $tokenName = 'csrf_token_name';
    public $headerName = 'X-CSRF-TOKEN';
    public $cookieName = 'csrf_cookie_name';
    public $expires = 7200;
    public $regenerate = true;
    public $redirect = false;
    public $sameSite = 'Lax';
}