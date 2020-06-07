<?php

namespace HMP\LazyloadNative\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use DOMDocument;


/**
 * Class Data
 */
class Data extends AbstractHelper
{
    /**
     * Configuration paths
     */
    const XML_LAZYLOADNATIVE_ENABLED = 'system/lazyload_native/enabled';

    /**
     * @param string $scopeType
     * @param null|string $scopeCode
     *
     * @return bool
     */
    public function isEnabled(
        string $scopeType = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): bool {
        return $this->scopeConfig->isSetFlag(
            self::XML_LAZYLOADNATIVE_ENABLED,
            $scopeType,
            $scopeCode
        );
    }

    public function addLoadingAttribute($html, $tag = 'img'){
        if(!empty($html)){
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $tags = $doc->getElementsByTagName($tag);
            foreach ($tags as $tag) {
                if(!$tag->hasAttribute('loading')){
                    $tag->setAttribute('loading', 'lazy');
                }
            }
            $html = $doc->saveHTML();
        }
        return $html;
    }
}

