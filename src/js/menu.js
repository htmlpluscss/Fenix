( btns => {

	if ( btns.length > 0 ) {

		window.addEventListener('click', event => {

			if ( event.target.closest('.menu__list') && event.target.closest('a') ) {

				return;

			}

			const btn = event.target.closest('.menu__btn');

			[...btns].forEach( _btn => _btn.classList.toggle('is-open', btn !== null && _btn === btn && btn.classList.contains('is-open') === false ) );

			document.body.classList.toggle('is-open-menu', [...btns].some( btn => btn.classList.contains('is-open') ) );

		});

		[...btns].forEach( btn => {

			btn.addEventListener('mouseleave', ()=>{

				setTimeout( ()=> {

					btn.classList.remove('is-open');

				},100);

			});

		});

	}

})(document.querySelectorAll('.menu__btn'));