<?php

namespace Theme;

use Illuminate\Support\ServiceProvider as ServiceProviderAbstract;
use Layout\Element\Factory\FactoryInterface;
use Layout\Config as LayoutConfig;

/**
 * This is the flysystem service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class ServiceProvider extends ServiceProviderAbstract
{
    protected $defer = true;
    /** @var  Config */
    protected $config;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function provides()
    {
        return [
            'Layout\Config',
            'Theme\Config',
            'Theme\Backend',
            'Theme\Frontend',
        ];
    }

    /**
     * Prepare base environment
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Theme\Config');
        $this->config = $this->app->make('Theme\Config');
        
        $this->configureLayout();
        $this->configureBackend();
        $this->configureFronted();
        $this->configureElementTypes();
    }

    /**
     * Setup layout configuration
     */
    protected function configureLayout()
    {
        /** @var LayoutConfig $layoutConfig */
        $layoutConfig = $this->app->make('Layout\Config');
        $this->app->singleton('Layout\Config', function () use ($layoutConfig) {
            $layoutConfig->setCacheEnabled($this->config->get('theme.cache_enabled'));
            $designDir      = $this->config->get('theme.filesystem.design');
            $basePackage    = 'base';
            $baseTheme      = 'default';
            $currentPackage = $this->config->get('theme.package');
            $defaultTheme   = $this->config->get('theme.theme.default');
            $currentTheme   = $this->config->get('theme.theme.current');
            
            // Fallback to base theme
            if ($basePackage && $baseTheme) {
                $layoutConfig->addConfigPath("{$designDir}/{$basePackage}/{$baseTheme}/layout");
            }

            // Fallback to default theme if defined
            if ($currentPackage && $defaultTheme) {
                $layoutConfig->addConfigPath("{$designDir}/{$currentPackage}/{$defaultTheme}/layout");
            }

            if ($currentPackage && $currentTheme) {
                $layoutConfig->addConfigPath("{$designDir}/{$currentPackage}/{$currentTheme}/layout");
            }

            return $layoutConfig;
        });
    }

    /**
     * Setup backend configuration
     */
    protected function configureBackend()
    {
        $this->app->singleton('Theme\Backend', function () {
            $backend = new Backend();
            /** @var \Illuminate\Contracts\Config\Repository $config */
            $config         = $this->app->make('Illuminate\Contracts\Config\Repository');
            $designDir      = $config['theme.filesystem.design'];
            $basePackage    = 'base';
            $baseTheme      = 'default';
            $currentPackage = $config['theme.package'] ?: null;
            $defaultTheme   = $config['theme.theme.default'] ?: null;
            $currentTheme   = $config['theme.theme.current'] ?: null;

            // Fallback to base theme
            if ($basePackage && $baseTheme) {
                $backend->addTemplatePath("{$designDir}/{$basePackage}/{$baseTheme}/template");
            }

            // Fallback to default theme if defined
            if ($currentPackage && $defaultTheme) {
                $backend->addTemplatePath("{$designDir}/{$currentPackage}/{$defaultTheme}/template");
            }
            
            if ($currentPackage && $currentTheme) {
                $backend->addTemplatePath("{$designDir}/{$currentPackage}/{$currentTheme}/template");
            }
            
            return $backend;
        });
    }

    /**
     * Setup frontend configuration
     */
    protected function configureFronted()
    {
        $this->app->when('Theme\Frontend')->needs('League\Flysystem\Filesystem')->give(function() {
            /** @var FilesystemFactory $factory */
            $factory        = new FilesystemFactory($this->app);
            return $factory->makeFilesystem($this->config->get('theme.filesystem.public'));
        });
        
        /** @var \Theme\Frontend $frontend */
        $frontend = $this->app->make('Theme\Frontend');
        $this->app->singleton('Theme\Frontend', function () use ($frontend) {
            $basePackage    = 'base';
            $baseTheme      = 'default';
            $currentPackage = $this->config->get('theme.package');
            $defaultTheme   = $this->config->get('theme.theme.default');
            $currentTheme   = $this->config->get('theme.theme.current');

            $frontend->setResourceBaseUri($this->config->get('theme.frontend.base_url'));

            // Fallback to base theme
            if ($basePackage && $baseTheme) {
                $frontend->addPath("{$basePackage}/{$baseTheme}");
            }

            // Fallback to default theme if defined
            if ($currentPackage && $defaultTheme) {
                $frontend->addPath("{$currentPackage}/{$defaultTheme}");
            }
            
            if ($currentPackage && $currentTheme) {
                $frontend->addPath("{$currentPackage}/{$currentTheme}");
            }
            
            return $frontend;
        });
    }

    /**
     * Configure layout backend and output types
     */
    protected function configureElementTypes()
    {
        /** @var \Illuminate\Events\Dispatcher $eventDispatcher */
        $eventDispatcher = $this->app->make('Illuminate\Events\Dispatcher');
        
        $eventDispatcher->listen('layout.initialize.element.schema', function ($transport) {
            /** @var \Illuminate\Contracts\Config\Repository $config */
            $config = $this->app->make('Illuminate\Contracts\Config\Repository');
            $schema = $transport['schema'];

            foreach ($config['layout.element'] as $name => $elementConfig) {
                $schema[$name] = $elementConfig;
            }

            $transport['schema'] = $schema;
        });
    }
}
