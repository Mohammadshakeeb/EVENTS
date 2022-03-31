<?php

namespace App\Listeners;

use Phalcon\Events\Event;

class notificationListeners
{

    public function beforeSend(Event $event, $values, $settings)
    {

        // echo "<pre>";
        // print_r($settings[0]->title_op);
        // print_r($values);
        // echo "</pre>";
        // die();
        if ($settings[0]->title_op == "with") {
            $values->name = $values->name . $values->tags;
        }
        if ($values->price == '') {
            $values->price = $settings[0]->default_price;
        }
        if ($values->stock == '') {
            $values->stock = $settings[0]->default_stock;
        }
        return $values;
    }

    public function afterSend(Event $event, $values, $settings)
    {
        if ($values->zipcode == '') {
            $values->zipcode = $settings[0]->default_zipcode;
        }
        return $values;
    }

    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application)
    {


        $aclfile = APP_PATH . '/security/acl.cache';
        if (is_file($aclfile) == true) {

            $acl = unserialize(
                file_get_contents($aclfile)
            );
            $role = $application->request->get('role');
            $controller = $application->router->getControllerName();
            $action = $application->router->getActionName();
            if (!$role || true !== $acl->isAllowed($role, $controller, $action)) {
                echo "access denied";
                die();
            }
        } else {

            echo "No ACL";
            die();
        }
    }
}
