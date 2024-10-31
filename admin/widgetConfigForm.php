<div class="nashrin-settings-container clearfix">
  <div class="nashrin-overlay" id="nashrin-overlay"></div>
  <form id="nashrin-script-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
    <?php wp_nonce_field( 'nashrin' ); ?>
    <fieldset>
    <legend>کد اسکریپت</legend>
      <input name="script-code" type="hidden" value="true"/>
      <textarea id="nashrin-script-code" name="script"><?php echo '<script src=\'' . get_option( 'nashrin_snippet_code') . '\' type=\'text/javascript\' async></script>' ?></textarea>
      <input type="submit" class="nashrin-script-submit" name="Submit" value="ثبت"/>
    </fieldset>
  </form>
  <div class="submit" style="text-align: right; font-size: 17px; padding-right: 10px;">
    <a id="add-new-widget" class="add-new-widget">+ افزودن ویجت جدید</a>
  </div>

  <!-- New Widget Container -->
  <form id="new-widget-sample" class="nashrin-widget-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="">
    <?php wp_nonce_field( 'nashrin' ); ?>
    <input class="widget-id" name="id" type="hidden" value="" />
    <div class="widget-delete" title="حذف">X</div>
    <div class="widget-title">عنوان:&nbsp<input class="title-value" type="text" name="title" value="" /></div>
    <fieldset>
      <legend>کد محل جایگاه ویجت:</legend>
      <input class="widget-snippet" type="text" name="snippet" value="" />
    </fieldset>
    <fieldset class="locationgroup">
      <legend>محل قرارگیری ویجت:</legend>
      <div class="radio-item">
        <label><input name="location" type="radio" value="beginning" checked />نمایش در ابتدای پست</label>
      </div>
      <div class="radio-item">
        <label><input name="location" type="radio" value="end" />نمایش در انتهای پست</label>
      </div>
      <div class="radio-item" style="position: relative; top: -5px;">
        <label><input name="location" type="radio" value="inside" />نمایش بعد از پاراگراف </label>
        <input class="nth-value" type="text" name="nth" value="0"/>
      </div>
    </fieldset>
    <fieldset class="category-list">
      <legend class="category-list-title">نمایش در دسته بندی های:</legend>
      <?php
      $categories = (array) get_categories( '' );
      foreach ($categories as $category) {
        $category = (array) $category;
        echo '<label class="category-item"><input class="checkbox-item" type="checkbox" name="cats[]" value="' . $category['name'] . '" />' . $category['name'] . "</label>";
      }
      ?>
    </fieldset>
    <input type="submit" class="widget-save" name="Submit" value="" />
  </form>

  <div class="nashrin-widgets-setting clearfix">
    <?php
    foreach ($widgets as $ID => $widget) {
      $widget = (array) $widget;
      ?>
      <form class="nashrin-widget-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="">
        <?php wp_nonce_field( 'nashrin' ); ?>
        <input class="widget-id" name="id" type="hidden" value="<?php echo $ID; ?>" />
        <div class="widget-delete" title="حذف">X</div>
        <div class="widget-title">عنوان:&nbsp<input class="title-value" type="text" name="title" value="<?php echo $widget['title'] ?>" /></div>
        <fieldset>
          <legend>کد محل جایگاه ویجت:</legend>
          <?php $sni = '<div id=\'' . $widget['snippet'] . '\'></div>'; ?>
          <input class="widget-snippet" type="text" name="snippet" value="<?php echo $sni ?>" />
        </fieldset>
        <fieldset class="locationgroup">
          <legend>محل قرارگیری ویجت:</legend>
          <div class="radio-item">
            <label><input name="location" type="radio" value="beginning" <?php echo $widget['location'] == 'beginning' ? 'checked' : '' ?> />
            نمایش در ابتدای پست</label>
          </div>
          <div class="radio-item">
            <label><input name="location" type="radio" value="end" <?php echo $widget['location'] == 'end' ? 'checked' : '' ?> />نمایش در انتهای پست</label>
          </div>
          <div class="radio-item" style="position: relative; top: -5px;">
            <label><input name="location" type="radio" value="inside" <?php echo $widget['location'] == 'inside' ? 'checked' : '' ?> />
            نمایش بعد از پاراگراف </label><input class="nth-value" type="text" name="nth" value="<?php echo $widget['nth']?>"/>
          </div>
        </fieldset>
        <fieldset class="category-list">
          <legend class="category-list-title">نمایش در دسته بندی های:</legend>
          <?php
          $categories = (array) get_categories( '' );
          foreach ($categories as $category) {
            $category = (array) $category;
            $checked = in_array( $category["name"], $widget["cats"] ) ? 'checked' : '';
            echo '<label class="category-item"><input class="checkbox-item" type="checkbox" name="cats[]" value="' . $category['name'] . '" ' . $checked . ' />' . $category['name'] . "</label>";
          }
          ?>
        </fieldset>
        <input type="submit" class="widget-save" name="Submit" value="ثبت تغییرات" />
      </form>
      <?php } ?>
  </div>
</div>
