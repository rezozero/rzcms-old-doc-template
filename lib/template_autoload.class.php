<?php 
/**
 * Copyright REZO ZERO 2013
 * 
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License. 
 * 
 * Ce(tte) œuvre est mise à disposition selon les termes
 * de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Pas de Modification 3.0 France.
 *
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/3.0/
 * or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 * 	
 *
 * @file autoload.class.php
 * @copyright REZO ZERO 2013
 * @author Ambroise Maupate
 */
define('TEMPLATE_LIB_FOLDER', dirname(__FILE__));


template_autoload::register();

/**
* autoload
*/
class template_autoload
{
	public static $templatePrefix = 'doc';

	public static function register()
	{
		return spl_autoload_register(array(__CLASS__, 'includeClass'));
	}

	public static function unregisterAutoload()
    {
        return spl_autoload_unregister(array(__CLASS__, 'includeClass'));
    }
    
    public static function includeClass($classname)
    {
        if (strpos($classname, static::$templatePrefix.'_') !== false) 
        {
			if (file_exists(TEMPLATE_LIB_FOLDER.'/'.$classname.'.class.php')) {
				require_once(TEMPLATE_LIB_FOLDER.'/'.$classname.'.class.php');
			}
		}
    }
}
 ?>