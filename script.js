function copyToClipboard(id) {
  /* Get the text field */
//   alert("NI");

  var copyText = document.getElementById(id);
  var text = copyText.innerHTML;

  /* Select the text field */
//   copyText.select();
//   copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */

   if (text != "-") {
    navigator.clipboard.writeText(text);
   }

  /* Alert the copied text */
//   alert(text);
}