<?php
declare(strict_types=1);

namespace Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AbstractProvider extends ServiceProvider
{
    /**
     * bindings.
     *
     * @var array 
     */
    public $bindings = [];

    /**
     * customValidationRules.
     *
     * @var array
     */
    protected $customValidationRules = [];

    /**
     * namespace.
     *
     * @var string 
     */
    protected $namespace = '';

    /**
     * Path Url.
     *
     * @var string
     */
    protected $routePath = '';

    /**
     * commands.
     *
     * @var array
     */
    protected $commands= [];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (file_exists($this->routePath)) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group($this->routePath);
        }

        foreach ($this->customValidationRules as $customValidationRuleKey => $customValidationRule){
            Validator::extend($customValidationRuleKey, $customValidationRule.'@validate');
            Validator::replacer($customValidationRuleKey, $customValidationRule.'@message');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->bindings as $interface => $class) {
            $this->app->bind($interface, $class);
        }

        $this->commands($this->commands);
    }

}