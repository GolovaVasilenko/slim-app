<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free responsive business website template</title>
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/icons.css">
    <link rel="stylesheet" href="css/responsee.css">
    <link rel="stylesheet" href="owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="owl-carousel/owl.theme.css">
    <!-- CUSTOM STYLE -->
    <link rel="stylesheet" href="css/template-style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
</head>
<body class="size-1140">
<header>
    <nav>
        <div class="line">
            <div class="top-nav">
                <div class="logo logo-small">
                    <a href="index.html">DESIGN <br /><strong>THEME</strong></a>
                </div>
                <p class="nav-text">Custom menu text</p>
                <div class="top-nav s-12 l-5">
                    <ul class="right top-ul chevron">
                        <li><a href="index.html">Home</a>
                        </li>
                        <li><a href="product.html">Product</a>
                        </li>
                        <li><a href="services.html">Services</a>
                        </li>
                    </ul>
                </div>
                <ul class="s-12 l-2">
                    <li class="logo hide-s hide-m">
                        <a href="index.html">DESIGN <br /><strong>THEME</strong></a>
                    </li>
                </ul>
                <div class="top-nav s-12 l-5">
                    <ul class="top-ul chevron">
                        <li><a href="gallery.html">Gallery</a>
                        </li>
                        <li>
                            <a>Company</a>
                            <ul>
                                <li><a>Company 1</a>
                                </li>
                                <li><a>Company 2</a>
                                </li>
                                <li>
                                    <a>Company 3</a>
                                    <ul>
                                        <li><a>Company 3-1</a>
                                        </li>
                                        <li><a>Company 3-2</a>
                                        </li>
                                        <li><a>Company 3-3</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<?=$content;?>
<!-- FOOTER -->
<footer>
    <div class="line">
        <div class="s-12 l-6">
            <p>Copyright 2019, Vision Design - graphic zoo
            </p>
        </div>
        <div class="s-12 l-6">
            <p class="right">
                <a class="right" href="http://www.myresponsee.com" title="Responsee - lightweight responsive framework">Design and coding by Responsee Team</a>
            </p>
        </div>
    </div>
</footer>
<script type="text/javascript" src="js/responsee.js"></script>
<script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var owl = $('#header-carousel');
        owl.owlCarousel({
            nav: true,
            dots: false,
            items: 1,
            loop: true,
            navText: ["&#xf007","&#xf006"],
            autoplay: true,
            autoplayTimeout: 4000
        });
        var owl = $('#news-carousel');
        owl.owlCarousel({
            nav: true,
            dots: false,
            items: 1,
            loop: true,
            navText: ["&#xf007","&#xf006"],
            autoplay: true,
            autoplayTimeout: 4000
        });
    });

</script>
</body>
</html>