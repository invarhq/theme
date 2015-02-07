<?php
/** {license_text}  */

namespace Theme\Element\Output\Html;

class Template
    extends HtmlAbstract
{
    /**
     * @return $this|mixed|string
     */
    public function toHtml()
    {
        $output = '';
        if ($template = $this->getProtectedAttribute('template')) {
            $template = $this->backend->resolveTemplatePath($template);
            if ($template) {
                ob_start();
                require $template;
                $output = ob_get_clean();
            }
        }

        return $output;
    }
}
