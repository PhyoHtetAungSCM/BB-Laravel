/** Clear Input */
function createUserClearance() {
	document.getElementById('name').value = "";
	document.getElementById('email').value = "";
	document.getElementById('password').value = "";
	document.getElementById('passwordConfirmation').value = "";
	document.getElementById('type').value = "";
	document.getElementById('phone').value = "";
	document.getElementById('dob').value = "";
	document.getElementById("profile").value = "";
	document.getElementById("createUserProfile").removeAttribute('src');
}

/** Review Profile */
let loadFile = function (event) {
	let createUserProfile = document.getElementById('createUserProfile');
	createUserProfile.src = URL.createObjectURL(event.target.files[0]);
	createUserProfile.onload = function () {
		URL.revokeObjectURL(createUserProfile.src);
	}
};