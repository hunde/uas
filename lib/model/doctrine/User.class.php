<?php

/**
 * User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class User extends BaseUser
{
    public $password;
	private $generated_password;

    public function getGeneratedPassword()
    {
    	return $this->generated_password;
    }

    public function construct()
    {
        $this->setExpiresAt(time() + sfConfig::get('app_account_expire_days')*86400);
	}

    public function __toString()
    {
        return $this->getName(). ' '. $this->getFathersName(). ' ('. $this->getEmailAddress() . ')';
    }

    public function getFullName()
    {
        return $this->getName() . " " . $this->getFathersName() . " " . $this->getGrandFathersName();
    }
    
    public function getEmailAddress()
    {
        return $this->getEmailLocalPart(). '@' . $this->getDomainName();
    }    
    
    public function ToggleStatus()
    {
        if($this->getStatus()=='activated')
        {
            $this->setStatus('disactivated');
        }
        elseif($this->getStatus()=='preregistered')
        {
            $this->setStatus('activated');
        }
        else
        {
            $this->setStatus('activated');
        }
        $this->save();
    }

    public function displayExtendExpiresAt()
    {
        $extend = time() + sfConfig::get('app_account_extend_days')*86400;
        $this->setExpiresAt($extend);
        $this->save();                
        //return true;
    }

    public function save(Doctrine_Connection $con = null)
	{
		// a new record?
       if(!$this->getId()){       
           $this->setUid(UserTable::getMaxUid() + 1);
        }
		if(!$this->getDomainnameId()){
			// get the default domainname
			$domainname = DomainnameTable::getDefaultDomainname();
			$this->setDomainnameId($domainname->getId());
		}

		if(!$this->getLogin()) $this->generateLogin();
		if(!$this->getEmailLocalPart()) $this->generateEmailLocalPart();

		if(!$this->getCryptPassword()) {
			$password = new Password();
		   	$this->setPasswordObject($password);
			$this->generated_password = $password->getPassword();
		}
		
		// linking a one-on-one sfGuardUser
		
		
		$this->setGid('50000');
		if($this->isNew()) {
		$sfguard_user = $this->getSfGuardUser();
		$sfguard_user->setUsername($this->getLogin());
		$sfguard_user->setIsActive(true);
		$sfguard_user->save();
		$this->setSfguarduserId($sfguard_user->getId());
		}

       return parent::save(); 
	}

	protected function get_all_possible_logins($suffix = "")
	{		
		$a = array(
			$this->getName() . $suffix,
			$this->getName() . $this->getFathersName() . $suffix			
			);

        $a = array_map('strtolower', $a);
        $a = str_replace(' ', '' , $a);
        $a = str_replace('/', '' , $a);
			
		return $a;
	}

	public function generateLogin()
	{
		$logins_to_try = $this->get_all_possible_logins();
		$counter = 0;

		$login_to_try = array_shift($logins_to_try);		
		while(!UserTable::check_if_login_exists($login_to_try)){
			if(count($logins_to_try) == 0){
				$counter++;
				$logins_to_try = $this->get_all_possible_logins($counter);
			}

			$login_to_try = array_shift($logins_to_try);

			// todo: make this better, maybe through a user->flash
			if($counter == 5){
				die('Too many attempts to find a login');
			}
		}

		$this->setLogin($login_to_try);
		return $login_to_try;
	}

    protected function get_all_possible_local_part($suffix = "")
    {
        $a = array(
            $this->getName() . "." . $this->getFathersName() . $suffix,
            $this->getName() . ".". $this->getGrandFathersName() . $suffix,
            $this->getFathersName() . ".". $this->getName() . $suffix,
            $this->getFathersName() . ".". $this->getGrandFathersName() . $suffix,
        );

        $a = array_map('strtolower', $a);
        $a = str_replace(' ', '' , $a);
        $a = str_replace('/', '' , $a);

		return $a;
    }

    public function generateEmailLocalPart()
	{
		$local_parts_to_try = $this->get_all_possible_local_part();
		$counter = 0;

		$local_part_to_try = array_shift($local_parts_to_try);
		while(!UserTable::check_if_local_part_exists($local_part_to_try))
		    {
			    if(count($local_parts_to_try) == 0){
				    $counter++;
				    $local_parts_to_try = $this->get_all_possible_local_part($counter);
			    }
		        $local_part_to_try = array_shift($local_parts_to_try);
			    if($counter == 3){
				    die('Too many attempts to find a local part to try.');
			    }
		}

		$this->setEmailLocalPart($local_part_to_try);
		return $local_part_to_try;
	}
	
	public function setPassword($pass)
	{
		$pwd_obj = new Password($pass);
		return $this->setPasswordObject($pwd_obj);
	}
	
	public function setPasswordObject(Password $password)
	{		
        $this->setNtPassword($password->getNtHash());
        $this->setLmPassword($password->getLmHash());
        $this->setCryptPassword($password->getCryptHash());
        $this->setUnixPassword($password->getUnixHash());                      
	}
	
	static public function checkSfGuardPassword($username, $password)
	{
		$sfguser = Doctrine::getTable('sfGuardUser')->findOneByUsername($username);
		$user = Doctrine::getTable('User')->findOneBySfguarduserId($sfguser->getId());
		$password_obj = new Password($password);
		return $user->checkPassword($password_obj);
	}
	
	public function checkPassword(Password $password)
	{
			if($this->getCryptPassword() == $password->getCryptHash())
			{
				return true;
			}

		return null;
	}
	
	// public function getCredential()
	// {
	//         if(in_array($this->login,sfConfig::get('app_admin'))) return 'admin';
	//         if(in_array($this->login,sfConfig::get('app_secretary'))) return 'secretary' ;
	//         return null;
	// }

    public function listDelete()
    {
		$this->delete();
    }

	public function getLoginName($email_address)
	{
	     $a = explode("@",$email_address);
	     $c = new Criteria();
	     $c->add(UserTable::EMAIL_LOCAL_PART, $a[0]);                  
          $login = UserTable::doSelect($c);
          return $login->getLogin();
	}    
}
