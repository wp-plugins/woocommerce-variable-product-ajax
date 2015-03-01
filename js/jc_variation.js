jQuery(document).ready(function($){
  $(".summary.entry-summary .variations.variations-grid tr td .btn-primary").click(function(event) { 
   event.preventDefault();
   
 var jc_loading = $("#jc_loading").val();
  var jc_success = $("#jc_success").val();
  var jc_close = $("#jc_close").val();

   var $this=$(this);
   $this.append('<img src="'+jc_loading+'" alt="loading" />');
   var frm = $this.parent("form");
   $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (data) {
      $this.find('img').remove();
      $this.append('<img class="sucess" src="'+jc_success+'" alt="loading" />');
      $this.removeAttr('disabled');
      refressCart();
    }
  });
 });
  function refressCart(){
  $.ajax({
      url: wc_cart_fragments_params.ajax_url,
      type: "POST",
      data: {
        action: "woocommerce_get_refreshed_fragments"
      },
      success: function(data) {
        $.each(data.fragments,function(el,html){
          $(el).replaceWith(html);
        });
      }
    });
  }
});