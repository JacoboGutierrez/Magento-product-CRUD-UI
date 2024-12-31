<?php
namespace Compatibility\Manager\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Compatibility\Manager\Model\ResourceModel\Post');
	}
}
