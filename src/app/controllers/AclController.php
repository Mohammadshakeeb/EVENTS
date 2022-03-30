<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;



class AclController extends Controller
{
    public function indexAction()
    {
    }

    public function buildAction()
    {


        $aclfile = APP_PATH . '/security/acl.cache';
        if (true !== is_File($aclfile)) {

            $acl = new Memory();
            $acl->addRole('Admin');
            $acl->addRole('Customer');
            $acl->addRole('Guest');
            $acl->addComponent(
                'order',
                [
                    'add',
                    'addhelper',
                    'index'
                ]
            );

            $acl->allow('Admin', 'order', 'add');

            //  $acl->deny('Guest', 'order', '*');
            $acl->allow('Guest', 'order', 'add');
            $acl->allow('Admin');

            file_put_contents(
                $aclfile,
                serialize($acl)
            );
        } else {
            $acl = unserialize(
                file_get_contents($aclfile)
            );
        }
    }

    public function getroleAction(){

     echo   '<h1>FORM TO ADD NEW ROLES</h1>
        <br><br>
        <form method="POST" action="addrole">
    <label for="role"><b>ROLE<b></label>
    <input type="text" name="role" id="role"></form>
    <br><br>
    <input type="submit" name="submit" value="SUBMIT">';
    }

    public function addroleAction(){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $data=new Roles();
        $data->role=$_POST['role'];
        $data->save();
    }

    public function getcontrollerAction(){

        echo   '<h1>FORM TO ADD NEW COMPONENTS</h1>
        <br><br>
        <form method="POST" action="addrole">
    <label for="role"><b>COMPONENT<b></label>
    <input type="text" name="controller" id="controller"></form>
    <br><br>
    <input type="submit" name="submit" value="SUBMIT">';

    }

    public function addcomponentAction(){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $data=new Roles();
        $data->role=$_POST['controller'];
        $data->save();
    }
}
