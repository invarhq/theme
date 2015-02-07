<?php
/** {license_text}  */
namespace Theme\Element\Type\Document;

use Layout\Element\Type\DataTransportProtected;
use Layout\Element\Type\DataTransportPublic;
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

    public function __construct(Meta $meta, Title $title)
    {
        $this->meta  = $meta;
        $this->title = $title;
    }

    /**
     * @param array $metaConfig
     * @return array
     */
    protected function prepareMeta(array $metaConfig)
    {
        $result = [];
        foreach ($metaConfig as $metaData) {
            if (is_array($metaData)) {
                $result[] = $metaData;
            }
        }
        
        return $result;
    }

    /**
     * @param DataTransportPublic $publicData
     * @param DataTransportProtected $protectedData
     * @return mixed|void
     */
    protected function process(DataTransportPublic $publicData, DataTransportProtected $protectedData)
    {
        if (is_array($protectedData['meta'])) {
            foreach ($protectedData['meta'] as $meta) {
                $this->meta->add($meta);
            }
        }
        
        $publicData->setAttributes(array(
            'title'   => $this->title->getTitle() ?: $protectedData['title'],
            'meta'    => $this->prepareMeta($this->meta->getData()),
            'scripts' => $protectedData['scripts'],
            'styles'  => $protectedData['styles'],
        ));
    }
}
