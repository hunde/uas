<?php

/**
 * FtpAccount
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class FtpAccount extends BaseFtpAccount
{
    public function getUserFullname()
    {
            $userid = $this->getUserId();
            $user = Doctrine::getTable('User')->find($userid);
            return $user->__toString();
    }
    public function saveUpBandwidth()
    {
            $up = $this->getUpBandwidth()."s";
            $this->setUpBandwidth($up);
            $this->save();
    }
}
