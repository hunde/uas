<?php

/**
 * BaseDomainName
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $EmailAlias
 * 
 * @method string              getName()       Returns the current record's "name" value
 * @method Doctrine_Collection getUsers()      Returns the current record's "Users" collection
 * @method Doctrine_Collection getEmailAlias() Returns the current record's "EmailAlias" collection
 * @method DomainName          setName()       Sets the current record's "name" value
 * @method DomainName          setUsers()      Sets the current record's "Users" collection
 * @method DomainName          setEmailAlias() Sets the current record's "EmailAlias" collection
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseDomainName extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('domain_name');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User as Users', array(
             'local' => 'id',
             'foreign' => 'domainname_id'));

        $this->hasMany('EmailAlias', array(
             'local' => 'id',
             'foreign' => 'domainname_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}