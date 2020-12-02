<!-- Banner
================================================== -->
<?php

$banner_indicator = '';
$banner_item = '';

$_banners = $this->cms->get_banners();
/*echo '<pre>';print_r($this->db->last_query());echo '</pre>';*/
if(count($_banners) > 0){

    ?>
    <section class="section slider_box">
        <div id="shopify-section-homepage-flexslider" class="shopify-section">
            <section class="main-slideshow">
                <div class="flexslider">
                    <ul class="slides">
                        <?php foreach ($_banners as $i => $banner): ?>
                            <li class="slide">
                                <a href="<?php echo $banner->link;?>">
                                    <img src="<?php echo asset_url('front/banners/' . $banner->image); ?>" class="slide-img desk-view" />
                                    <img src="<?php echo _img('assets/front/banners/' . $banner->image,550,603); ?>img/Sale_550x603e9dd.jpg" class="slide-img mob-view" />
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
            <script>
                $(function() {
                    var slider, // Global slider value to force playing and pausing by direct access of the slider control
                        canSlide = true; // Global switch to monitor video state

                    // Load the YouTube API. For some reason it's required to load it like this
                    var tag = document.createElement('script');
                    tag.src = "http://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                    // Setup a callback for the YouTube api to attach video event handlers
                    window.onYouTubeIframeAPIReady = function() {
                        // Iterate through all videos
                        $('.flexslider iframe').each(function() {
                            // Create a new player pointer; "this" is a DOMElement of the player's iframe
                            var player = new YT.Player(this, {
                                playerVars: {
                                    autoplay: 0
                                }
                            });

                            // Watch for changes on the player
                            player.addEventListener("onStateChange", function(state) {
                                switch (state.data) {
                                    // If the user is playing a video, stop the slider
                                    case YT.PlayerState.PLAYING:
                                        slider.flexslider("stop");
                                        canSlide = false;
                                        break;
                                    // The video is no longer player, give the go-ahead to start the slider back up
                                    case YT.PlayerState.ENDED:
                                    case YT.PlayerState.PAUSED:
                                        slider.flexslider("play");
                                        canSlide = true;
                                        break;
                                }
                            });

                            $(this).data('player', player);
                        });
                    }

                    // Setup the slider control
                    slider = $(".flexslider")
                        .flexslider({
                            animation: "fade",
                            easing: "swing",
                            slideshowSpeed: 8000,
                            animationSpeed: 500,
                            pauseOnHover: true,
                            pauseOnAction: true,
                            touch: true,
                            video: true,
                            controlNav: true,
                            directionNav: true,
                            keyboardNav: true,

                            slideshow: true,
                            useCSS: false,
                            // Before you go to change slides, make sure you can!
                            before: function() {
                                if (!canSlide)
                                    slider.flexslider("stop");
                            }
                        });

                    /*slider.on("click", ".flex-prev, .flex-next", function(){
                     canSlide = true;
                     $('.flexslider iframe').each(function(){
                     $(this).data('player').pauseVideo();
                     });
                     });*/
                });
            </script>
        </div>
    </section>
<?php }
?>




