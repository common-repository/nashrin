function generateID() {
  var id = '';
  var r = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  for (var i = 0; i < 10; i++) { id += r.charAt(Math.floor(Math.random() * r.length)); }
  return id;
}

jQuery(document).ready(function($) {
  
  function checkboxAnimation() {
    $('.nashrin-widget-form .checkbox-item:not(:checked)').parent().css('opacity', '0.5');
    $('.nashrin-widget-form .checkbox-item:checked').parent().css('opacity', '1');
    $('.nashrin-widget-form .checkbox-item').change(function() {
      if($(this).is(':checked')) {
        $(this).parent().css('opacity', '1');
      } else { $(this).parent().css('opacity', '0.5'); }
    });
  }
  checkboxAnimation();

  $('.nashrin-widget-form .widget-delete').hover(
    function() { $(this).parent().css('border-color', 'red'); },
    function() { $(this).parent().css('border-color', '#9e9e9e'); }
  );

  $('.nashrin-widget-form .widget-save').hover(
    function() {$(this).parent().css('border-color', 'rgb(184,240,20)'); },
    function() {$(this).parent().css('border-color', '#9e9e9e'); }
  );

  $('#nashrin-script-form .nashrin-script-submit').on('click', function(e) {
    e.preventDefault();
    console.log($('#nashrin-script-code').val());
    $('.nashrin-overlay').show();
    that = this;
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      cache: false,
      data: { script_update: true, script_code: $('#nashrin-script-code').val() },
      success: function(res) { 
        $('.nashrin-overlay').hide();
      },
      error: {}
    });
  });

  // Create New Widget Form
  $('#add-new-widget').on('click', function(e) {
    e.preventDefault();
    $('#new-widget-sample').clone().removeAttr('id').appendTo('.nashrin-widgets-setting');
    checkboxAnimation();
    $('.nashrin-widget-form:last-child .title-value').val('');
    $('.nashrin-widget-form:last-child .widget-id').val(generateID());
    $('.nashrin-widget-form:last-child .widget-snippet').val('');
    $('.nashrin-widget-form:last-child .nth-value').val('');
    $('.nashrin-widget-form:last-child .widget-save').val('ویجت جدید');
    $('.nashrin-widget-form:last-child .widget-save').css('background-color', 'orange');
    $('.nashrin-widget-form:last-child').css('border-color', 'orange');
    $('.nashrin-widget-form:last-child').addClass('not_saved');
    $('.nashrin-widget-form:last-child .widget-delete').hover(
      function() { $(this).parent().css('border-color', 'red'); },
      function() { 
        color = $(this).parent().hasClass('not_saved') ? 'orange' : '#9e9e9e';
        $(this).parent().css('border-color', color); }
    );
    $('.nashrin-widget-form .widget-save').hover(
      function() { $(this).parent().css('border-color', 'rgb(184,240,20)'); },
      function() { 
        color = $(this).parent().hasClass('not_saved') ? 'orange' : '#9e9e9e';
        $(this).parent().css('border-color', color); }
    );
    $('html, body').animate({ scrollTop: $('.nashrin-widget-form:last-child').offset().top }, 300);
  });

  // Save Widget Form
  $(document).on('submit', '.nashrin-widget-form', function(e) {
    e.preventDefault();
    $('.nashrin-overlay').show();
    $(this).closest('.nashrin-widget-form').css('animation-duration', '2s').css('animation-name', '');
    that = this;
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      cache: false,
      data: $(that).serialize(),
      success: function(res) { 
        $(that).closest('.nashrin-widget-form').css('animation-duration', '2s').css('animation-name', 'fadeIn') 
        $(that).removeClass('not_saved');
        $('.nashrin-overlay').hide();
        $(that).css('border-color', 'orange');
        $('.nashrin-widget-form:last-child .widget-save').val('ثبت تغییرات');
        $('.nashrin-widget-form:last-child .widget-save').finish().css('background-color', 'rgb(184,240,20)');
      },
      error: function() {}    // TODO: output delete was not successful
    });
  });

  // Delete Widget Form
  $(document).on('click', '.widget-delete', function(e) {
    if (!confirm('آیا مطمین هستید؟')) return false; 
    var widgetId = $(this).closest('.nashrin-widget-form').find('.widget-id').val();
    var that = this;
    $('.nashrin-overlay').show();
    $.ajax({
      url: 'options-general.php?page=nashrin-settings',
      method: 'POST',
      data: { widget_delete: true, id: widgetId },
      success: function() {
        $(that).closest('.nashrin-widget-form').css('background-color', 'rgba(100, 0, 0, 0.3)').fadeOut(500, function() {
          $(that).closest('.nashrin-widget-form').remove();
          $('.nashrin-overlay').hide();
        });
      },
      error: function() {}    // TODO: output delete was not successful
    });
  });

});
