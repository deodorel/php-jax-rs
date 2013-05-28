<?php
namespace Phpjaxrs\Bean;
use \ReflectionClass;
use zpt\anno\Annotations;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BeanContainer
 *
 * @author admin
 */
class BeanContainer
{
	const PATH_ANNOTATION = 'Path';
	
	const GET_ANNOTATION = 'GET';
	const PUT_ANNOTATION = 'PUT';
	const POST_ANNOTATION = 'POST';
	const DELETE_ANNOTATION = 'DELETE';
	
	
	private $sClassName;
	private $sBasePath;
	private $aCallMap = array();
	public function __construct($sClassName)
	{
		$this->sClassName = $sClassName;
		$this->parseBean();
	}
	
	private function parseBean()
	{
		$classReflection = new ReflectionClass($this->sClassName);
		$aClassAnnotations = new Annotations($classReflection);
		
		if(!isset($aClassAnnotations[self::PATH_ANNOTATION]))
		{
			throw new Exception("Class ".$this->sClassName.' has no Path annotation');
		}
		
		if(is_string($aClassAnnotations[self::PATH_ANNOTATION]))
		{
			$this->sBasePath = $aClassAnnotations[self::PATH_ANNOTATION];
		} else {
			$this->sBasePath = $classReflection->getShortName();
		}
		
		$aMethods = $classReflection->getMethods();
		foreach($aMethods as $methodReflection)
		{
			$methodAnnotations = new Annotations($methodReflection);
			if(isset($methodAnnotations[self::GET_ANNOTATION]))
			{
				$this->aCallMap[self::GET_ANNOTATION] = $methodReflection->name;
			}
			
			if(isset($methodAnnotations[self::PUT_ANNOTATION]))
			{
				$this->aCallMap[self::PUT_ANNOTATION] = $methodReflection->name;
			}

			if(isset($methodAnnotations[self::POST_ANNOTATION]))
			{
				$this->aCallMap[self::POST_ANNOTATION] = $methodReflection->name;
			}

			
			if(isset($methodAnnotations[self::DELETE_ANNOTATION]))
			{
				$this->aCallMap[self::DELETE_ANNOTATION] = $methodReflection->name;
			}
			
		}
	}
	
	public function getBasePath()
	{
		return $this->sBasePath;
	}
	
	public function callMethod($sMethod, \ArrayObject $params)
	{
		
	}
}
