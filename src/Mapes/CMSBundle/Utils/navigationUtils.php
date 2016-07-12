<?php

namespace Mapes\CMSBundle\Utils;

use Mapes\CMSBundle\Entity\Navigation as Navigation;

class navigationUtils
{
    public static function cacheGenerate($location, $parentNavElements, $childNavElements)
    {
        $myFile = __DIR__."/../Resources/views/Cache/nav$location.html.twig";
        
        $rtnString = "";
        
        if($location == "TOP" ){
            //$rtnString = '<ul id="nav" class="nav-bar">';
            
            for($i = 0; $i < count($parentNavElements); $i++) {
                $rtnString .= '<li>';
                $rtnString .= "<a class='page-scroll' href='".$parentNavElements[$i]->getNavLink()."'>".strip_tags($parentNavElements[$i]->getAnchorText())."</a>";
                $rtnString .= '</li>';
            }
            
            //$rtnString .= '</ul>';
        }elseif($location == 'FOOTER') {
			for($i = 0; $i < count($parentNavElements); $i++) {
                $rtnString .= '<li>';
                $rtnString .= "<a href='".$parentNavElements[$i]->getNavLink()."'>".strip_tags($parentNavElements[$i]->getAnchorText())."</a>";
                $rtnString .= '</li>';
            }
		}
        
        
        touch($myFile);
        $fh = fopen($myFile, 'w') or die("can't open file ".$myFile);
        fwrite($fh, $rtnString);
        fclose($fh);        
    }
}

?>