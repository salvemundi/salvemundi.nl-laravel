/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = window.jQuery = require('jquery'); // <-- main, not 'slim'
require('jquery-ui');
window.Popper = require('popper.js');
require('bootstrap');

require('bootstrap-table');
require('bootstrap-tooltip');
require('slick-carousel');
// require('');
// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

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
  } else {
      $('.navbar').removeClass('affix');
      $('.imgNavbar').removeClass('affix-img');
      $('.dropdown-content').removeClass('affix-dropdown');
  }
});

$(function() {
    $('.slider').slick({
        slidesToShow: 5,
        autoplay: true,
        speed: 500,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        cssEase: 'linear',
        arrows: true,
        //variableWidth: true,
        //centerMode: true,
        nextArrow: '<button type="button" unselectable="on" class="slick-right"></button>',
        prevArrow: '<button type="button" unselectable="on" class="slick-left"></button>',
        responsive: [
          {
            breakpoint: 1800,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1,
              infinite: true,
              dots: true,
              arrows: true
            }
          },
          {
            breakpoint: 1477,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
              dots: true,
              arrows: true
            }
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
              dots: true,
              arrows: false
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false
            }
          }
      ]
    });
    $('.imgSlider').slick({
      dots: false,
      infinite: true,
      autoplay: true,
      speed: 500,
      fade: true,
      arrows: false,
      cssEase: 'linear'
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


// activities form submit
window.onload = function(){
  const linkActEl = document.getElementById("linkActivity");

  if(linkActEl)
    linkActEl.onclick = ()=> document.getElementById("formActivity").submit();
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

var testDiv = `<br> <div class="input-group mb-3 test">
<div class="input-group mb-3 test">
    <div class="input-group-prepend">
        <div class="custom-file" style="width: 80px;">
            <div class="custom-file" style="width: 80px;">
                <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                <input type="file" onchange="CopyMe(this, 'txtFileName');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01"> `+`
            </div>
        </div>
        <div class="custom-file form-control">
            <input style="border: hidden;" id="txtFileName" type="text" readonly="readonly" />
        </div>
    </div>
  </div>
</div>`;

myClickOnUrHand = function ()
{
  document.getElementById("demo").innerHTML = testDiv;
};
