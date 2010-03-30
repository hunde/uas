<?php

/**
 * BaseFtpAccount
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $up_bandwidth
 * @property integer $down_bandwidth
 * @property string $ip_access
 * @property integer $quota_size
 * @property integer $quota_files
 * @property User $User
 * 
 * @method integer    getUserId()         Returns the current record's "user_id" value
 * @method integer    getUpBandwidth()    Returns the current record's "up_bandwidth" value
 * @method integer    getDownBandwidth()  Returns the current record's "down_bandwidth" value
 * @method string     getIpAccess()       Returns the current record's "ip_access" value
 * @method integer    getQuotaSize()      Returns the current record's "quota_size" value
 * @method integer    getQuotaFiles()     Returns the current record's "quota_files" value
 * @method User       getUser()           Returns the current record's "User" value
 * @method FtpAccount setUserId()         Sets the current record's "user_id" value
 * @method FtpAccount setUpBandwidth()    Sets the current record's "up_bandwidth" value
 * @method FtpAccount setDownBandwidth()  Sets the current record's "down_bandwidth" value
 * @method FtpAccount setIpAccess()       Sets the current record's "ip_access" value
 * @method FtpAccount setQuotaSize()      Sets the current record's "quota_size" value
 * @method FtpAccount setQuotaFiles()     Sets the current record's "quota_files" value
 * @method FtpAccount setUser()           Sets the current record's "User" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFtpAccount extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ftp_account');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('up_bandwidth', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('down_bandwidth', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('ip_access', 'string', 255, array(
             'type' => 'string',
             'default' => '*',
             'length' => '255',
             ));
        $this->hasColumn('quota_size', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('quota_files', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}