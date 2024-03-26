( btns => {

	if ( btns.length > 0 ) {

		window.addEventListener('click', event => {

			const btn = event.target.closest('.menu__btn');

			[...btns].forEach( _btn => _btn.classList.toggle('is-open', btn !== null && _btn === btn ));

		});

	}

})(document.querySelectorAll('.menu__btn'));