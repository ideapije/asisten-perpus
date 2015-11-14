jQuery(document).ready(function(){       
   //var options = { currentPage: 3, totalPages: 10}
   var scroll_start = 0;
   var startchange = jQuery('#anchor');
   var offset = startchange.offset();
   //jQuery('.katalog-pagination').bootstrapPaginator(options);
   if (startchange.length){
      jQuery(document).scroll(function() { 
      scroll_start = jQuery(this).scrollTop();

      if(scroll_start > offset.top) {
          jQuery('.sticky').css('position', 'fixed');
          jQuery('.sticky').css('top', '5%');
          jQuery('.sticky').css('left', '50%');
          jQuery('.sticky').css('transform', 'translate(-50%, -50%)');
          jQuery('.sticky').css('z-index', '10000');
       }else{
          //remove style
          jQuery('.sticky').css('position', 'relative');
          jQuery('.sticky').css('z-index', '1');
          jQuery('.sticky').css('margin-top', '25px');
       } 
     });
    }

jQuery(document).on('click',"ul.dropdown-menu [data-toggle=dropdown]",function(){
    // Avoid following the href location when clicking
    event.preventDefault(); 
    // Avoid having the menu to close when clicking
    event.stopPropagation(); 
    // If a menu is already open we close it
    //jQuery('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
    // opening the one you clicked on
    jQuery(this).parent().addClass('open');

    var menu = jQuery(this).parent().find("ul");
    var menupos = menu.offset();
  
    if ((menupos.left + menu.width()) + 30 > jQuery(window).width()) {
        var newpos = - menu.width();      
    } else {
        var newpos = jQuery(this).parent().width();
    }
    menu.css({ left:newpos });
  });
    jQuery('.thumbnail-cat').hover(
        function(){
            jQuery(this).find('.caption-cat').slideDown(250); //.fadeIn(250)
        },
        function(){
            jQuery(this).find('.caption-cat').slideUp(250); //.fadeOut(205)
        }
    ); 

    jQuery(document).on('keyup',".caribuku",function(){
      var kirim= {'lib_book_title': jQuery(this).val()};
      jQuery.ajax({
        url: "visitor/caribuku",
        data:kirim,
        type:"POST",
        success: function(data) {
          jQuery('.listcatalog').html(data);
        }
      });      
    });
});



