<?php
namespace Magetop\Helloworld\Controller\Adminhtml\Posts;

use Magetop\Helloworld\Controller\Adminhtml\Posts;

class NewAction extends Posts
{
    /**
     * Create new news action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}