[?php if ($sf_user->hasFlash('notice')): ?]
  <div class="notice">[?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?]</div>
[?php endif; ?]

[?php if ($sf_user->hasFlash('error')): ?]
<div class="error">
  <div class="error_msg">[?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?]
    <div class="btn_admin_actions"><div class="icn icn-close"></div>[?php echo __('close') ?>]</div>
  </div>
</div>
[?php endif; ?]