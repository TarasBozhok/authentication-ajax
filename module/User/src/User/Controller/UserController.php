<?php
namespace User\Controller;

use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\User;
use User\Model\RegUser;
use User\Form\UserForm;


/**
 * Class UserController
 * @package User\Controller
 */
class UserController extends AbstractActionController
{
    protected $userTable;

    protected $form;

    protected $storage;

    protected $authservice;


    /**
     * @return array|object
     */
    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()
                ->get('AuthService');
        }

        return $this->authservice;
    }


    /**
     * @return array|object
     */
    public function getSessionStorage()
    {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()
                ->get('User\Model\AuthStorage');
        }

        return $this->storage;
    }


    /**
     * @return array|object
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
    }


    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {
        if ($this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('success');
        }

        $use_layout = true;

        $form = new UserForm();
        $form->get('submit')->setValue('Log in');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->exchangeArray($form->getData());
                $this->getAuthService()->getAdapter()
                    ->setIdentity($request->getPost('login'))
                    ->setCredential($request->getPost('password'));
                $result = $this->getAuthService()->authenticate();

                if ($result->isValid()) {
                    $this->getSessionStorage()->setRememberMe(1);
                    $this->getAuthService()->setStorage($this->getSessionStorage());
                    $this->getAuthService()->getStorage()->write($request->getPost('login'));
                } else {
                    $use_layout = false;
                }
                $this->redirect()->toRoute('success');
            }
        }

        if ($use_layout) {
            return  new ViewModel(array('form' => $form));
        } else {
            return null;
        }
    }


    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function registerAction()
    {
        $result = true;

        $form = new UserForm();
        $form->get('submit')->setValue('Register');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $user = new RegUser();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->exchangeArray($form->getData());

                if ($result = $this->getUserTable()->registerUser($request->getPost())) {
                    return $this->redirect()->toRoute('login');
                }
            }
        }

        if ($result) {
            return  new ViewModel(array('form' => $form));
        } else {
            return  new ViewModel(array(
                'form' => $form,
                'error_message' => 'User with this Login already exists',
            ));
        }
    }


    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toRoute('login');
    }
}