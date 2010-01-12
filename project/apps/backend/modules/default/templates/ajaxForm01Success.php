<!-- apps/frontend/modules/job/templates/_form.php -->
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php echo form_tag_for($formu, '@job') ?>
  <table id="job_form">
    <tfoot>
      <tr>
        <td colspan="2">
           <input type="submit" value="Preview your job" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $formu ?>
    </tbody>
  </table>
</form>
