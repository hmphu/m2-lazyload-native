<?php
 
namespace HMP\LazyloadNative\Plugin;

use Closure;
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
     * Constructor.
     *
     * @param Helper $helper
     * @param RequestHttp $request
     */
    public function __construct(Helper $helper) {
        $this->helper = $helper;
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
        if(!empty($html)){
            return $this->helper->addLoadingAttribute($html, 'img');
        }
        return $html;
    }
}