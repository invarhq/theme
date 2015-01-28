<?php
/** {license_text}  */ 
namespace Theme\Frontend\Document;

use Core\Support\Singleton;

class Meta
{
    use Singleton;
    
    protected $title;
    protected $meta = array();

    /**
     * @param array $data
     */
    public function add(array $data)
    {
        $this->meta[] = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->meta;
    }
}
