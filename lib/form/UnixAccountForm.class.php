<?php

/**
 * UnixAccount form.
 *
 * @package    uas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UnixAccountForm extends BaseUnixAccountForm
{
  public function configure()
  {
  $this->validatorSchema['hostname'] = new sfValidatorRegex(array
	     ('pattern'=>('/\A([\da-z-]+\.){1,}[a-z]+\z/')));
  }
}
