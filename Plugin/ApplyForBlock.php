<?php
 
namespace HMP\LazyloadNative\Plugin;

use Closure;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\View\Element\BlockInterface;
use HMP\LazyloadNative\Helper\Data as Helper;

class ApplyForBlock
{
	/**
     * Helper
     *
     * @var Helper
     */
    private $helper;

    /**
     * RequestHttp
     *
     * @var RequestHttp
     */
    private $request;

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
     * @param BlockInterface $subject
     * @param Closure $proceed
     *
     * @return string
     */
    public function aroundToHtml(BlockInterface $subject, Closure $proceed)
    {
        $html = $proceed();

        if (!$this->helper->isEnabled() || PHP_SAPI === 'cli' || $this->request->isXmlHttpRequest()) {
            return $html;
        }

        if(!empty($html)){
            return $this->helper->addLoadingAttribute($html, 'img');
        }
        return $html;
    }
}