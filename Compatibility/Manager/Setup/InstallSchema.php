<?php
namespace Compatibility\Manager\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		/** fit_builded is the table name **/
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('fit_builded')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('fit_builded')
			)
				->addColumn(
					'fitbuild_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Post ID'
				)
				->addColumn(
					'name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Post Holster Name'
				)
				->addColumn(
					'holster_sku',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Post Holster SKU'
				)
				->addColumn(
					'compatible_sku',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'64k',
					[],
					'Post Accesory SKU'
				)
				->addColumn(
					'tags',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Post Tags'
				)
				->addColumn(
					'status',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					1,
					[],
					'Post Status'
				)
				->addColumn(
					'featured_image',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Post Featured Image'
				)
				->addColumn(
					'created_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
					'Created At'
				)->addColumn(
					'updated_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
					'Updated At')
				->setComment('Post Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('fit_builded'),
				$setup->getIdxName(
					$installer->getTable('fit_builded'),
					['name', 'holster_sku', 'compatible_sku', 'tags', 'featured_image'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['name', 'holster_sku', 'compatible_sku', 'tags', 'featured_image'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}
?>
