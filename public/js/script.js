function footerAlign() {
  $('footer').css('display', 'block');
  $('footer').css('height', 'auto');
  var footerHeight = $('footer').outerHeight();
  $('body').css('padding-bottom', footerHeight);
  $('footer').css('height', footerHeight);
}

$(document).ready(function(){
  $('.mdb-select').material_select();
  footerAlign();
  setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);

   $('.delete_sweet_alert').on('click', function () {
       swal({   
        title: "Are you sure?",   
        text: "You will not be able to recover this imaginary file!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Yes, delete it!",   
        cancelButtonText: "No, cancel plx!",   
        closeOnConfirm: false,   
        closeOnCancel: false }, 
        function(isConfirm){   
           if (isConfirm) {     
               swal("Deleted!", "Your imaginary file has been deleted.", "success");   } 
           else {
               swal("Cancelled", "Your imaginary file is safe :)", "error");   } 
        });
    });

   $("#scrollToTopButton").hide();
  
      //Check to see if the window is top if not then display button
    $(window).scroll(function(){
      if ($(this).scrollTop() > 200) {
        $("#scrollToTopButton").fadeIn();
      } else {
        $("#scrollToTopButton").fadeOut();
      }
    });
    
      //Click event to scroll to top
    $("#scrollToTopButton").click(function(){
      $('html, body').animate({scrollTop : 0},800);
      return false;
    });

      // Notifications
    if ($(".success_messages").length) {
        $( ".success_messages" ).each(function( i ) {
          showNotification($( this ).text(), "#", "success", "bottom", "left", 'animated fadeInDown', 'animated fadeOutUp');
          setTimeout(function () { doThis($li); }, 5000 * (i + 1));
        });
    } 
    if ($(".error_messages").length) {
        $( ".error_messages" ).each(function( i ) {
          showNotification($( this ).text(), "#", "error", "bottom", "left", 'animated fadeInDown', 'animated fadeOutUp');
          setTimeout(function () { doThis($li); }, 5000 * (i + 1));
        });
    } 
    if ($(".warning_messages").length) {
        $( ".warning_messages" ).each(function( i ) {
          showNotification($( this ).text(), "#", "warning", "bottom", "left", 'animated fadeInDown', 'animated fadeOutUp');
          setTimeout(function () { doThis($li); }, 5000 * (i + 1));
        });
    } 


});

$( window ).resize(function() {
  footerAlign();
});



$(function () {
    tinymce.init({
      // selector: 'textarea',
      height: 500,
      theme: 'modern',
      mode : "specific_textareas",
      editor_selector : "editor",
      plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
      toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
      image_advtab: true,
      templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
      ],
      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
      ]
     });
});

function showNotification(text, redirect, colorName, placementFrom, placementAlign, animateEnter, animateExit) {
    if (text === null || text === '') { text = 'New notification!'; }
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (redirect === null || redirect === '') { redirect = '/contact'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    var allowDismiss = true;

    $.notify({
      // options
      icon: 'glyphicon glyphicon-warning-sign',
      title: '',
      message: text,
      url: redirect,
      target: '_blank'
    },{
      // settings
      element: 'body',
      position: null,
      type: colorName,
      allow_dismiss: allowDismiss,
      newest_on_top: true,
      showProgressbar: false,
      placement: {
        from: placementFrom,
        align: placementAlign
      },
      offset: 20,
      spacing: 10,
      z_index: 1031,
      delay: 5000,
      timer: 1000,
      url_target: '_blank',
      mouse_over: null,
      animate: {
        enter: animateEnter,
        exit: animateExit
      },
      onShow: null,
      onShown: null,
      onClose: null,
      onClosed: null,
      icon_type: 'class',
      template: '<div data-notify="container" class="bootstrap-notify-container col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                  '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                  '<span data-notify="icon"></span> ' +
                  '<span data-notify="title">{1}</span> ' +
                  '<span data-notify="message">{2}</span>' +
                  '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                  '</div>' +
                  '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>' 
    });
}





/*$(document).ready(function() {

    var docHeight = $(window).height();
    var footerHeight = $('footer').outerHeight();
    var footerTop = $('footer').position().top + footerHeight;

    if (footerTop < docHeight)
        $('footer').css('margin-top', 16+ (docHeight - footerTop) + 'px');
});*/