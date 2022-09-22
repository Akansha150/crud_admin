<?php
namespace Magetop\Helloworld\Controller\Adminhtml\Posts;

use Magetop\Helloworld\Controller\Adminhtml\Posts;

class Edit extends Posts
{
    /**
     * @return void
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');

        $model = $this->_postsFactory->create();

        if ($postId) {
            $model->load($postId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('banner_crud', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Magetop_Helloworld::helloworld_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner'));

        return $resultPage;
    }
}