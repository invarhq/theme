<?php
/** {license_text}  */ 
namespace Theme;

use Closure;
use Illuminate\Contracts\Config\Repository;

class Config
{
    protected $applicationConfig;

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->applicationConfig = $config;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->getValue($this->applicationConfig, $key, $default);
    }

    /**
     * @param Repository $config
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function getValue(Repository $config, $key, $default = null)
    {
        if ($config[$key] && $config[$key] instanceof Closure) {
            $value = call_user_func($config[$key]);
        } else {
            $value = $config[$key];
        }

        return !is_null($value) ? $value : $default;
    }
}
