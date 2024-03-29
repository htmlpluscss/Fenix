( forms => {

	[...forms].forEach( form => {

		const formStatus = form.closest('.form-status');

		form.addEventListener('submit', event => {

			event.preventDefault();

			const formData = new FormData(form),
				  formDataJSON = {},
				  btn = form.querySelector('.form__submit');

			formData.forEach( (value, key) => formDataJSON[key] = value );

			btn.disabled = true;

			fetch(form.getAttribute('action'), {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(formDataJSON)
			})
			.then(response => response.json())
			.then(result => {

				console.log(result);

				formStatus && formStatus.classList.add('is-done');

			});

		});

	});

})(document.querySelectorAll('.form'));

( passwords => {

	[...passwords].forEach( password => {

		const btn = password.querySelector('.input-wrap-password__btn');
		const input = password.querySelector('.input-wrap-password__input');

		btn.addEventListener('click', () => {

			input.type = input.type === 'text' ? 'password' : 'text';

		});

	});

})(document.querySelectorAll('.input-wrap-password'));