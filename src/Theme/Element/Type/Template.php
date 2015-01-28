<?php
/** {license_text}  */
namespace Theme\Element\Type;

use Layout\Element\Type\TypeAbstract;

class Template
    extends TypeAbstract
{
    /**
     * @return array
     * @throws \Layout\Element\Type\TypeException
     */
    protected function getHiddenData()
    {
        return $this->fill(array(), $this, array(
            'template'
        ));
    }
}
