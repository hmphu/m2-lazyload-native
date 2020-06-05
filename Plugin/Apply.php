<?php
 
namespace HMP\LazyloadNative\Plugin;

use Closure;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Controller\ResultInterface;
use HMP\LazyloadNative\Helper\Data as Helper;


class Apply
{
	/**
     * Helper
     *
     * @var Helper
     */
    private $helper;

	/**
     * Constructor.
     *
     * @param Helper $helper
     * @param RequestHttp $request
     */
    public function __construct(Helper $helper, RequestHttp $request) {
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * @param ResultInterface $subject
     * @param Closure $proceed
     * @param Http $response
     *
     * @return string
     */
    public function aroundRenderResult(
        ResultInterface $subject,
        Closure $proceed,
        Http $response
    ) {
        $result = $proceed($response);

        if (!$this->helper->isEnabled() || PHP_SAPI === 'cli' || $this->request->isXmlHttpRequest()) {
            return $result;
        }

        $this->helper->addLoadingAttribute($response, 'img');

        return $result;
    }
}