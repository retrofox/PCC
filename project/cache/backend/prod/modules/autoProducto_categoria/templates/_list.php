<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      <thead>
		<tr>
          <th id="sf_admin_list_batch_actions">
            <input id="sf_admin_list_batch_checkboxAll" type="checkbox"/>
            <input id="sf_admin_list_batch_checkboxInvert" type="checkbox"/>
          </th>
          <?php include_partial('producto_categoria/list_th_tabular', array('sort' => $sort)) ?>
          <th class="sf_admin_list_th_actions">A</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="4">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('producto_categoria/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $producto_categoria): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('producto_categoria/list_td_batch_actions', array('producto_categoria' => $producto_categoria, 'helper' => $helper)) ?>
            <?php include_partial('producto_categoria/list_td_tabular', array('producto_categoria' => $producto_categoria)) ?>
            <?php include_partial('producto_categoria/list_td_actions', array('producto_categoria' => $producto_categoria, 'helper' => $helper)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
