// @ts-nocheck
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import '@picocss/pico/css/pico.min.css';
import '@picocss/pico';

import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.getElementById('base64').nextElementSibling.addEventListener('click', function copy() {
    // Get the text field
    var copyText = document.getElementById("base64");
  
    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.innerText);
} );