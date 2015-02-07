<?php
/** {license_text}  */
namespace Theme\Element\Type;

use Layout\Element\Type\DataTransportProtected;
use Layout\Element\Type\DataTransportPublic;
use Layout\Element\Type\TypeAbstract;

class Text
    extends TypeAbstract
{
    /**
     * @param DataTransportPublic $publicData
     * @param DataTransportProtected $protectedData
     * @return mixed|void
     */
    protected function process(DataTransportPublic $publicData, DataTransportProtected $protectedData)
    {
        $publicData['text'] = $protectedData['text'];
    }
}
