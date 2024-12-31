<?php

namespace Compatibility\Manager\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AccessorySkuOptions implements OptionSourceInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Constructor
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * Returns optiones for the multiselect
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        // Get products from "Accesories" category
        $searchCriteria = $this->getSearchCriteriaForAccessories();
        $productList = $this->productRepository->getList($searchCriteria);

        foreach ($productList->getItems() as $product) {
            $options[] = [
                'value' => $product->getSku(),
                'label' => $product->getName() . ' (' . $product->getSku() . ')',
            ];
        }

        return $options;
    }

    /**
     * Generate search criteria to obtain the products inside "Accessories"
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    protected function getSearchCriteriaForAccessories()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $searchCriteriaBuilder = $objectManager->create(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $filterBuilder = $objectManager->create(\Magento\Framework\Api\FilterBuilder::class);

        // "Accessories" category has an ID of 3
        $categoryId = 3;

        $filter = $filterBuilder
            ->setField('category_id')
            ->setValue($categoryId)
            ->setConditionType('eq')
            ->create();

        $searchCriteria = $searchCriteriaBuilder
            ->addFilters([$filter])
            ->create();

        return $searchCriteria;
    }
}
