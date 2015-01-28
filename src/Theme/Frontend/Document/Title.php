<?php
/** {license_text}  */ 
namespace Theme\Frontend\Document;

use Core\Support\Singleton;

class Title
{
    use Singleton;
    
    protected $title;

    /**
     * @param $value
     */
    public function set($value)
    {
        $this->title = $value;
    }

    /**
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }
}
