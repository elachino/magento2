<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Reports
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Reports\Block\Product;

/**
 * Reports Recently Viewed Products Block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Viewed extends \Magento\Reports\Block\Product\AbstractProduct implements \Magento\View\Block\IdentityInterface
{
    const XML_PATH_RECENTLY_VIEWED_COUNT = 'catalog/recently_products/viewed_count';

    /**
     * Viewed Product Index type
     *
     * @var string
     */
    protected $_indexType = \Magento\Reports\Model\Product\Index\Factory::TYPE_VIEWED;

    /**
     * Retrieve page size (count)
     *
     * @return int
     */
    public function getPageSize()
    {
        if ($this->hasData('page_size')) {
            return $this->getData('page_size');
        }
        return $this->_scopeConfig->getValue(self::XML_PATH_RECENTLY_VIEWED_COUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Added predefined ids support
     *
     * @return int
     */
    public function getCount()
    {
        $ids = $this->getProductIds();
        if (!empty($ids)) {
            return count($ids);
        }
        return parent::getCount();
    }

    /**
     * Prepare to html
     * check has viewed products
     *
     * @return string
     */
    protected function _toHtml()
    {
        $this->setRecentlyViewedProducts($this->getItemsCollection());
        return parent::_toHtml();
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = array();
        foreach ($this->getItemsCollection() as $item) {
            $identities = array_merge($identities, $item->getIdentities());
        }
        return $identities;
    }
}
