<?php
namespace Magetop\Helloworld\Block\Adminhtml\Posts\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Magetop\Helloworld\Model\System\Config\Status;

class Info extends Generic implements TabInterface
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @var \Magetop\Helloworld\Model\System\Config\Status
     */
    protected $_status;
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $status
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /** @var $model \Magetop\Helloworld\Model\PostsFactory */
        $model = $this->_coreRegistry->registry('banner_crud');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('post_');
        $form->setFieldNameSuffix('post');
        // new filed

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name'      => 'title',
                'label'     => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'image1',
            'image',
            array(
                'name' => 'image',
                'label' => __('Upload Image'),
                'title' => __('Image'),
                'required' => true,
                'note' => 'Allow image type: jpg, jpeg, png',
                


            )
        );
        $fieldset->addField(
            'image',
            'text',
            array(
                'name' => 'image',
                'label' => __('Upload Image'),
                'title' => __('Image'),
                'hidden'=>'true'
            )
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name'      => 'status',
                'label'     => __('Status'),
                'options'   => $this->_status->toOptionArray()
            ]
        );
        $fieldset->addField('description', 'editor', [
            'name'      => 'description',
            'label'   => 'Description',
//            'config'    => $this->_wysiwygConfig->getConfig(),
//            'wysiwyg'   => true,
            'required'  => true
        ]);
        $fieldset->addField(
            'start_date',
            'date',
            [
                'name' => 'start_date',
                'label' => __('Start_Time'),
                'title' => __('Time'),
                'singleClick'=> true,
                'date_format' => 'yyyy-MM-dd',
                'time'=>true,
                'class' => 'required-entry validate-date validate-date-range date-range-attribute-from',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'required'=>true

            ]

        );
        $fieldset->addField(
            'end_date',
            'date',
            [
                'name' => 'end_date',
                'label' => __('End_Time'),
                'title' => __('Time'),
                'singleClick'=> true,
                'date_format' => 'yyyy-MM-dd',
                'time'=>true,
                'class' => 'required-entry validate-date validate-date-range date-range-attribute-to',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'required'=>true
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);


        return parent::_prepareForm();
    }
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Posts Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Posts Info');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
