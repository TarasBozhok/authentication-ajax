<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;


/**
 * Class UserTable
 * @package User\Model
 */
class UserTable
{
    protected $tableGateway;

    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    /**
     * @param $userData
     * @return bool|int
     */
    public function registerUser($userData)
    {
        $user = $this->getUser($userData['login']);

        if (!$user) {
            $data = array(
                'login' => $userData->login,
                'password' => md5($userData->password),
                'name' => $userData->name
            );
            return $this->tableGateway->insert($data);
        }
        return false;
    }


    /**
     * @param $login
     * @return array|\ArrayObject|null
     */
    public function getUser($login)
    {
        return $this->tableGateway->select(array('login' => $login))->current();
    }
}