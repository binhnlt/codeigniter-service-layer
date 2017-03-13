<?php

class MY_Service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        log_message('info', 'Service Class Initialized');
    }
    
}
