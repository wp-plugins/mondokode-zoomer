


function mondoKode_zoom_createOverlay(name) {
	original = document.getElementById(name);
	copy = original.cloneNode(true);
	copy.id = "newID";
	copy.className = "wp_syntax wp_syntax_zoomed";
  
  // Remove the wp_syntax style class from the hidden 
  // div that we will be zooming because it interferes
  // with the fancy background.
  original.className="overlay";
	
  parent = original.parentNode;
	parent.insertBefore(copy, original);
}