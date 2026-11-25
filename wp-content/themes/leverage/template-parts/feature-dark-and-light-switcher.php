<?php
/**
 * @package Leverage
 */
?>

<?php
$dark_and_light_switcher = get_field( 'dark_and_light_switcher', 'option' );

if ( $dark_and_light_switcher && array_key_exists( 'enable', $dark_and_light_switcher ) && $dark_and_light_switcher['enable'] ) : ?>

  <div class="dark-and-light-switcher">
    <input type="checkbox" class="checkbox" id="dark-and-light-switcher" <?php echo esc_attr( $dark_and_light_switcher['default'] == 'dark' ? 'checked' : '' ) ?> data-dark-color="<?php echo esc_attr( $dark_and_light_switcher['dark_background_color'] ); ?>" data-light-color="<?php echo esc_attr( $dark_and_light_switcher['light_background_color'] ); ?>" />
    <label class="label" for="dark-and-light-switcher">
      <i class="fas fa-moon icon dark"></i>
      <i class="fas fa-sun icon light"></i>
      <div class="circle"></div>
    </label>
  </div>

<?php endif; ?>