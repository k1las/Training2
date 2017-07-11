<?php
namespace Training2\Specific404Page\Setup;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var PageInterfaceFactory
     */
    private $pageInterfaceFactory;

    public function __construct(
            PageRepositoryInterface $pageRepository,
            PageInterfaceFactory $pageInterfaceFactory
    ) {
        $this->pageRepository = $pageRepository;
        $this->pageInterfaceFactory = $pageInterfaceFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createCmsPages();
    }

    /**
     * Create a CMS page
     */
    private function createCmsPages()
    {
        $product = $this->pageInterfaceFactory->create()
                ->setIdentifier('no-route-product')
                ->setTitle('Product 404')
                ->setContentHeading('Product 404')
                ->setContent('Product 404')
                ->setPageLayout('1column')
                ->setData('stores', [0]);

        $category =  $this->pageInterfaceFactory->create()
                ->setIdentifier('no-route-category')
                ->setTitle('Category 404')
                ->setContentHeading('Category 404')
                ->setContent('Category 404')
                ->setPageLayout('1column')
                ->setData('stores', [0]);

        $this->pageRepository->save($product);
        $this->pageRepository->save($category);
    }
}
