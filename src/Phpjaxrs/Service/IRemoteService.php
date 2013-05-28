<?php
namespace Phpjaxrs\Service;
use Phpjaxrs\Bean\BeanContainer;
/**
 *
 * @author admin
 */
interface IRemoteService
{
	public function rpcBean(BeanContainer $container);
}
