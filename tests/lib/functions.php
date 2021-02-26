<?php
namespace Tests\Lib\Functions;

function delete_files_recursive($c_target)
{
    if (!file_exists($c_target)) return;

    if (is_dir($c_target)) {
        $files = glob($c_target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_files_recursive($file);
        }

        rmdir($c_target);

    } elseif (is_file($c_target)) {
        unlink($c_target);
    }
}

function delete_files(string $c_target) {

    if (!file_exists($c_target)) return;

    if (is_dir($c_target)) {
        $c_target_dir = $c_target;

        if (DIRECTORY_SEPARATOR !== '/') {
            $c_target_dir = str_replace('\\', '/', $c_target_dir);
        }//endif

        $it = new \RecursiveDirectoryIterator($c_target_dir, \RecursiveDirectoryIterator::SKIP_DOTS);

        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }//endforeach

        rmdir($c_target_dir);

    } elseif (is_file($c_target)) {
        unlink($c_target);
    }//endif

}