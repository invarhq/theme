<?php
/** {license_text}  */
namespace Theme;
 
class Backend
{
    protected $templatePath = array();
    
    /**
     * @param string $path
     * @return $this
     */
    public function addTemplatePath($path)
    {
        if (is_dir($path)) {
            array_unshift($this->templatePath, $path);
        }
        

        return $this;
    }

    /**
     * @param string $fileName
     * @return bool|string
     */
    public function resolveTemplatePath($fileName)
    {
        foreach ($this->templatePath as $path) {
            $filePath = "{$path}/{$fileName}";
            if (is_file($filePath) && is_readable($filePath)) {
                return realpath($filePath);
            }
        }

        return false;
    }
}
