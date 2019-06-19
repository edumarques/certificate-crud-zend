<?php
namespace Certificate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Certificate\Model\CertificateTable;
use Certificate\Form\CertificateForm;
use Certificate\Model\Certificate;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Certificate\Form\UpdatePriceForm;
use Zend\Form\FormInterface;
use Certificate\Model\BonusCertificate;
use Certificate\Model\GuaranteeCertificate;

class CertificateController extends AbstractActionController
{

    private $table;

    private $logger;

    public function __construct(CertificateTable $table)
    {
        $this->table = $table;
        $this->logger = new Logger();
        $this->logger->addWriter(new Stream('certificatesApp.log'));
    }

    public function indexAction()
    {
        return new ViewModel([
            'certificates' => $this->table->fetchAll()
        ]);
    }

    public function viewHtmlAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }

        try {
            $certificate = $this->table->getCertificate($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }

        return [
            'certificate' => $certificate
        ];
    }

    public function viewXmlAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id === 0) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }
        
        try {
            $certificate = $this->table->getCertificate($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }
        
        return [
            'certificate' => $certificate
        ];
    }

    public function createAction()
    {
        $form = new CertificateForm();
        $form->get('submit')->setValue('Create');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return [
                'form' => $form
            ];
        }

        $certificate = new Certificate();
        $form->setInputFilter($certificate->getInputFilter());

        $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

        $form->setData($post);

        if (! $form->isValid()) {
            return [
                'form' => $form
            ];
        }
                
        $data = $form->getData();
        
        switch ($data['type']) {
            case 'certificate':
                $certificate = new Certificate();
                break;
            case 'bonusCertificate':
                $certificate = new BonusCertificate();
                break;
            case 'guaranteeCertificate':
                $certificate = new GuaranteeCertificate();
                break;
        }

        $certificate->exchangeArray($data); 
        $this->table->saveCertificate($certificate);
        return $this->redirect()->toRoute('certificate');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('certificate');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCertificate($id);
            }

            return $this->redirect()->toRoute('certificate');
        }

        return [
            'id' => $id,
            'certificate' => $this->table->getCertificate($id)
        ];
    }

    public function downloadAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('certificate');
        }
        
        try {
            $certificate = $this->table->getCertificate($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }
        $file = getcwd().'/public'.$certificate->getAdditionalDocument();
        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }
    
    public function updatePriceAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id === 0) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'create'
            ]);
        }
        
        try {
            $certificate = $this->table->getCertificate($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('certificate', [
                'action' => 'index'
            ]);
        }
        
        $form = new UpdatePriceForm();
        $form->bind($certificate);
        $form->get('submit')->setAttribute('value', 'Update');
        
        $request = $this->getRequest();
        $viewData = [
            'id' => $id,
            'form' => $form
        ];
        
        if (! $request->isPost()) {
            return $viewData;
        }
        
        $form->setInputFilter($certificate->getInputFilter());        
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return $viewData;
        }
        
        $data = $form->getData(FormInterface::VALUES_AS_ARRAY);
                
        $certificate->setCurrentPrice($data['currentPrice']);
        $certificate->setPriceHistory($certificate->getPriceHistory() . ',' . $data['currentPrice']);        
        
        $this->table->saveCertificate($certificate);
        
        return $this->redirect()->toRoute('certificate', [
            'action' => 'index'
        ]);
    }
}

