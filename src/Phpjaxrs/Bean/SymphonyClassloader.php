<?php

namespace Phpjaxrs\Bean;
use zpt\anno\Annotations;
/**
 * Description of SymphonyClassloader
 *
 * @author admin
 */
class SymphonyClassloader implements IBeanParser
{

	/**
	 * current classloader
	 * 
	 * @var \Symfony\Component\ClassLoader\UniversalClassLoader
	 */
	private $classLoader;

	public function __construct(\Symfony\Component\ClassLoader\UniversalClassLoader $classLoader)
	{
		$this->classLoader = $classLoader;
	}

	/**
	 * parses all the registered namespaces of the classloader and returns a list of classes that implements the REST interface
	 * 
	 * @return \ArrayObject
	 */
	public function getBeans()
	{
		$beans = new \ArrayObject();
		$aPrefixes = $this->classLoader->getPrefixes();
		$aNamespaces = $this->classLoader->getNamespaces();
		$dirsToParse = new \ArrayObject();
		foreach ($aPrefixes as $dirs) {
			foreach ($dirs as $dir) {
				$dirsToParse->append($dir);
			}
		}

		foreach ($aNamespaces as $dirs) {
			foreach ($dirs as $dir) {
				$dirsToParse->append($dir);
			}
		}

		$iterator = $dirsToParse->getIterator();
		while ($iterator->valid()) {
			$this->parseFolder($iterator->current(), $beans);
			$iterator->next();
		}
		
		return $beans;
	}
	
	private function parseFolder($sFolderPath, \ArrayObject $beans)
	{
			$directoryHandler = opendir($sFolderPath);
			if (!$directoryHandler) {
				throw new \Exception("Can not open prefix folder " . $sFolderPath);
			}

			while (($sFileName = readdir($directoryHandler)) !== false) {
				
				if($sFileName == '.' || $sFileName == '..')
				{
					continue;
				}
				
				$sCurrentItemPath = $sFolderPath. DIRECTORY_SEPARATOR . $sFileName;
				
				if(is_dir($sCurrentItemPath))
				{
					$this->parseFolder($sCurrentItemPath, $beans);
					continue;
				}				
				
				$aPathInfo = pathinfo($sCurrentItemPath);
				$sClassName = $aPathInfo['filename'];

				include_once $sCurrentItemPath;
				$sClassName = 'Fixtures\\Bean\\'.$sClassName;
				//$reflection = new \ReflectionAnnotatedClass($sClassName);
				$annotations = new Annotations(new \ReflectionClass($sClassName));
				if (isset($annotations['Path'])) {
					$beans->append(new BeanContainer($sClassName));
				}
			}

			closedir($directoryHandler);		
	}

}
