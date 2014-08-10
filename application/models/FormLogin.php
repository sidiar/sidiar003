<?php

class Application_Model_FormLogin extends Zend_Form
{

    public function __construct($options = null)
    {

        $this->setName('login');
        $this->setMethod('post');
        $this->setAction('/account/login');

        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('size', 35);
        $email->setRequired(true);
        $email->addErrorMessage('Please provide a valid e-mail address');
        $email->addValidator('EmailAddress');
        $email->removeDecorator('label');
        $email->removeDecorator('htmlTag');
        $email->removeDecorator('Errors');
        $email->placeholder = "username";
        $email->class = "form-control login_input";
        
        $pswd = new Zend_Form_Element_Password('pswd');
        $pswd->setAttrib('size', 35);
        $pswd->setRequired(true);
        $pswd->addValidator('StringLength', false, array(4,15));
        $pswd->addErrorMessage('Please provide your password');
        $pswd->removeDecorator('label');
        $pswd->removeDecorator('htmlTag');
        $pswd->removeDecorator('Errors');
        $pswd->placeholder = "password";
        $pswd->class = "form-control login_input ";
        
        
        $public = new Zend_Form_Element_Checkbox('public');
        $public->removeDecorator('label');
        $public->removeDecorator('htmlTag');
        $public->removeDecorator('Errors');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');
        $submit->removeDecorator('DtDdWrapper');
        $submit->class = "btn btn-default btn-primary btn-block ";
//        $submit->addDecorator('Label', array('tag' => 'span', 'class' => 'glyphicon glyphicon-star'));
                
                /*

<button type="button" class="btn btn-default btn-lg">
  <span class="glyphicon glyphicon-star"></span> Star
</button>
                 *                  */
        
        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_login.phtml'))));

        $this->addElements(array($email, $pswd, $public, $submit));

    } 

}

