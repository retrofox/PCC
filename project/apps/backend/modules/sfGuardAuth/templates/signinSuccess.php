<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
<table>
	<tr><th><?php echo $form['username']->renderLabel() ?></th></tr>
	<tr><td class="conMsg">
    	<div class="mountMsg">
    		<div class="msgInput"><?php echo $form['username']->renderError() ?></div>
    		<?php echo $form['username'] ?>
    	</div>
	</td></tr>
    
    <tr><th><?php echo $form['password']->renderLabel() ?></th></tr>
    <tr><td>
    	<div class="mountMsg">
    		<div class="msgInput"><?php echo $form['password']->renderError() ?></div>
    		<?php echo $form['password'] ?>
    	</div>
    </td></tr>

    <tr><td><?php echo $form['remember']->renderError() ?></td></tr>
    <tr>
		<td>
        <?php echo $form['remember']->renderLabel() ?>:
        <?php echo $form['remember'] ?>
		</td>
    </tr>
    
  </table>
  
  <p><input type="submit" value="sign in" /></p>
</form>