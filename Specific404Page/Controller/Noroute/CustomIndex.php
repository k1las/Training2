<?php

namespace Training2\Specific404Page\Controller\Noroute;

use Magento\Cms\Controller\Noroute\Index;

class CustomIndex extends Index
{
    /**
     * @return bool|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $pageId = $this->_objectManager->get(
                'Magento\Framework\App\Config\ScopeConfigInterface',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )->getValue(
                \Magento\Cms\Helper\Page::XML_PATH_NO_ROUTE_PAGE,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($this->isCategoryRequest() !== false) {
            $pageId = 'no-route-category';
        }
        if ($this->isProductRequest() !== false) {
            $pageId = 'no-route-product';
        }
        /** @var \Magento\Cms\Helper\Page $pageHelper */
        $pageHelper = $this->_objectManager->get('Magento\Cms\Helper\Page');
        $resultPage = $pageHelper->prepareResultPage($this, $pageId);
        if ($resultPage) {
            $resultPage->setStatusHeader(404, '1.1', 'Not Found');
            $resultPage->setHeader('Status', '404 File not found');
            return $resultPage;
        } else {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');
            return $resultForward;
        }
    }

    /**
     * @return int
     */
    protected function isCategoryRequest()
    {
        return stripos($this->getRequest()->getPathInfo(), '/catalog/category/view/id/');
    }

    /**
     * @return int
     */
    protected function isProductRequest()
    {
        return stripos($this->getRequest()->getPathInfo(), '/catalog/product/view/id/');
    }
}
