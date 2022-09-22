<?php
namespace Magetop\Helloworld\Block\Adminhtml\Posts\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Banner Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'post_info',
            [
                'label' => __('Banner'),
                'title' => __('Banner'),
                'content' => $this->getLayout()->createBlock(
                    'Magetop\Helloworld\Block\Adminhtml\Posts\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}