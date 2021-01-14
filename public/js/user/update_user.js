/** Clear Input */
function updateUserClearance() {
	document.getElementById('name').value = "";
	document.getElementById('email').value = "";
	document.getElementById('type').value = "";
	document.getElementById('phone').value = "";
	document.getElementById('dob').value = "";
	document.getElementById("profile").value = "";
	document.getElementById("createUserProfile").removeAttribute('src');
}

/** Review Profile */
let loadFile = function (event) {
	let updateUserProfile = document.getElementById('updateUserProfile');
	updateUserProfile.src = URL.createObjectURL(event.target.files[0]);
	updateUserProfile.onload = function () {
		URL.revokeObjectURL(updateUserProfile.src);
	}
};