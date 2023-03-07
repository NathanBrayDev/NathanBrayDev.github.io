let slideIndex = 1;
window.onload = function() {
  showSlides(slideIndex);
};

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {
    slideIndex = 1
  }
  if (n < 1) {
    slideIndex = slides.length
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" current", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " current";
}

function ToggleVisibility(textDivClass, buttonDivClass) {
  var els = document.getElementsByClassName(textDivClass);
  for (var i = 0; i < els.length; i++) {
    els[i].style.display = els[i].style.display == "none" ? "block" : "none";
  }
  var button = document.getElementById(buttonDivClass);
  if (button.style.color != "white") {
    button.style.color = "white";
    button.style.backgroundColor = "#8B0000";
    button.style.padding = "3vh 0";
  } else {
    button.style.color = "black";
    button.style.backgroundColor = "white";
    button.style.padding = "1vh 0";
  }
}
