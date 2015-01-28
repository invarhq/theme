<?php
/** {license_text}  */ 
namespace Theme;

use Illuminate\Contracts\Container\Container;
use League\Flysystem\Filesystem;

class FilesystemFactory
{
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $config
     * @return Filesystem
     * @throws FilesystemFactoryException
     */
    public function makeFilesystem(array $config)
    {
        $adapter = null;
        switch ($config['driver']) {
            case 'local':
                $adapter = new \League\Flysystem\Adapter\Local($config['path']);
                break;
        }
        
        if (is_null($adapter)) {
            throw new FilesystemFactoryException('Driver "%s" not supported', $config['adapter']);
        }
        
        return new Filesystem($adapter);
    }
}

