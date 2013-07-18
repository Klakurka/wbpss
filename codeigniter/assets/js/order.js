function order(parent){
	// If the bar that was clicked was the last bar to be clicked...
	if (document.getElementById('order').value === parent.id){
		// Change from Ascending to Descending, or Vice versa.
		if(document.getElementById('dir').value === "asc"){
			document.getElementById('dir').value = "desc";
		} else {
			document.getElementById('dir').value = "asc";
		}
	// Otherwise, set it to the value associated with that bar.
	// This should probably be rewritten in a way that doesn't give away the database names
	} else {
		document.getElementById('order').value = parent.id;
		document.getElementById('dir').value = "asc";
	}
	//I need the form to submit to change anything, it's going through the model.
	document.metaForm.submit();
}