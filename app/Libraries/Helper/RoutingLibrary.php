<?php

namespace App\Libraries\Helper;

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Controller;
use Composer\Autoload\ClassMapGenerator;

class RoutingLibrary
{
    private $controllerDirectory;

    public function __construct()
    {
        $this->controllerDirectory = app_path() . '/Http/Controllers';
    }

    public function possibleRouteList(): array
    {
        $possibleRouteList = [];
        $ignoreMethods = [
            '__construct',
        ];
        $ignoreClasses = [
            VerificationController::class,
            ConfirmPasswordController::class,
            LoginController::class,
            ResetPasswordController::class,
            RegisterController::class,
            ForgotPasswordController::class,
            Controller::class,
        ];
        if (file_exists($this->controllerDirectory)) {
            foreach (ClassMapGenerator::createMap($this->controllerDirectory) as $class => $path) {
                if (!in_array($class, $ignoreClasses, true)) {
                    $parentMethods = get_class_methods(get_parent_class($class));
                    foreach (array_diff(get_class_methods($class), $parentMethods, $ignoreMethods) as $method) {
                        $possibleRouteList[] = $class . '@' . $method;
                    }
                }
            }
        }
        return $possibleRouteList;
    }
}
