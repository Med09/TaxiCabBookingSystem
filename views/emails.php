  <style>
  .taxi-form {
  width:500px;
  }
  .taxi-form label {display:block;}
  
  </style>


<div class="wrap">
<?php screen_icon('users'); ?><h2><?php esc_attr_e("Taxi Booking Settings Page");?></h2>

<form action="options.php" method="post">

<?php settings_fields('plugin_options'); ?>
<?php do_settings_sections('plugin'); ?>
<table class="form-table"> 

  <tr valign="top">

    <td colspan="2">
        <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </td>

  </tr>
</table>
</form>

</div>
  