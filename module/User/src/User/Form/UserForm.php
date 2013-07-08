<?php
namespace User\Form;

use Zend\Form\Form;


/**
 * Class UserForm
 * @package User\Form
 */
class UserForm extends Form
{
    /**
     * @param null $name
     */
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Login',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'placeholder' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'id' => 'submitbutton',
                'class' => 'btn',
            ),
        ));
    }
}