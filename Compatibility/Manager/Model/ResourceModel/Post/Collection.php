<?php
namespace Compatibility\Manager\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Compatibility\Manager\Model\Post', 'Compatibility\Manager\Model\ResourceModel\Post');
	}

}
