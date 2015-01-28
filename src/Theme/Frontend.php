<?php
/** {license_text}  */
namespace Theme;

use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;

use League\Flysystem\Filesystem;
use Zend\Uri\UriFactory;
use Zend\Uri\Uri;

class Frontend
{
    protected $request;
    protected $urlGenerator;
    protected $filesystem;
    protected $resourceBaseUri = '';
    protected $staticPaths = array();

    /**
     * @param UrlGenerator $urlGenerator
     * @param Filesystem $filesystem
     * @param Request $request
     */
    public function __construct(UrlGenerator $urlGenerator, Filesystem $filesystem, Request $request)
    {
        $this->urlGenerator = $urlGenerator;
        $this->filesystem   = $filesystem;
        $this->request      = $request;
    }

    /**
     * @param string $baseUri
     */
    public function setResourceBaseUri($baseUri)
    {
        $this->resourceBaseUri = trim($baseUri, '/') . '/';
    }

    /**
     * @param string $path
     */
    public function addPath($path)
    {
        array_unshift($this->staticPaths, $path);
    }

    /**
     * @param string|Uri $uri
     * @return string
     */
    protected function prepareUri($uri)
    {
        if (!$uri instanceof Uri) {
            $uri = UriFactory::factory($uri);
        }

        $uri->setScheme($this->request->getScheme());

        return $uri->toString();
    }

    /**
     * Alias for resolveResourceUri
     * 
     * @param $uri
     * @return string
     */
    public function getResourceUrl($uri)
    {
        return $this->resolveResourceUri($uri);
    }

    /**
     * @param $uri
     * @return string
     */
    public function resolveResourceUri($uri)
    {
        $isGlobal = preg_match('/^([A-Za-z][A-Za-z0-9\-\.+]*\:\/\/|\/\/)/', $uri);
        if ($isGlobal) {
            return $this->prepareUri($uri);
        }
        
        return $this->resolveLocalResourceUri($uri);
    }

    /**
     * @param $resourcePath
     * @return string
     */
    protected function resolveLocalResourceUri($resourcePath)
    {
        foreach ($this->staticPaths as $pathPrefix) {
            if ($this->filesystem->has("{$pathPrefix}/{$resourcePath}")) {
                return $this->prepareUri($this->resourceBaseUri . "{$pathPrefix}/{$resourcePath}");
            }
        }

        return '';
    }

    /**
     * @param $path
     * @param array $params
     * @param null $secure
     * @return string
     */
    public function getUrl($path, array $params = [], $secure = null)
    {
        return $this->urlGenerator->to($path, $params, !is_null($secure) ? $secure : $this->request->isSecure());
    }
}
