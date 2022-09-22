<?php
namespace Magetop\Helloworld\Controller\Adminhtml\Posts;
use Magetop\Helloworld\Controller\Adminhtml\Posts;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends Posts
{
    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $flag = true;
            $postsModel = $this->_postsFactory->create();
            $postsId = $this->getRequest()->getParam('id');

            if ($postsId) {
                $postsModel->load($postsId);
            }
            $formData = $this->getRequest()->getParam('post');
            $postsModel->setData($formData);


            $profileImage = $this->getRequest()->getFiles('image');
            $fileName = ($profileImage && array_key_exists('name', $profileImage)) ? $profileImage['name'] : null;
            if ($fileName == null) {
                $fileName = $formData['image'];
                $flag = false;
                $fileArray=explode('.',$fileName);
                    if(!($fileArray[count($fileArray)-1]=='png'||$fileArray[count($fileArray)-1]=='jpg'||$fileArray[count($fileArray)-1]=='jpeg')){
                        $this->_redirect('*/*/edit', ['id' => $postsModel->getId(), '_current' => true]);
                        $this->messageManager->addError(__('File type should be PNG, JPG or JPEG.'));
                        return;
                    };
                $postsModel->save();
                $this->messageManager->addSuccess(__('The banner has been saved.'));
                $this->_redirect('*/*/');
                return;
                }
                if ($profileImage && $fileName && $flag) {
                    try {
                        /** @var \Magento\Framework\ObjectManagerInterface $uploader */
                        $uploader = $this->_objectManager->create(
                            'Magento\MediaStorage\Model\File\Uploader',
                            ['fileId' => 'image']
                        );
                        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                        /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapterFactory */
                        $imageAdapterFactory = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')
                            ->create();
//                    $uploader->setAllowRenameFiles(true);
//                    $uploader->setFilesDispersion(true);
                        $uploader->setAllowCreateFolders(true);
                        /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                        $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                            ->getDirectoryRead(DirectoryList::MEDIA);

                        $result = $uploader->save(
                            $mediaDirectory
                                ->getAbsolutePath('Helloworld/Profile')
                        );
                        $data['profile'] = 'Helloworld/Profile' . $result['file'];
                        //Database field name

                        $postsModel->setData('image', $fileName);
                        // Save news
                        $postsModel->save();

                        // Display success message
                        $this->messageManager->addSuccess(__('The banner has been saved.'));

                        // Check if 'Save and Continue'
                        if ($this->getRequest()->getParam('back')) {
                            $this->_redirect('*/*/edit', ['id' => $postsModel->getId(), '_current' => true]);
                            return;
                        }

                        // Go to grid page        }

                        $this->_redirect('*/*/');
                        return;
                    } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                        $this->messageManager->addError($e->getMessage());
                    }
                }
                $this->_getSession()->setFormData($formData);
                $this->_redirect('*/*/edit', ['id' => $postsId]);
            }
        }
}
