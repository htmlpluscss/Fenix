( btns => {

	if ( btns.length > 0 ) {

		window.addEventListener('click', event => {

			const btn = event.target.closest('.menu__btn');

			[...btns].forEach( _btn => _btn.classList.toggle('is-open', btn !== null && _btn === btn && btn.classList.contains('is-open') === false ) );

			document.body.classList.toggle('is-open-menu', [...btns].some( btn => btn.classList.contains('is-open') ) );

		});

		[...btns].forEach( btn => {

			btn.addEventListener('mouseleave', ()=>{

				btn.classList.remove('is-open');

			});

		});

	}

})(document.querySelectorAll('.menu__btn'));