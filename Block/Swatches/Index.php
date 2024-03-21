<?php

namespace MK\CustomSwatches\Block\Swatches;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template\Context as TemplateContext;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $scopeConfig;
    protected $storeManager;
    
    public function __construct(
            TemplateContext $context, 
            ScopeConfigInterface $scopeInterface, 
            StoreManagerInterface $storeManager, 
            array $data = []
    ){
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeInterface;
        $this->storeManager = $storeManager;
    }

    public function getOptionSwatches(){
        return $this->parseSwatches($this->scopeConfig->getValue('customswatches/general/option_swatches', ScopeInterface::SCOPE_STORE));
    }
    
    public function getEnable(){
        return $this->scopeConfig->getValue('customswatches/general/enable', ScopeInterface::SCOPE_STORE);
    }

    protected function parseSwatches($s){
        $swatches = array();
        if ($s) {
            if (preg_match_all("/^(.*)\:(.*)=(.*)$/m", $s, $m, PREG_SET_ORDER)) {
                foreach ($m as $_ln)
                    $swatches[] = array(
                        'key' => trim($_ln[1]),
                        'value' => trim($_ln[2]),
                        'img' => trim($_ln[3])
                    );
            }
        }
        return $swatches;
    }

    public function getMediaUrl(){
        $mediaUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

}