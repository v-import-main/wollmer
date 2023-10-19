document.addEventListener("DOMContentLoaded", function(event) {
    // let image = document.querySelector('.main-image')
    // let attr = document.clientWidth > 567 ? image.getAttribute('data-desk') : image.getAttribute('data-mob');
    // image.style('backgroundImage') = attr;

    document.querySelector('.search-cross').on('click', function(e){
        document.querySelector('#modal-suggest').style('display') = 'none';
    });

    document.querySelector('.nav-bg').on('click', function(e){
        document.querySelector('#mobile-search,#nav-catalog').classList.remove('active');
        document.querySelector('body').classList.remove('paused');
    });

    document.querySelector('input.search-input').on('change', function(e){
        console.log(e);
    })
    document.querySelector('form[role="search"], #searchform').on('submit', function(e){
		e.preventDefault();
		search_suggest(document.querySelector(e.target).querySelector('.search-input').value);
		return false;
	});
    
    // document.querySelector('#searchsubmit').on('click', function(e){
	// 	e.preventDefault();
	// 	search_suggest(document.querySelector(e.target).querySelector('.search-input').value);
	// 	return false;
	// });
});
// alert(1);

$('.portfolio-slides').slick({
    infinite        : true,
    slidesToShow    : 1,
    slidesToScroll  : 1,
    mobileFirst     : true
});
