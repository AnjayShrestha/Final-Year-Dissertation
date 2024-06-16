// to set header part
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("head").style.marginBottom = "20%";

  } else {
    document.getElementById("head").style.marginBottom = "10%";
  }
}