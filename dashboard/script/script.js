(() => {
'use strict'
const forms = document.querySelectorAll('.needs-validation')
Array.from(forms).forEach(form => {
	form.addEventListener('submit', (e) => {
		if(!form.checkValidity()){
			e.preventDefault()
			e.stopPropagation()
		} else {
			Process()
			window.setTimeout(function(){
				form.submit()
			}, 2000)
		}
    form.classList.add('was-validated')
}, false)
})
})()

function Process(){
	let html;
	html = '<div style="min-height: 200px" class="d-flex flex-column align-items-center justify-content-center gap-4">'
	html = html.concat('<img style="width: 60px" src="assets/spinner.gif">')
	html = html.concat('<span style="font-size: 14px">Processing please wait.</span>')
	html = html.concat('</div>')
	Swal.fire({
	  html: html,
	  allowOutsideClick: false,
	  showConfirmButton: false,
	  width: 350
	});
}

function Redirect(uri){
	window.setTimeout(function(){
		window.location.href = uri
	}, 1500)
}