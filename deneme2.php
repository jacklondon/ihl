<style>
/** LIGHTBOX MARKUP **/

.lightbox {
  /* Default to hidden */
  display: none;

  /* Overlay entire screen */
  position: fixed;
  z-index: 999;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  
  /* A bit of padding around image */
  padding: 1em;

  /* Translucent background */
  background: rgba(0, 0, 0, 0.8);
}

/* Unhide the lightbox when it's the target */
.lightbox:target {
  display: block;
}

.lightbox span {
  /* Full width and height */
  display: block;
  width: 100%;
  height: 100%;

  /* Size and position background image */
  background-position: center;
  background-repeat: no-repeat;
  background-size: contain;
}
</style>

<!-- Lightbox usage markup -->
<link href="https://fonts.googleapis.com/css?family=Raleway:200,100,400" rel="stylesheet" type="text/css" />


<!-- thumbnail image wrapped in a link -->
<a href="#img1">
  <img src="https://picsum.photos/seed/9/500/300">
</a>

<!-- lightbox container hidden with CSS -->
<a href="#" class="lightbox" id="img1">
  <span style="background-image: url('https://picsum.photos/seed/9/900/450')"></span>
</a>


