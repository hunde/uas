<?php

class User extends BaseUser
{
    public $password;
	private $generated_password;

    public function getGeneratedPassword()
    {
    	return $this->generated_password;
    }

    public function __construct()
    {
        parent::__construct();
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

    public function save(PropelPDO $con = null)
	{
       if(!$this->getId())
        {       
           $this->setUid(UserPeer::getMaxUid() + 1);
           $password = new Password();

           $this->generated_password = $password->getPassword();

           $this->setNtPassword($password->getNtHash());
           $this->setUnixPassword($password->getNtHash());
           $this->setCryptPassword($password->getCryptHash());
           $this->setLmPassword($password->getLmHash());
        }
		if(!$this->getDomainnameId()){
			// get the default domainname
			$domainname = DomainnamePeer::getDefaultDomainname();
			$this->setDomainnameId($domainname->getId());
		}

		if(!$this->getLogin()) $this->generateLogin();
		if(!$this->getEmailLocalPart()) $this->generateEmailLocalPart();

       return parent::save(); 
	}

	protected function get_all_possible_logins($suffix = "")
	{		
		$a = array(
			$this->getName() . $suffix,
			$this->getName() . $this->getFathersname() . $suffix			
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
		while(!UserPeer::check_if_login_exists($login_to_try)){
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
            $this->getName() . "." . $this->getFathersname() . $suffix,
            $this->getName() . ".". $this->getGrandFathersName() . $suffix,
            $this->getFathersname() . ".". $this->getName() . $suffix,
            $this->getFathersname() . ".". $this->getGrandFathersName() . $suffix,
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
		while(!UserPeer::check_if_local_part_exists($local_part_to_try))
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
	
	public function setPassword(Password $password)
	{		
        $this->setNtPassword($password->getNtHash());
        $this->setLmPassword($password->getLmHash());
        $this->setCryptPassword($password->getCryptHash());
        $this->setUnixPassword($password->getUnixHash());                      
        return $this->save();           
	}
	
	public function checkPassword(Password $password)
	{
		return $this->getCryptPassword() == $password->getCryptHash();
	}
	
	public function getCredential()
	{
        if(in_array($this->login,sfConfig::get('app_admin'))) return 'admin';
        if(in_array($this->login,sfConfig::get('app_secretary'))) return 'secretary' ;
        return null;
	}

    public function listDelete()
    {
        $criteria =  new Criteria();
        $criteria->add(UserPeer::ID, $this->getId());
        $criteria->add(FtpAccountPeer::USER_ID, $this->getId());
        $criteria->add(SambaAccountPeer::USER_ID, $this->getId());
        $criteria->add(UnixAccountPeer::USER_ID, $this->getId());
        $criteria->add(UserIdentificationPeer::USER_ID, $this->getId());
        UserPeer::doDelete($criteria);                
        //return true;
    }

	public function getLoginName($email_address)
	{
	     $a = explode("@",$email_address);
	     $c = new Criteria();
	     $c->add(UserPeer::EMAIL_LOCAL_PART, $a[0]);                  
          $login = UserPeer::doSelect($c);
          return $login->getLogin();
	}    

}
