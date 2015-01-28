<?php
/** {license_text}  */
namespace Theme\Element\Type;

use Layout\Element\Type\TypeAbstract;

class Text
    extends TypeAbstract
{
    /**
     * @return array
     * @throws \Layout\Element\Type\TypeException
     */
    protected function getPublicData()
    {
        return $this->fill(array(), $this, array(
            'text'
        ));
    }
}
