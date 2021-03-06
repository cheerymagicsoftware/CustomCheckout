<?php

namespace CheeryMagic\CustomCheckout\Plugin\Magento\Checkout\Controller;

class Action
{
    /**
     * @param \Magento\Checkout\Controller\Action $subject
     * @param \Magento\Framework\App\RequestInterface $request
     */

    public function beforeDispatch(
        \Magento\Checkout\Controller\Action $subject,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $uri = \CheeryMagic\CustomCheckout\Plugin\Helper::getArrayPathInfo($request->getPathInfo());
        $parseUri = parse_url($request->getRequestUri());
        $query = isset($parseUri['query']) ? '?' . $parseUri['query'] : '';

        if (count($uri) == 1 && $uri[0] == 'checkout') {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $responseFactory = $objectManager->get('\Magento\Framework\App\ResponseFactory');
            $url = $objectManager->get('Magento\Framework\UrlInterface');
            $responseFactory->create()->setRedirect(
                $url->getUrl('customcheckout' . $query
                ))->sendResponse();
            exit();
        }

    }
}
