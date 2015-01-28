<?php
/** {license_text}  */
namespace Theme\Element\Output\Html;

use Theme\Backend;
use Theme\Frontend;

abstract class HtmlAbstract
    extends \Layout\Element\Output\Html\HtmlAbstract
{
    /** @var  Backend */
    protected $backend;
    /** @var  Frontend */
    protected $frontend;

    /**
     * For dependency initialization use you can define initialize() method
     * 
     * @param Backend $backend
     * @param Frontend $frontend
     */
    final public function __construct(Backend $backend, Frontend $frontend)
    {
        $this->backend  = $backend;
        $this->frontend = $frontend;
    }

    /**
     * @param $path
     * @param array $params
     * @return string
     */
    public function getUrl($path, array $params = [])
    {
        return $this->frontend->getUrl($path, $params);
    }

    /**
     * @param $resourcePath
     * @return string
     */
    public function getResourceUrl($resourcePath)
    {
        return $this->frontend->getResourceUrl($resourcePath);
    }

    /**
     * @param string $value
     * @return string
     */
    public function escapeHtml($value)
    {
        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false);
    }
}
