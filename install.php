<?php
/**
 * Installer of CodeIgniter service layer project
 *
 * @author     Nguyen Luu Thanh Binh <nguyenluuthanhbinh@outlook.com>
 * @license    MIT License
 * @copyright  2017 Nguyen Luu Thanh Binh
 * @link       https://github.com/nltbinh/
 */

$installer = new Installer();
$installer->install();

class Installer
{
    public static function install()
    {
        self::copy('vendor/nltbinh/codeigniter-service-layer/application/core/MY_Loader.php', 'application/core/MY_Loader.php');
        self::copy('vendor/nltbinh/codeigniter-service-layer/application/core/Service.php', 'application/core/Service.php');
        mkdir('application/services');
    }

    private static function copy($src, $dst)
    {
        $success = copy($src, $dst);
        if ($success) {
            print 'copied: ' . $dst . PHP_EOL;
        }
    }
}
