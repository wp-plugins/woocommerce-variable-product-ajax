jQuery(document).ready(function($){
  
  //var jcurl = window.location.hostname;
  var jc_loading = $("#jc_loading").val();
  var jc_success = $("#jc_success").val();
  var jc_close = $("#jc_close").val();

  $("body").prepend('<div class="overlay"><div class="content-over"><div class="close-overlay"> <img src="'+jc_close+'"  alt="close" /><span class="num" style="visibility:hidden;">0</span></div><div class="item">Loading....</div></div></div>');
  /*--- open overlay---*/
  $("a.product_type_variable").on('click', function(event) {
   event.preventDefault();
   var $this = $(this);
   openOverlay($this);
 });

  function openOverlay($this){
    var url= $this.attr('href'); 
    $(".overlay").fadeIn();
    $(".overlay .content-over .item").html('<img src="'+jc_loading+'" alt="loading" />');
    $( ".overlay .content-over .item" ).load( ""+ url +" .summary.entry-summary .variations.variations-grid", function() {
      fnEvtAddCartProduct();
      inputNumberStyle();
    });
  }

  /*--- end open overlay---*/
  var fnEvtAddCartProduct= function(){
    $(".overlay .variations.variations-grid .single_add_to_cart_button").on('click', function(event) {
      event.preventDefault();
      var $this=$(this);
      sendFormProduct($this);
    });
  };


  function sendFormProduct($this){
    $this.append('<img src="'+jc_loading+'" alt="loading" />');
    var frm = $this.parent("form");

    $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (data) {
         // console.log(data);
         $this.find('img').remove();
         $this.append('<img class="sucess" src="'+jc_success+'" alt="loading" />');
         $this.removeAttr('disabled');
         refressCartOverlay();
       }
     });
  }

  function refressCartOverlay(){
    jQuery.ajax({
      url: wc_cart_fragments_params.ajax_url,
      type: "POST",
      data: {
        action: "woocommerce_get_refreshed_fragments"
      },
      success: function(data) {
        jQuery.each(data.fragments,function(el,html){
          jQuery(el).replaceWith(html);
        });
      }
    });
  }



  $(".overlay .content-over .close-overlay").click(function(e) {
    $(".overlay").fadeOut();
    e.preventDefault();
  });

  function inputNumberStyle(){
    $("input[type='number']").stepper({
customClass: "", // Class applied to instance
labels: {
up: "Up", // Up arrow label
down: "Down" // Down arrow label
}
});
  }
  inputNumberStyle();

});