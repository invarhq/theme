<?php
/** {license_text}  */
namespace Theme\Element\Output\Html\Document;

use Theme\Element\Output\Html\HtmlAbstract;
use DOMDocument;
use DOMElement;

class Head 
    extends HtmlAbstract
{
    /** @var  DOMDocument */
    protected $dom;

    /**
     * @param $name
     * @return DOMElement
     */
    protected function createElement($name)
    {
        return $this->dom->createElement($name);
    }

    /**
     * @param DOMElement $element
     */
    protected function append(DOMElement $element)
    {
        $this->dom->appendChild($element);
        $this->dom->appendChild($this->dom->createTextNode("\n"));
    }
    
    public function initialize()
    {
        $this->setHiddenData('template', 'document/head.phtml');
        $this->dom  = new DOMDocument();
    }

    /**
     * Initialize page title tag
     */
    protected function initializeTitle()
    {
        if ($this['title']) {
            $title = $this->createElement('title');
            $title->nodeValue = $this->escapeHtml($this['title']);

            $this->append($title);
        }
    }

    /**
     * initialize javascript
     */
    protected function initializeMeta()
    {
        foreach ($this['meta'] as $metaData) {
            if (is_array($metaData) && !empty($metaData)) {
                $metaElement = $this->createElement('meta');
                foreach ($metaData as $key => $value) {
                    $metaElement->setAttribute($key, $this->escapeHtml($value));
                }
                $this->append($metaElement);
            }
        }
    }

    /**
     * initialize javascript
     */
    protected function initializeScripts()
    {
        $scripts = $this['scripts'] ?: [];
        
        foreach ($scripts as $scriptValue) {
            $script = $this->createElement('script');
            if (!is_array($scriptValue) && strlen($scriptValue) > 0) {
                $script->setAttribute('src', $this->frontend->resolveResourceUri($scriptValue));
            } else {
                foreach ($scriptValue as $key => $value) {
                    if ('content' == $key) {
                        $script->nodeValue = '//<![CDATA[' . PHP_EOL . $value . PHP_EOL . '//]]>';
                    } else {
                        if ('src' == $key) {
                            $script->setAttribute($key, $this->frontend->resolveResourceUri($value));
                        } else {
                            $script->setAttribute($key, $this->escapeHtml($value));
                        }
                        
                    }
                }
            }
            $this->append($script);
            
        }
    }

    /**
     * Initialize css styles
     */
    protected function initializeStyles()
    {
        $styles = $this['styles'] ?: [];
        
        $default = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'media' => 'all'
        );

        foreach ($styles as $styleValue) {
            $link = $this->createElement('link');
            if (is_array($styleValue)) {
                $styleValue = array_merge($default, $styleValue);
            } else if (strlen($styleValue) > 0) {
                $styleValue = array_merge($default, array(
                    'href' => $styleValue,
                ));
            }
            
            if (is_array($styleValue) && isset($styleValue['href'])) {
                foreach ($styleValue as $key => $value) {
                    if ('href' == $key) {
                        $link->setAttribute($key, $this->frontend->resolveResourceUri($value));
                    } else {
                        $link->setAttribute($key, $this->escapeHtml($value));
                    }
                }
                $this->append($link);
            }
        }
    }
    
    public function toHtml()
    {
        $this->initializeTitle();
        $this->initializeMeta();
        $this->initializeStyles();
        $this->initializeScripts();
        
        return $this->dom->saveHTML();
    }
}
