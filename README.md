# CodeIgniter Service Layer

If you're too lazy to create your own service class, use this. =) 
(Sorry for by bad English)

## INSTALL

### If you're using Composer
```
composer require nltbinh/codeigniter-service-layer
php vendor/nltbinh/codeigniter-service-layer/install.php
```

### If you're not using composer
Download and override this project to your CodeIgniter project

## USAGE
1. Install this project
2. Create an Service in `\application\services\` with file name `Sample_service.php`
```
<?php

class Sample_service extends MY_Service
{
    public function hello_world()
    {
        return "Hello world";
    }
}
```
3. Use service is the same as Model in Controller

```
$this->load->service('sample_service', '', TRUE);
```
