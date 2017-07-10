<?php

namespace Training2\OrderController\Controller\Json;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Order
 *
 * @package Training2\OrderController\Controller\Json
 */
class Order extends Action
{
    /**
     * @var OrderRepositoryInterface
     */
    private $order;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    public function __construct(Context $context, OrderRepositoryInterface $order, JsonFactory $resultJsonFactory)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->order = $order;
        parent::__construct($context);
    }

    /**
     *Execute
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('orderId');
        $response = [];
        if ($orderId) {
            $order = $this->order->get($orderId);
            $response = $this->_formatResponse($order);
        }

        return $this->resultJsonFactory->create()
                ->setData($response);
    }

    /**
     * @param $order
     * @return array
     */
    protected function _formatResponse($order)
    {
        $response = [];
        if ($order->getId()) {
            $response['status'] = $order->getId();
            $response['tatal'] = $order->getGrandTotal();
            $response['items'] = $this->_formatItems($order);
            $response['total_invoiced'] = $order->getTotalInvoiced();
        }
        return $response;
    }

    /**
     * @param $order
     * @return array
     */
    protected function _formatItems($order)
    {
        $items = [];
        foreach ($order->getItems() as $item) {
            array_push($items, [
                    'item_id' => $item->getItemId(),
                    'sku' => $item->getSku(),
                    'price' => $item->getPrice()
            ]);
        }
        return $items;
    }
}
