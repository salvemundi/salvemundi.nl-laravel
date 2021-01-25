/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-table');
require('slick-carousel');
// require('');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
    if ($(document).scrollTop() > 800) {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos < currentScrollPos) {
            document.getElementById("TopNavbar").style.top = "-100px";
        } else {
            document.getElementById("TopNavbar").style.top = "0";
        }
        prevScrollpos = currentScrollPos;
    }
}

$(window).scroll(function() {
  if ($(document).scrollTop() > 300) {
      $('.navbar').addClass('affix');
      $('.imgNavbar').addClass('affix-img');
      $('.dropdown-content').addClass('affix-dropdown');
      console.log("OK");
  } else {
      $('.navbar').removeClass('affix');
      $('.imgNavbar').removeClass('affix-img');
      $('.dropdown-content').removeClass('affix-dropdown');
  }
});

$(function() {
    $('.slider').slick({
        slidesToShow: 1,
        autoplay: true,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        cssEase: 'linear',
        arrows: true,
        nextArrow: '<button type="button" unselectable="on" class="slick-right"></button>',
        prevArrow: '<button type="button" unselectable="on" class="slick-left"></button>',
    });
});
// vid=document.getElementById("vid")
// vid.disablePictureInPicture = true
window.myFunction = function myFunction() {
    document.getElementById("dropdown").classList.toggle("show");
  }

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
