<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('user/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('user/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'user/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['domainname_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['domainname_id']->renderError() ?>
          <?php echo $form['domainname_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['fathers_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['fathers_name']->renderError() ?>
          <?php echo $form['fathers_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['grand_fathers_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['grand_fathers_name']->renderError() ?>
          <?php echo $form['grand_fathers_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['login']->renderLabel() ?></th>
        <td>
          <?php echo $form['login']->renderError() ?>
          <?php echo $form['login'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['phone']->renderLabel() ?></th>
        <td>
          <?php echo $form['phone']->renderError() ?>
          <?php echo $form['phone'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['nt_password']->renderLabel() ?></th>
        <td>
          <?php echo $form['nt_password']->renderError() ?>
          <?php echo $form['nt_password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lm_password']->renderLabel() ?></th>
        <td>
          <?php echo $form['lm_password']->renderError() ?>
          <?php echo $form['lm_password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['crypt_password']->renderLabel() ?></th>
        <td>
          <?php echo $form['crypt_password']->renderError() ?>
          <?php echo $form['crypt_password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['unix_password']->renderLabel() ?></th>
        <td>
          <?php echo $form['unix_password']->renderError() ?>
          <?php echo $form['unix_password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['gid']->renderLabel() ?></th>
        <td>
          <?php echo $form['gid']->renderError() ?>
          <?php echo $form['gid'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['uid']->renderLabel() ?></th>
        <td>
          <?php echo $form['uid']->renderError() ?>
          <?php echo $form['uid'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['status']->renderLabel() ?></th>
        <td>
          <?php echo $form['status']->renderError() ?>
          <?php echo $form['status'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['alternate_email']->renderLabel() ?></th>
        <td>
          <?php echo $form['alternate_email']->renderError() ?>
          <?php echo $form['alternate_email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email_local_part']->renderLabel() ?></th>
        <td>
          <?php echo $form['email_local_part']->renderError() ?>
          <?php echo $form['email_local_part'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email_quota']->renderLabel() ?></th>
        <td>
          <?php echo $form['email_quota']->renderError() ?>
          <?php echo $form['email_quota'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['expires_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['expires_at']->renderError() ?>
          <?php echo $form['expires_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
