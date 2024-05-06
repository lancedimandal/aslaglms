<?php
/* Template Name: Homepage */
get_header(); ?>
<html lang="en">

<head>
    <!-- Google Tag Manager V1 -->
    <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
    var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' +
    i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-KT8V457P');</script>
    <!-- End Google Tag Manager V1 -->

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KT8V457P');</script>
<!-- End Google Tag Manager -->

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>
    <section class="banner-section reveal">
        <div class="container">
            <div class="banner-wrapper">
                <div id="banner-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (get_field('banner')): ?>
                            <?php while (the_repeater_field('banner')): ?>
                                <!-- <div class="carousel-item" style="background: url(<?php the_sub_field('banner-image'); ?>);"> -->
                                <div class="carousel-item">
                                    <div class="banner-wrapper">
                                        <div class="product-banner">
                                            <div class="img-banner">
                                                <img class="banner-image-slice" src="<?php the_sub_field('banner-image'); ?>"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="text-background-wrapper">
                                            <h3 class="text-background">
                                                <?php the_sub_field('text_background_banner'); ?>
                                            </h3>
                                        </div>
                                        <div class="title-text-banner">
                                            <span class="subtitle">
                                                <?php the_sub_field('banner-subtitle'); ?>
                                            </span>
                                            <h1 class="title">
                                                <?php the_sub_field('banner-title'); ?>
                                            </h1>
                                            <p class="text banner-text-description">
                                                <?php the_sub_field('banner-text'); ?>
                                            </p>
                                            <div class="btn-holder">
                                                <div class="animated-arrow-shop">
                                                    <div class="line-container">
                                                        <div class="text left">
                                                            <a class="button-link"
                                                                href="<?php the_sub_field('button_1_url'); ?>">
                                                                <?php the_sub_field('button_1_text'); ?>
                                                            </a>
                                                        </div>
                                                        <div class="arrow-animation">
                                                            <hr><i class="fa-solid fa-play"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="animated-arrow-shop">
                                                    <div class="line-container">
                                                        <div class="text left">
                                                            <a class="button-link"
                                                                href="<?php the_sub_field('button_2_url'); ?>">
                                                                <?php the_sub_field('button_2_text'); ?>
                                                            </a>
                                                        </div>
                                                        <div class="arrow-animation">
                                                            <hr><i class="fa-solid fa-play"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <ul class="carousel-indicators">
                            <li data-target="#banner-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#banner-carousel" data-slide-to="1"></li>
                            <li data-target="#banner-carousel" data-slide-to="2"></li>
                            <li data-target="#banner-carousel" data-slide-to="3"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="all-in-one-section reveal">
        <div class="container">
            <div class="all-in-one-wrapper">
                <div class="title animate-slide-right">
                    <h2>
                        <?php the_field('all-in-one-title'); ?>
                    </h2>
                </div>
                <hr>
                <div class="subtitle title animate-slide-left">
                    <span>
                        <?php the_field('all-in-one-subtitle'); ?>
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="learn-more-section reveal">
        <div class="container">
            <div class="learn-more-wrapper">
                <?php if (get_field('learn_more_items')): ?>
                    <?php while (the_repeater_field('learn_more_items')): ?>
                        <div class="learn-more-item animate-slide-up">
                            <img class="learn-more-image" src="<?php the_sub_field('image'); ?>" alt="Learn More" />
                            <div class="title-text">
                                <h3>
                                    <?php the_sub_field('title'); ?>
                                </h3>
                                <p>
                                    <?php the_sub_field('subtitle'); ?>
                                </p>
                                <?php if (get_sub_field('button_text')): ?>
                                    <div class="animated-arrow-shop">
                                        <div class="line-container">
                                            <div class="text left">
                                                <a class="button-link" href="<?php the_sub_field('button_url'); ?>">
                                                    <?php the_sub_field('button_text'); ?>
                                                </a>
                                            </div>
                                            <div class="arrow-animation">
                                                <hr><i class="fa-solid fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="customer-reviews-section reveal">
        <div class="container">
            <div class="customer-reviews-wrapper animate-slide-up">
                <div class="sub-title-text">
                    <p class="subtitle">
                        <?php the_field('review-subtitle'); ?>
                    </p>
                    <h3>
                        <?php the_field('review-title'); ?>
                    </h3>
                    <p class="text">
                        <?php the_field('review-text'); ?>
                    </p>
                </div>
                <div class="customer-review-items">
                    <?php if (get_field('customer_items')): ?>
                        <?php while (the_repeater_field('customer_items')): ?>
                            <div class="customer-review-item">
                                <img class="customer-image" src="<?php the_sub_field('image'); ?>" alt="Customer Review" />
                                <div class="title-text">
                                    <h3>
                                        <?php the_sub_field('title'); ?>
                                    </h3>
                                    <p>
                                        <?php the_sub_field('text'); ?>
                                    </p>
                                </div>
                                <div class="btn-holder">
                                    <?php if (get_sub_field('button_text')): ?>
                                        <div class="animated-arrow-shop reverse">
                                            <div class="line-container">
                                                <div class="text left">
                                                    <a class="button-link" href="<?php the_sub_field('button_url'); ?>">
                                                        <?php the_sub_field('button_text'); ?>
                                                    </a>
                                                </div>
                                                <div class="arrow-animation">
                                                    <hr><i class="fa-solid fa-play"></i>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="how-to-dress-section reveal">
        <div class="container">
            <div class="how-to-dress-wrapper animate-slide-up">
                <div class="title-subtitle">
                    <div class="title animate-slide-right">
                        <h2>
                            <?php the_field('how-to-title'); ?>
                        </h2>
                    </div>
                    <hr>
                    <div class="subtitle animate-slide-left">
                        <p>
                            <?php the_field('how-to-subtitle'); ?>
                        </p>
                    </div>
                </div>
                <div class="video-items">
                    <?php if (get_field('how_to_videos')): ?>
                        <?php while (the_repeater_field('how_to_videos')): ?>
                            <div class="video-item">
                                <div id="poster-image-htd"
                                    style="background-image: url(<?php the_sub_field('poster_image'); ?>);"></div>
                                <?php the_sub_field('video'); ?>
                                <div class="title-text-btn">
                                    <span class="subtitle">
                                        <?php the_sub_field('subtitle'); ?>
                                    </span>
                                    <h3>
                                        <?php the_sub_field('title'); ?>
                                    </h3>
                                    <p class="text">
                                        <?php the_sub_field('text'); ?>
                                    </p>
                                    <?php if (get_sub_field('button_text')): ?>
                                        <div class="animated-arrow-shop">
                                            <div class="line-container">
                                                <div class="text left">
                                                    <a class="button-link" href="<?php the_sub_field('button_url'); ?>">
                                                        <?php the_sub_field('button_text'); ?>
                                                    </a>
                                                </div>
                                                <div class="arrow-animation">
                                                    <hr><i class="fa-solid fa-play"></i>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="reasons-to-choose-section reveal">
        <div class="container">
            <div class="reasons-to-choose-wrapper">
                <div class="title-subtitle">
                    <div class="title animate-slide-right">
                        <h2>
                            <?php the_field('reasons-title'); ?>
                        </h2>
                    </div>
                    <hr>
                    <div class="subtitle animate-slide-left">
                        <p>
                            <?php the_field('reasons-subtitle'); ?>
                        </p>
                    </div>
                </div>
                <div class="texts-orders-image">
                    <div class="text-order-image-a">
                        <?php if (get_field('text_number_a')): ?>
                            <?php while (the_repeater_field('text_number_a')): ?>
                                <div class="text-number-a n<?php the_sub_field('number'); ?>">
                                    <div class="text">
                                        <h3>
                                            <?php the_sub_field('title'); ?>
                                        </h3>
                                        <p>
                                            <?php the_sub_field('text'); ?>
                                        </p>
                                    </div>
                                    <p class="number">
                                        <?php the_sub_field('number'); ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="image animate-slide-up">
                        <!-- 							<img class="under-img" src="<?php the_field('reasons_image'); ?>" alt="Easy Reach Underwear" /> -->
                        <?php the_field('reasons_image'); ?>
                    </div>
                    <div class="text-order-image-b">
                        <?php if (get_field('text_number_b')): ?>
                            <?php while (the_repeater_field('text_number_b')): ?>
                                <div class="text-number-b n<?php the_sub_field('number'); ?>">
                                    <p class="number">
                                        <?php the_sub_field('number'); ?>
                                    </p>
                                    <div class="text">
                                        <h3>
                                            <?php the_sub_field('title'); ?>
                                        </h3>
                                        <p>
                                            <?php the_sub_field('text'); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="the-easyreach-section reveal">
        <div class="container">
            <div class="the-easyreach-wrapper">
                <div class="title animate-slide-right">
                    <h2>
                        <?php the_field('promise-title'); ?>
                    </h2>
                </div>
                <hr>
                <div class="subtitle animate-slide-left">
                    <p>
                        <?php the_field('promise-subtitle'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="case-studies-section reveal">
        <div class="container">
            <div class="case-studies-wrapper">
                <div class="case-studies-quote  animate-slide-right">
                    <div class="title-text animate-slide-right-1">
                        <h3>
                            <?php the_field('left-case-title'); ?>
                        </h3>
                        <p class="subtitle">
                            <?php the_field('left-case-text'); ?>
                        </p>
                    </div>
                    <div id="poster-image-case"
                        style="background-image: url(<?php the_field('poster_image_case'); ?>);"></div>
                    <?php the_field('case-video'); ?>
                </div>
                <div class="case-studies-text animate-slide-left">
                    <div class="title-subtitle">
                        <p class="subtitle">
                            <?php the_field('right-case-subtitle'); ?>
                        </p>
                        <h3>
                            <?php the_field('right-case-title'); ?>
                        </h3>
                        <p class="text">
                            <?php the_field('right-case-text'); ?>
                        </p>
                    </div>
                    <div class="title-text author">
                        <h3>
                            <?php the_field('customer_name'); ?>
                        </h3>
                        <p class="subtitle author">
                            <?php the_field('customer_subtitle'); ?>
                    </div>
                    <?php if (get_field('qa')): ?>
                        <?php while (the_repeater_field('qa')): ?>
                            <div class="title-text">
                                <h3>
                                    <?php the_sub_field('question'); ?>
                                </h3>
                                <p class="subtitle">
                                    <?php the_sub_field('answer'); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <div class="animated-arrow-shop">
                        <div class="line-container">
                            <div class="text left">
                                <a class="button-link animate-slide-left-1" href="<?php the_field('button_url'); ?>">
                                    <?php the_field('button_text'); ?>
                                </a>
                            </div>
                            <div class="arrow-animation">
                                <hr><i class="fa-solid fa-play"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="post-surgery-section reveal">
        <div class="container">
            <div class="post-surgery-wrapper">
                <div class="post-surgery-text">
                    <div class="title-subtitle">
                        <p class="subtitle animate-slide-right-1">
                            <?php the_field('post-subtitle') ?>
                        </p>
                        <a class="play-link" href="#">
                            <p class="play">PLAY</p>
                        </a>
                        <a class="play-full-link" href="#">
                            <p class="play-full">PLAY FULL</p>
                        </a>
                        <img class="span-play" src="/wp-content/uploads/2023/04/play_arrow-1.png" alt="Play" />
                    </div>
                    <div class="text-video">
                        <div class="title-text animate-slide-right"
                            style="background-image: url('/wp-content/uploads/2023/04/image_2023_02_16T01_35_07_577Z-3.webp');">
                            <h2>
                                <?php the_field('post-title') ?>
                            </h2>
                        </div>
                        <div class="post-surgery-video">
                            <div class="video animate-slide-left"
                                style="background-image: url('/wp-content/uploads/2023/04/laptop-1024x587-1-1.webp');">
                                <div id="poster-image"
                                    style="background-image: url(<?php the_field('poster_image_post'); ?>);"></div>
                                <?php the_field('post-video') ?>
                                <div class="btn-holder">
                                    <div class="animated-arrow-shop">
                                        <div class="line-container">
                                            <div class="text left">
                                                <?php $link = get_field('button-women');
                                                if ($link):
                                                    $link_url = $link['url'];
                                                    $link_title = $link['title'];
                                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                                    ?>
                                                    <a class="button-link" href="<?php echo esc_url($link_url); ?>"
                                                        target="<?php echo esc_attr($link_target); ?>">
                                                        <?php echo esc_html($link_title); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="arrow-animation">
                                                <hr><i class="fa-solid fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="animated-arrow-shop">
                                        <div class="line-container">
                                            <div class="text left">
                                                <?php $link = get_field('button-men');
                                                if ($link):
                                                    $link_url = $link['url'];
                                                    $link_title = $link['title'];
                                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                                    ?>
                                                    <a class="button-link" href="<?php echo esc_url($link_url); ?>"
                                                        target="<?php echo esc_attr($link_target); ?>">
                                                        <?php echo esc_html($link_title); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="arrow-animation">
                                                <hr><i class="fa-solid fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    jQuery(document).ready(function ($) {
        // Homepage How to Dress
        $('.video-item #poster-image-htd').each(function (i) {
            var $this = $(this);
            var newClass = "htd" + i++;
            $this.addClass(newClass);
        });
        document.getElementsByClassName("htd0").onclick = function () { fadeImage() };
        function fadeImage() {
            document.getElementsByClassName("htd0").style.opacity = "0";
        }

        $(".htd0").click(function () {
            $(".htd0").remove();
        });

        $('.htd0').on('click', function (ev) {
            $("#video-htd-0")[0].src += "&autoplay=1";
            ev.preventDefault();
        });


        document.getElementsByClassName("htd1").onclick = function () { fadeImage() };
        function fadeImage() {
            document.getElementByClassName("htd1").style.opacity = "0";
        }

        $(".htd1").click(function () {
            $(".htd1").remove();
        });

        $('.htd1').on('click', function (ev) {
            $("#video-htd-1")[0].src += "&autoplay=1";
            ev.preventDefault();
        });

        document.getElementsByClassName("htd2").onclick = function () { fadeImage() };
        function fadeImage() {
            document.getElementsByClassName("htd2").style.opacity = "0";
        }

        $(".htd2").click(function () {
            $(".htd2").remove();
        });

        $('.htd2').on('click', function (ev) {
            $("#video-htd-2")[0].src += "&autoplay=1";
            ev.preventDefault();
        });

        document.getElementById("poster-image-case").onclick = function () { fadeImage() };
        function fadeImage() {
            document.getElementById("poster-image-case").style.opacity = "0";
        }

        $("#poster-image-case").click(function () {
            $("#poster-image-case").remove();
        });

        $('#poster-image-case').on('click', function (ev) {
            $("#video-case-1")[0].src += "&autoplay=1";
            ev.preventDefault();
        });

        document.getElementById("poster-image").onclick = function () { fadeImage() };
        function fadeImage() {
            document.getElementById("poster-image").style.opacity = "0";
        }

        $("#poster-image").click(function () {
            $("#poster-image").remove();
        });

        $('#poster-image').on('click', function (ev) {
            $("#video-main")[0].src += "&autoplay=1";
            ev.preventDefault();
        });
    });  
</script>

</html>
<?php get_footer(); ?>