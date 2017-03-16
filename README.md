# CodeIgniter Service Layer

A simple service layer for CodeIgniter

## Usage

1. Download and override this project to your CodeIgniter project
2. Create an Service file in `\application\services\` with file name `Sample_service.php`
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
