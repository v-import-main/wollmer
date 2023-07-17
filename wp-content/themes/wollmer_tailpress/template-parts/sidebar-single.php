<div id="autotoc">
  <ul>
    <li class="scrolltop"><a href="#">В начало</a></li>
  </ul>
</div>
<script>
  function grabAutoTOC($ = jQuery) {
    const cot = $('#autotoc');
    if (cot.length < 1) return;


    $('.entry-content h2').map(el => {
      el = $('.entry-content h2')[el];
      if (el.id) {
        cot.find('ul').append('<li ><a href="#' + el.id + '">' + el.textContent + '</a>');
      }
    });

    if (document.body.clientWidth >= 768) {
      $('#secondary').find('.sticky-sidebar').append(cot);
    } else {
      $('#footer').after(
        '<span id="init_toc" class="go-top show"><i class="bb-icon bb-ui-icon-list"></i></span>'
      );

      $('#init_toc').bind('click', function() {
        $('html').addClass('autoc_active');
      });

      $('#autotoc').bind('click', function(event) {
        if (event.target.id !== 'autotoc') {
          return;
        } else {
          $('html').removeClass('autoc_active');
        }
      });
    }

    const headlines = $('body').find(
      '.entry-content h2'
    );
    console.log('headlines', headlines);
    const anchors = [];
    console.log('anchors', anchors);
    for (let i = 0; i < headlines.length; i++) {
      if ($(headlines[i]).attr('id')) {
        console.log('el', headlines[i]);
        anchors.push(headlines[i]);
      }
    }

    $(window).scroll(function() {
      let scrollTop = $(document).scrollTop();

      for (var i = 0; i < anchors.length; i++) {
        if (scrollTop > $(anchors[i]).offset().top - 80 && scrollTop <= $('#deadline').offset().top - 100) {
          cot.find('ul li a').removeClass('selected');
          cot.find('ul li a[href="#' + $(anchors[i]).attr('id') + '"]').addClass('selected');
        } else if (scrollTop < $(anchors[0]).offset().top - 80 || scrollTop > $('#deadline').offset().top - 100) {
          cot.find('ul li a').removeClass('selected');
        }
      }
    });
  }
  grabAutoTOC();


  jQuery(document).on('click','a[href^=\\#]', function () {
    let href = jQuery(this).attr('href');

    jQuery('html, body').animate({
        scrollTop: jQuery(href).offset().top
    });

    return false;
});
</script>