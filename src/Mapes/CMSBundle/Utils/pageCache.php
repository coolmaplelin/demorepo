<?php

namespace Mapes\CMSBundle\Utils;

use Mapes\CMSBundle\Entity\Page as Page;
use Mapes\CMSBundle\Entity\Redirect as Redirect;


class pageCache
{
    public static function makeSlug($folder = "", $phrase)
    {
            //Note that slugs become the FULL url of a page
            $maxLength = 100;
            $result = strtolower($phrase);
            $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
            $result = trim(preg_replace("/[\s-]+/", " ", $result));
            $result = trim(substr($result, 0, $maxLength));
            $result = preg_replace("/\s/", "-", $result);
            if($folder != "")
                    $result = strtolower($folder."/".$result);
            return $result;
    }
        
    public static function makeRedirect($from, $to)
    {
            if(trim($from) == "" || trim($to) == "")
                 return;

            
            $file = __DIR__."../../Resources/redirects/dynamic_redirects.txt";
            touch($file);
            $myFile = file($file);

            $writeString = "";
            $counter = 0;
            foreach($myFile as $myline)
            {
                        $line = explode(",", trim($myline) );
                        if(trim($line[0]) != "" && trim($line[0]) != $to && trim($line[0]) != $from)
                        {
                                if($counter++ > 0)
                                    $writeString .= "\n"; 
                                $writeString .= trim($line[0]).",".trim($line[1]);			
                        }


            }
            if($counter++ > 0)
                    $writeString .= "\n"; 
            $writeString .= $from.",".$to;


            $fh = fopen($file, 'w') or die("can't open file for redirects");
            fwrite($fh, $writeString);
            fclose($fh);
    }

   public static function getStaticRedirect($slug)
    {
        $myFile = __DIR__."../../Resources/redirects/static_redirects.txt";
        $myFile = file($myFile);

        $desnUrl = "";

        foreach($myFile as $myLine)
        {
                $myLine = explode(" ", $myLine);
                if("/".$slug == $myLine[0])
                {
                    $desnUrl = $myLine[1];
                    break;
                }
        }

        return $desnUrl;
    }
	
	public static function generateStaticRedirect($Redirects)
	{   
        $myFile = __DIR__."../../Resources/redirects/static_redirects.txt";
		
		
		$rtnString = "";
		foreach($Redirects as $redirect) {
			$rtnString .= $redirect->getOriginalUrl()." ".$redirect->getDestinationUrl()."
";
			
		}
		
		$fh = fopen($myFile, 'w') or die("can't open file ".$myFile);
		fwrite($fh, $rtnString);
		fclose($fh);
		
	}

    public static function getDynamicRedirect($prefix, $slug)
    {
        $myFile = __DIR__."../../Resources/redirects/dynamic_redirects.txt";
        $myFile = file($myFile);

        $desnUrl = "";

        foreach($myFile as $myLine)
        {
                $myLine = explode(",", $myLine);
                if($prefix.$slug == trim($myLine[0]))
                {
                            $desnUrl = "/". trim($myLine[1]);
                            break;
                }
        }

        return $desnUrl;
    }    
    
    public static function generateNameSelector($rootPages)
    {
        $myFile = __DIR__."../../Resources/views/Cache/parentpageselector.html.twig";
        $rtnString = "<ul><li><a href='#' origID='' origText='[None]'>[None]</a></li>";
        $rtnString .= self::getPageNamePrint($rootPages);
        $rtnString .= "</ul>";
        
        //echo $rtnString;die();
        touch($myFile);
        $fh = fopen($myFile, 'w') or die("can't open file ".$myFile);
        fwrite($fh, $rtnString);
        fclose($fh);
        
    }
    
    private static function getPageNamePrint($pages, $depth = 0){
        $rtnString = "";
        foreach($pages as $page){
                    $rtnString .= "<li>".self::printPageName($page->getId(), $page->getPageHeading());
                    $children = $page->getChildren();
                    if($children && count($children) > 0)
                    {
                            $rtnString .= "<ul>";
                            $rtnString .= self::getPageNamePrint($children, $depth++);
                            $rtnString .= "</ul>";
                    }
                    $rtnString .= "</li>";
        }
        
        return $rtnString;
    }
    
    private static function printPageName($id, $name) {
        //var_dump($page);
        //die();
        $rtnString = "<a href='#' origID='".$id."' origText=\"".htmlspecialchars(str_replace('"', '', $name))."\">".htmlspecialchars($name)."</a>";
        return $rtnString;
        
    }
    
    /*public static function generatePageTreeArray($rootPages, $exclude) {
        $rtnArray = self::getPageSubTreeArray($rootPages, $exclude);
        
        return $rtnArray;
    }
    
    private static function getPageSubTreeArray($pages, $exclude, $depth = 0) {
        $rtnArray = array();
        
        foreach($pages as $page){
            if($page->getId() != $exclude){
                    $page_heading = "";
                    for($i = 0; $i < $depth; $i++) {
                        $page_heading .= "----";
                    }
                    $page_heading .= " ".$page->getPageHeading();
                    $rtnArray[$page->getId()] = $page_heading;
                    $children = $page->getChildren();
                    if($children && count($children) > 0)
                    {
                            $rtnArray = array_merge($rtnArray, self::getPageSubTreeArray($children, $exclude, $depth+1));
                    }
            }
        }
        
        return $rtnArray;
    }*/
}

?>