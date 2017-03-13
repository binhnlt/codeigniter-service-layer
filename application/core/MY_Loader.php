<?php

class MY_Loader extends CI_Loader
{

    /**
     * List of loaded services
     *
     * @var	array
     */
    protected $_ci_services =    array();

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Service Loader
     *
     * Loads and instantiates services.
     *
     * @param	string	$service		Service name
     * @param	string	$name		An optional object name to assign to
     * @param	bool	$db_conn	An optional database connection configuration to initialize
     * @return	object
     * 
     * modified by Nguyen Luu Thanh Binh <nguyenluuthanhbinh@outlook.com>
     */
    public function service($service, $name = '', $db_conn = false)
    {
        if (empty($service)) {
            return $this;
        } elseif (is_array($service)) {
            foreach ($service as $key => $value) {
                is_int($key) ? $this->service($value, '', $db_conn) : $this->service($key, $value, $db_conn);
            }

            return $this;
        }

        $path = '';

        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($service, '/')) !== false) {
            // The path is in front of the last slash
            $path = substr($service, 0, ++$last_slash);

            // And the service name behind it
            $service = substr($service, $last_slash);
        }

        if (empty($name)) {
            $name = $service;
        }

        if (in_array($name, $this->_ci_services, true)) {
            return $this;
        }

        $CI =& get_instance();
        if (isset($CI->$name)) {
            throw new RuntimeException('The service name you are loading is the name of a resource that is already being used: '.$name);
        }

        if ($db_conn !== false && ! class_exists('CI_DB', false)) {
            if ($db_conn === true) {
                $db_conn = '';
            }

            $this->database($db_conn, false, true);
        }

        $app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
        if (file_exists($app_path.'Service.php')) {
            load_class('Model', 'core');
            require_once($app_path.'Service.php');
            if (! class_exists('CI_Model', false)) {
                throw new RuntimeException($app_path."Service.php exists, but doesn't declare class CI_Model");
            }
        }

        $class = config_item('subclass_prefix').'Service';
        if (file_exists($app_path.$class.'.php')) {
            require_once($app_path.$class.'.php');
            if (! class_exists($class, false)) {
                throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
            }
        }

        $service = ucfirst($service);
        if (! class_exists($service, false)) {
            foreach ($this->_ci_model_paths as $mod_path) {
                if (! file_exists($mod_path.'services/'.$path.$service.'.php')) {
                    continue;
                }

                require_once($mod_path.'services/'.$path.$service.'.php');
                if (! class_exists($service, false)) {
                    throw new RuntimeException($mod_path."services/".$path.$service.".php exists, but doesn't declare class ".$service);
                }

                break;
            }

            if (! class_exists($service, false)) {
                throw new RuntimeException('Unable to locate the service you have specified: '.$service);
            }
        }

        $this->_ci_services[] = $name;
        $CI->$name = new $service();
        return $this;
    }
}
