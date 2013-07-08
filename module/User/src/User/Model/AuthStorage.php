<?php
namespace User\Model;

use Zend\Authentication\Storage;


class AuthStorage extends Storage\Session
{
    /**
     * @param int $rememberMe
     * @param int $time
     * @return $this
     */
    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
        return $this;
    }


    /**
     * @return $this
     */
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
        return $this;
    }
}