<?php
/** {license_text}  */
namespace Theme\Element\Type\Document;

use Layout\Element\Type\TypeAbstract;
use Theme\Frontend\Document\Meta;
use Theme\Frontend\Document\Title;

class Head
    extends TypeAbstract
{
    /** @var  Meta */
    protected $meta;
    /** @var  Title */
    protected $title;
    
    public function initialize(Meta $meta, Title $title)
    {
        $this->meta  = $meta;
        $this->title = $title;
    }
    
    /**
     * @return array
     * @throws \Layout\Element\Type\TypeException
     */
    protected function getPublicData()
    {
        $data = $this->fill(array(), $this, array(
            'scripts',
            'styles',
        ));

        $data['title'] = $this->title->getTitle() ?: $this->get('title');
        $data['meta']  = $this->meta->getData();

        if (is_array($this->get('meta'))) {
            foreach ($this->get('meta') as $metaData) {
                if (is_array($metaData)) {
                    $data['meta'][] = $metaData;
                }
            }
        }
        
        return $data;
    }
}
