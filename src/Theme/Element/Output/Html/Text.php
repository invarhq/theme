<?php
/** {license_text}  */

namespace Theme\Element\Output\Html;

class Text
    extends HtmlAbstract
{
    /**
     * @return $this|mixed
     */
    public function toHtml()
    {
        return $this['text'];
    }
}
