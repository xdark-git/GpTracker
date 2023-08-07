<?php

namespace Viewpoint\ThemeBundle\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class ThemeResolver 
{
    private string $themePathPrefix;

    public function __construct (ParameterBagInterface $parameterBag)
    {   
        
        $theme = array_key_exists('THEME_PATH_PREFIX',$_ENV) ? "/". $_ENV['THEME_PATH_PREFIX'] : null;
       
        if($theme && $theme != "/"){
            $fileSystem = new Filesystem();

            $themePath = $parameterBag->get('twig.default_path') .$theme;

            if($fileSystem->exists($themePath))
                $this->themePathPrefix = $theme;
            else
                $this->themePathPrefix = "@ViewpointTheme";
        }else{
            $this->themePathPrefix = "@ViewpointTheme";
        }
    }

    /**
     *  Get the file path 
     * @param string $twigFile
     * @return string
    */
    public function getThemePathPrefix(string $twigFile) : string
    {
        if($this->themePathPrefix === "@ViewpointTheme")
            return $this->themePathPrefix."/core/default.html.twig";
        else
            return $this->themePathPrefix . $twigFile;
    }

    /**
     *  Set the value of the theme path prefix
     *  @return self
     */

    public function setThemePathPrefix(string $themePathPrefix): self
    {
        $this->themePathPrefix = $themePathPrefix;

        return $this;
    }
}