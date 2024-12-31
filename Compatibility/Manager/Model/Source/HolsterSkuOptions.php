<?php

namespace Compatibility\Manager\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class HolsterSkuOptions implements OptionSourceInterface
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
     * Return the options for the selector
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        // Obtain products from "Holsters" category
        $searchCriteria = $this->getSearchCriteriaForHolsters();
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
     * Generate search criteria to obtain the products from "Holsters" category
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    protected function getSearchCriteriaForHolsters()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $searchCriteriaBuilder = $objectManager->create(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $filterBuilder = $objectManager->create(\Magento\Framework\Api\FilterBuilder::class);

        // "Holsters" category has an ID of 4
        $categoryId = 4;

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
