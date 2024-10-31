<?php
class NashrinWidget extends WP_Widget
{
  public static $addedNashrinWidgets = array();

  function __construct() {
    parent::__construct( 'NashrinWidget', '', array(
      'name'        => 'نشرین',
      'description' => 'هر جایی که این ابزارک را قرار دهید ویجت نشرین همان جا نمایش داده خواهد شد.'
    ));
  }

  public function form( $instance ) {
    extract( $instance );
    ?>
    <div>
      <label for="<?php echo $this->get_field_id('title'); ?>">عنوان:</label>
      <input class="widefat" type="text" style=" margin: 10px 0;"
              id="<?php echo $this->get_field_id('title'); ?>" 
            name="<?php echo $this->get_field_name('title'); ?>" 
           value="<?php if( isset($title) ) echo esc_attr( $title );?>" />
    </div>
    <div>
      <label for="<?php echo $this->get_field_id('description'); ?>">کد محل جایگاه ویجت:</label>
      <input class="widefat" type="text" style="direction: ltr; margin: 10px 0;"
             id="<?php echo $this->get_field_id('description'); ?>" 
           name="<?php echo $this->get_field_name('description'); ?>"
          value="<?php if( isset($description) ) echo stripslashes( esc_attr( $description ) );?>" />
    </div>
    <?php
  }

  public function widget( $args, $instance ) {
    echo "<br>";
    echo( isset( $before_widget ) ? $before_widget : "" );
    echo $instance["description"];
    echo( isset( $after_widget ) ? $before_widget : "" );
    echo "<br>";
  }

}

?>