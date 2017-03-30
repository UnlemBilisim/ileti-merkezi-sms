<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli
 * Date: 24.03.2017
 * Time: 09:37
 */

namespace UnlemBilisim\IletiMerkezi;

class IletiMerkeziMessage{

    public $message;

    public function message($mess)
    {
        $this->message = $mess;
        return $this;
    }
}