<!DOCTYPE html>
<!--
   /*
    * blueimp Gallery Demo
    * https://github.com/blueimp/Gallery
    *
    * Copyright 2013, Sebastian Tschan
    * https://blueimp.net
    *
    * Licensed under the MIT license:
    * https://opensource.org/licenses/MIT
    */
   -->
<html lang="en">
   <head>
      <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <![endif]-->
      <meta charset="utf-8" />
      <title>blueimp Gallery</title>
      <meta
         name="description"
         content="blueimp Gallery is a touch-enabled, responsive and customizable image and video gallery, carousel and lightbox, optimized for both mobile and desktop web browsers. It features swipe, mouse and keyboard navigation, transition effects, slideshow functionality, fullscreen support and on-demand content loading and can be extended to display additional content types."
         />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="/blue_gallary/css/blueimp-gallery.css" />
      <link rel="stylesheet" href="/blue_gallary/css/blueimp-gallery-indicator.css" />
      <link rel="stylesheet" href="/blue_gallary/css/blueimp-gallery-video.css" />
      <link rel="stylesheet" href="/blue_gallary/css/demo/demo.css" />
   </head>
   <body>
      <h2>Passport Attachments</h2>
      <!-- The container for the list of example images -->
      <div id="links">
        @foreach ($attachments as $attachment)
            <a href="{{ asset($attachment) }}" title="Passport Attachment">
                <img src="{{ asset($attachment) }}" alt="Passport Attachment" />
            </a>
        @endforeach

            <a href="{{asset('blue_gallery/img/sample_images/pexels-craig-adderley-1563355.jpg') }}" title="Apple">
            <img src="images/thumbnails/apple.jpg" alt="Apple" />
            </a>
            {{--  <a href="{{asset('blue_gallery/img/sample_images/pexels-david-besh-884788.jpg') }}" title="Orange">
           <img src="images/thumbnails/orange.jpg" alt="Orange" />
            </a>

            <a href="{{asset('blue_gallery/img/sample_images/pexels-egil-sjøholt-1906658.jpg') }}" title="Orange">
            <img src="images/thumbnails/orange.jpg" alt="Orange" />
            </a>
            <a href="{{asset('blue_gallery/img/sample_images/pexels-iconcom-1214259.jpg') }}" title="Orange">
            <img src="images/thumbnails/orange.jpg" alt="Orange" />
            </a>
            <a href="{{asset('blue_gallery/img/sample_images/pexels-pixabay-15239.jpg') }}" title="Orange">
            <img src="images/thumbnails/orange.jpg" alt="Orange" />
            </a> --}}
        </div>
        <!-- The Gallery as lightbox dialog -->
        <!-- The Gallery as lightbox dialog, should be a document body child element -->
            <div
                id="blueimp-gallery"
                class="blueimp-gallery blueimp-gallery-controls"
                aria-label="image gallery"
                aria-modal="true"
                role="dialog"
                >
                <div class="slides" aria-live="polite"></div>
                <h3 class="title"></h3>
                <a
            class="prev"
            aria-controls="blueimp-gallery"
            aria-label="previous slide"
            aria-keyshortcuts="ArrowLeft"
            ></a>
            <a
            class="next"
            aria-controls="blueimp-gallery"
            aria-label="next slide"
            aria-keyshortcuts="ArrowRight"
            ></a>
            <a
            class="close"
            aria-controls="blueimp-gallery"
            aria-label="close"
            aria-keyshortcuts="Escape"
            ></a>
            <a
            class="play-pause"
            aria-controls="blueimp-gallery"
            aria-label="play slideshow"
            aria-keyshortcuts="Space"
            aria-pressed="false"
            role="button"
            ></a>
            <ol class="indicator"></ol>
        </div>
      <script src="/blue_gallary/js/blueimp-helper.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery-fullscreen.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery-indicator.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery-video.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery-vimeo.js"></script>
      <script src="/blue_gallary/js/blueimp-gallery-youtube.js"></script>
      <script src="/blue_gallary/js/vendor/jquery.js"></script>
      <script src="/blue_gallary/js/jquery.blueimp-gallery.js"></script>
      <script>
        document.getElementById('links').onclick = function (event) {
          event = event || window.event
          var target = event.target || event.srcElement
          var link = target.src ? target.parentNode : target
          var options = { index: link, event: event }
          var links = this.getElementsByTagName('a')
          blueimp.Gallery(links, options)
        }
      </script>
   </body>
</html>
