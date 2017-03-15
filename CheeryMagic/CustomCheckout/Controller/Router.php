<?php

namespace CheeryMagic\CustomCheckout\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{

    /**
     * @var \Magento\Framework\App\ActionFactory
     */

    protected $actionFactory;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     */

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory
    )
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {

        $uri = \CheeryMagic\CustomCheckout\Plugin\Helper::getArrayPathInfo($request->getPathInfo());

        $route = [];
        if (
            count($uri) == 2 &&
            ($uri[0] == 'checkout' && $uri[1] == 'cart' || $uri[0] == 'customcheckout' && $uri[1] == 'basket')
        ) {
            $route = [
                'module' => 'checkout',
                'controller' => 'cart',
                'action' => 'index'
            ];
        }
        if (count($uri) == 1 && ($uri[0] == 'checkout' || $uri[0] == 'customcheckout')) {
            $route = [
                'module' => 'checkout',
                'controller' => 'index',
                'action' => 'index'
            ];
        }

        if (!empty($route)) {
            $module = $request->setModuleName($route['module']);
            $module->setControllerName($route['controller'])->setActionName($route['action']);
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $uri);

            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        } else {
            return null;
        }

    }

}