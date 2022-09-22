<?php
namespace Magetop\Helloworld\Controller\Adminhtml\Posts;

use Magetop\Helloworld\Controller\Adminhtml\Posts;

class Delete extends Posts
{
    public function execute()
    {
        $postId = (int) $this->getRequest()->getParam('id');

        if ($postId) {
            /** @var $postModel /Magetop/Helloworld/Model/Posts */
            $postModel = $this->_postsFactory->create();
            $postModel->load($postId);

            // Check this news exists or not
            if (!$postModel->getId()) {
                $this->messageManager->addError(__('This news no longer exists.'));
            } else {
                try {
                    // Delete news
                    $postModel->delete();
                    $this->messageManager->addSuccess(__('The news has been deleted.'));

                    // Redirect to grid page
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $postModel->getId()]);
                }
            }
        }
    }
}