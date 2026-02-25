<!DOCTYPE html>
<html lang="en">
<script>
    var link = document.querySelector("link[rel~='icon']");
    if (!link) {
        link = document.createElement('link');
        link.rel = 'icon';
        document.getElementsByTagName('head')[0].appendChild(link);
    }
    link.href = "<?php echo e(asset($generalsetting->favicon ?? 'default-favicon.ico')); ?>";
</script>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e($generalsetting->name ?? 'Site Name'); ?></title>
    <!-- Google Fonts -->
    <meta name="application-name" content="<?php echo e($generalsetting->name); ?>">
    <meta property="og:site_name" content="<?php echo e($generalsetting->name); ?>">
   

  
    <!-- App favicon -->


    <!-- <?php if($generalsetting?->favicon): ?>
<link rel="shortcut icon" href="<?php echo e(asset($generalsetting->favicon)); ?>" />
<?php else: ?>
<link rel="shortcut icon" href="<?php echo e(asset('default-favicon.ico')); ?>" />
<?php endif; ?> -->
    <?php if($generalsetting?->favicon): ?>
        <link rel="icon" href="<?php echo e(asset($generalsetting->favicon)); ?>" sizes="48x48" type="image/png">
        <link rel="apple-touch-icon" href="<?php echo e(asset($generalsetting->favicon)); ?>" sizes="48x48">
    <?php else: ?>
        <link rel="icon" href="<?php echo e(asset('default-favicon.ico')); ?>" sizes="48x48" type="image/png">
        <link rel="apple-touch-icon" href="<?php echo e(asset('default-favicon.ico')); ?>" sizes="48x48">
    <?php endif; ?>


    <meta name="author" content="<?php echo e($generalsetting->name); ?>" />
    <link rel="canonical" href="https://nmfashionworld.com" />
    <!-- Organization Schema -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "NM Fashion",
  "alternateName": "NM Fashion",
  "url": "https://nmfashionworld.com",
  "logo": "<?php echo e(asset($generalsetting->favicon ?? 'default-favicon.ico')); ?>",
  "sameAs": [
    "https://www.facebook.com/yourpage",
    "https://www.instagram.com/yourpage",
    "https://www.youtube.com/yourchannel"
  ]
}
</script>

    <!-- WebSite Schema + SearchAction -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "NM Fashion",
  "alternateName": "NM Fashion",
  "url": "https://nmfashionworld.com",
  "publisher": {
    "@type": "Organization",
    "name": "NM Fashion",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo e(asset($generalsetting->favicon ?? 'default-favicon.ico')); ?>"
    }
  },
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://nmfashionworld.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>


    <?php echo $__env->yieldPushContent('seo'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.0/css/all.css">
    

   
   

    <?php if(!empty($generalsetting?->facebook_verification)): ?>
        <meta name="facebook-domain-verification" content="<?php echo e($generalsetting->facebook_verification); ?>" />
    <?php endif; ?>

    <?php if(!empty($generalsetting) && !empty($generalsetting->google_verification)): ?>
        <meta name="google-site-verification" content="<?php echo e($generalsetting->google_verification); ?>" />
    <?php endif; ?>






    <?php $__currentLoopData = $pixels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pixel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Facebook Pixel Code -->
        <script>
            !(function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
            fbq("init", "<?php echo e($pixel->code); ?>");
            fbq("track", "PageView");
        </script>
        <noscript>
            <img height="1" width="1" style="display: none;"
                src="https://www.facebook.com/tr?id=<?php echo e($pixel->code); ?>&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $gtm_code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gtm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Google tag (gtag.js) -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })
            (window, document, 'script', 'dataLayer', 'GTM-<?php echo e($gtm->code); ?>');
        </script>
        <!-- End Google Tag Manager -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(!empty($generalsetting?->header_code)): ?>
        <?php echo $generalsetting->header_code; ?>

    <?php endif; ?>

</head>


<body class="gotop">
 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display:none;">

  <!-- Existing icons -->
  <symbol id="star" viewBox="0 0 13 12" fill="currentColor">
    <path d="M6.54688 9.49266L10.3128 11.7656L9.31344 7.48172L12.6406 4.59937L8.25922 4.22766L6.54688 0.1875L4.83453 4.22766L0.453125 4.59937L3.78031 7.48172L2.78094 11.7656L6.54688 9.49266Z"></path>
  </symbol>

  <symbol id="heart" viewBox="0 0 18 16" fill="currentColor">
    <path d="M8.80654 13.5586L8.71935 13.6458L8.62343 13.5586C4.48174 9.80054 1.74387 7.31553 1.74387 4.79564C1.74387 3.05177 3.05177 1.74387 4.79564 1.74387C6.13842 1.74387 7.44632 2.6158 7.90845 3.80164H9.53025C9.99237 2.6158 11.3003 1.74387 12.6431 1.74387C14.3869 1.74387 15.6948 3.05177 15.6948 4.79564C15.6948 7.31553 12.9569 9.80054 8.80654 13.5586ZM12.6431 0C11.1259 0 9.66975 0.706267 8.71935 1.81362C7.76894 0.706267 6.31281 0 4.79564 0C2.11008 0 0 2.10136 0 4.79564C0 8.08283 2.96458 10.7771 7.45504 14.849L8.71935 16L9.98365 14.849C14.4741 10.7771 17.4387 8.08283 17.4387 4.79564C17.4387 2.10136 15.3286 0 12.6431 0Z"></path>
  </symbol>

  <symbol id="heart-filled" viewBox="0 0 20 20" fill="currentColor">
    <path d="M10 3.22l-0.61-0.6c-0.983-0.931-2.314-1.504-3.779-1.504-3.038 0-5.5 2.462-5.5 5.5 0 1.462 0.571 2.791 1.501 3.776l-0.002-0.003 8.39 8.39 8.39-8.4c0.928-0.983 1.499-2.312 1.499-3.774 0-3.038-2.462-5.5-5.5-5.5-1.465 0-2.796 0.573-3.782 1.506l0.003-0.002-0.61 0.61z"></path>
  </symbol>

  <!-- Trash, cross-arrow, check, eye, arrow-left/right-long, shopping-bag -->
  <symbol id="trash" viewBox="0 0 16 16" fill="currentColor">
    <path d="M1.6 4.8H14.4V15.2C14.4 15.4122 14.3157 15.6157 14.1657 15.7657C14.0157 15.9157 13.8122 16 13.6 16H2.4C2.18783 16 1.98434 15.9157 1.83431 15.7657C1.68429 15.6157 1.6 15.4122 1.6 15.2V4.8ZM3.2 6.4V14.4H12.8V6.4H3.2ZM5.6 8H7.2V12.8H5.6V8ZM8.8 8H10.4V12.8H8.8V8ZM4 2.4V0.8C4 0.587827 4.08429 0.384344 4.23431 0.234315C4.38434 0.0842854 4.58783 0 4.8 0H11.2C11.4122 0 11.6157 0.0842854 11.7657 0.234315C11.9157 0.384344 12 0.587827 12 0.8V2.4H16V4H0V2.4H4ZM5.6 1.6V2.4H10.4V1.6H5.6Z"></path>
  </symbol>

  <!-- New system icon (like fa-home) -->
  <symbol id="system" viewBox="0 0 24 24" fill="currentColor">
    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
  </symbol>
  <!-- Home icon -->
<symbol id="home" viewBox="0 0 21 21" fill="currentColor">
  <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
</symbol>


</svg>
   
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><symbol id="star" viewBox="0 0 13 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6.54688 9.49266L10.3128 11.7656L9.31344 7.48172L12.6406 4.59937L8.25922 4.22766L6.54688 0.1875L4.83453 4.22766L0.453125 4.59937L3.78031 7.48172L2.78094 11.7656L6.54688 9.49266Z"></path></symbol><symbol id="heart" viewBox="0 0 18 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8.80654 13.5586L8.71935 13.6458L8.62343 13.5586C4.48174 9.80054 1.74387 7.31553 1.74387 4.79564C1.74387 3.05177 3.05177 1.74387 4.79564 1.74387C6.13842 1.74387 7.44632 2.6158 7.90845 3.80164H9.53025C9.99237 2.6158 11.3003 1.74387 12.6431 1.74387C14.3869 1.74387 15.6948 3.05177 15.6948 4.79564C15.6948 7.31553 12.9569 9.80054 8.80654 13.5586ZM12.6431 0C11.1259 0 9.66975 0.706267 8.71935 1.81362C7.76894 0.706267 6.31281 0 4.79564 0C2.11008 0 0 2.10136 0 4.79564C0 8.08283 2.96458 10.7771 7.45504 14.849L8.71935 16L9.98365 14.849C14.4741 10.7771 17.4387 8.08283 17.4387 4.79564C17.4387 2.10136 15.3286 0 12.6431 0Z"></path></symbol><symbol id="heart-filled" viewBox="0 0 20 20"><path d="M10 3.22l-0.61-0.6c-0.983-0.931-2.314-1.504-3.779-1.504-3.038 0-5.5 2.462-5.5 5.5 0 1.462 0.571 2.791 1.501 3.776l-0.002-0.003 8.39 8.39 8.39-8.4c0.928-0.983 1.499-2.312 1.499-3.774 0-3.038-2.462-5.5-5.5-5.5-1.465 0-2.796 0.573-3.782 1.506l0.003-0.002-0.61 0.61z"></path></symbol><symbol id="trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"><path d="M1.6 4.8H14.4V15.2C14.4 15.4122 14.3157 15.6157 14.1657 15.7657C14.0157 15.9157 13.8122 16 13.6 16H2.4C2.18783 16 1.98434 15.9157 1.83431 15.7657C1.68429 15.6157 1.6 15.4122 1.6 15.2V4.8ZM3.2 6.4V14.4H12.8V6.4H3.2ZM5.6 8H7.2V12.8H5.6V8ZM8.8 8H10.4V12.8H8.8V8ZM4 2.4V0.8C4 0.587827 4.08429 0.384344 4.23431 0.234315C4.38434 0.0842854 4.58783 0 4.8 0H11.2C11.4122 0 11.6157 0.0842854 11.7657 0.234315C11.9157 0.384344 12 0.587827 12 0.8V2.4H16V4H0V2.4H4ZM5.6 1.6V2.4H10.4V1.6H5.6Z" fill="currentColor"></path></symbol><symbol id="cross-arrow" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6.59 5.17L1.41 0L0 1.41L5.17 6.58L6.59 5.17ZM10.5 0L12.54 2.04L0 14.59L1.41 16L13.96 3.46L16 5.5V0H10.5ZM10.83 9.41L9.42 10.82L12.55 13.95L10.5 16H16V10.5L13.96 12.54L10.83 9.41Z"></path></symbol><symbol id="check" viewBox="0 0 16 12"><path d="M0 6.5105L5.4791 12.0001L16 1.48956L14.4896 0L5.4791 8.99999L1.48953 5.01045L0 6.5105Z"></path></symbol><symbol id="eye" viewBox="0 0 19 12"><path d="M18.7079 5.6338C18.5397 5.40371 14.5321 0 9.4137 0C4.29527 0 0.287485 5.40371 0.119471 5.63358C0.041836 5.73994 0 5.86821 0 5.99989C0 6.13157 0.041836 6.25984 0.119471 6.3662C0.287485 6.59629 4.29527 12 9.4137 12C14.5321 12 18.5397 6.59625 18.7079 6.36638C18.7857 6.26008 18.8276 6.13179 18.8276 6.00009C18.8276 5.86839 18.7857 5.74011 18.7079 5.6338ZM9.4137 10.7586C5.64343 10.7586 2.37798 7.17207 1.41133 5.99958C2.37673 4.82605 5.63534 1.24137 9.4137 1.24137C13.1838 1.24137 16.449 4.8273 17.4161 6.00042C16.4507 7.17391 13.1921 10.7586 9.4137 10.7586Z"></path><path d="M9.4137 2.27586C7.36024 2.27586 5.68954 3.94656 5.68954 6.00002C5.68954 8.05348 7.36024 9.72417 9.4137 9.72417C11.4672 9.72417 13.1379 8.05348 13.1379 6.00002C13.1379 3.94656 11.4672 2.27586 9.4137 2.27586ZM9.4137 8.48276C8.04465 8.48276 6.93095 7.36903 6.93095 6.00002C6.93095 4.63101 8.04469 3.51727 9.4137 3.51727C10.7827 3.51727 11.8964 4.63101 11.8964 6.00002C11.8964 7.36903 10.7827 8.48276 9.4137 8.48276Z"></path></symbol><symbol id="arrow-left-long" viewBox="0 0 7 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 11L0 5.5L5.5 0L6.47625 0.97625L1.9525 5.5L6.47625 10.0238L5.5 11Z" fill="currentColor"></path></symbol><symbol id="arrow-right-long" viewBox="0 0 7 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 11L7 5.5L1.5 0L0.52375 0.97625L5.0475 5.5L0.52375 10.0238L1.5 11Z" fill="currentColor"></path></symbol><symbol id="shopping-bag" viewBox="0 0 14 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M13.2222 16H0.777778C0.571498 16 0.373667 15.9157 0.227806 15.7657C0.0819442 15.6157 0 15.4122 0 15.2V0.8C0 0.587827 0.0819442 0.384344 0.227806 0.234315C0.373667 0.0842854 0.571498 0 0.777778 0H13.2222C13.4285 0 13.6263 0.0842854 13.7722 0.234315C13.9181 0.384344 14 0.587827 14 0.8V15.2C14 15.4122 13.9181 15.6157 13.7722 15.7657C13.6263 15.9157 13.4285 16 13.2222 16ZM12.4444 14.4V1.6H1.55556V14.4H12.4444ZM4.66667 3.2V4.8C4.66667 5.43652 4.9125 6.04697 5.35008 6.49706C5.78767 6.94714 6.38116 7.2 7 7.2C7.61884 7.2 8.21233 6.94714 8.64992 6.49706C9.0875 6.04697 9.33333 5.43652 9.33333 4.8V3.2H10.8889V4.8C10.8889 5.86087 10.4792 6.87828 9.74986 7.62843C9.02055 8.37857 8.0314 8.8 7 8.8C5.9686 8.8 4.97945 8.37857 4.25014 7.62843C3.52083 6.87828 3.11111 5.86087 3.11111 4.8V3.2H4.66667Z"></path></symbol></svg>
    <?php $subtotal = Cart::instance('shopping')->subtotal(); ?>
    <div class="mobile-menu">
        <input type="checkbox" name="abc" id="abc" checked style="display: none;">
        <input type="checkbox" name="abce" id="abce" checked style="display: none;">
        <div class="mobile-menu-logo">
            <!-- <div class="logo-image">
                <img src="<?php echo e(asset($generalsetting?->white_logo ?? 'default-logo.png')); ?>" alt="Logo" />

            </div> -->
            <div class="mobile-menu-close">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <ul class="first-nav">
            <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
            
            <li class="drawer-menu"><label for="abc"><a>Categories</a>
                    <span class="menu-category-toggle set1">
                        <i class="fa fa-chevron-down"></i>
                        
                    </span>
                </label>


                <ul class="forth-nav">
                    <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $badgeClass = '';
                            if(!empty($scategory->badge)){
                                switch($scategory->badge) {
                                    case 'Winter': $badgeClass = 'bg-primary'; break;
                                    case 'New': $badgeClass = 'bg-success'; break;
                                    case 'Hot': $badgeClass = 'bg-danger'; break;
                                    case 'On Sale': $badgeClass = 'bg-warning'; break;
                                    case 'Latest': $badgeClass = 'bg-info'; break;
                                    case 'Trending': $badgeClass = 'bg-purple'; break;
                                    case 'Featured': $badgeClass = 'bg-dark'; break;
                                    default: $badgeClass = 'bg-secondary';
                                }
                            }
                        ?>
                        <li class="parent-category">
                            <a href="<?php echo e(url('category/' . $scategory->slug)); ?>" class="menu-category-name">
                                <?php echo e($scategory->name); ?>

                                <?php if(!empty($scategory->badge)): ?>
                                    <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($scategory->badge); ?></span>
                                <?php endif; ?>
                            </a>
                            <?php if($scategory->subcategories->count() > 0): ?>
                                <span class="menu-category-toggle"><i class="fa fa-chevron-down"></i></span>
                            <?php endif; ?>
                            <ul class="second-nav" style="display: none;">
                                <?php $__currentLoopData = $scategory->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $badgeClass = '';
                                        if(!empty($subcategory->badge)){
                                            switch($subcategory->badge) {
                                                case 'Winter': $badgeClass = 'bg-primary'; break;
                                                case 'New': $badgeClass = 'bg-success'; break;
                                                case 'Hot': $badgeClass = 'bg-danger'; break;
                                                case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                case 'Latest': $badgeClass = 'bg-info'; break;
                                                case 'Trending': $badgeClass = 'bg-purple'; break;
                                                case 'Featured': $badgeClass = 'bg-dark'; break;
                                                default: $badgeClass = 'bg-secondary';
                                            }
                                        }
                                    ?>
                                    <li class="parent-subcategory">
                                        <a href="<?php echo e(url('subcategory/' . $subcategory->slug)); ?>" class="menu-subcategory-name">
                                            <?php echo e($subcategory->subcategoryName); ?>

                                            <?php if(!empty($subcategory->badge)): ?>
                                                <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($subcategory->badge); ?></span>
                                            <?php endif; ?>
                                        </a>
                                        <?php if($subcategory->childcategories->count() > 0): ?>
                                            <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                        <?php endif; ?>
                                        <ul class="third-nav" style="display: none;">
                                            <?php $__currentLoopData = $subcategory->childcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $badgeClass = '';
                                                    if(!empty($childcat->badge)){
                                                        switch($childcat->badge) {
                                                            case 'Winter': $badgeClass = 'bg-primary'; break;
                                                            case 'New': $badgeClass = 'bg-success'; break;
                                                            case 'Hot': $badgeClass = 'bg-danger'; break;
                                                            case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                            case 'Latest': $badgeClass = 'bg-info'; break;
                                                            case 'Trending': $badgeClass = 'bg-purple'; break;
                                                            case 'Featured': $badgeClass = 'bg-dark'; break;
                                                            default: $badgeClass = 'bg-secondary';
                                                        }
                                                    }
                                                ?>
                                                <li class="childcategory">
                                                    <a href="<?php echo e(url('childcategory/' . $childcat->slug)); ?>" class="menu-childcategory-name">
                                                        <?php echo e($childcat->childcategoryName); ?>

                                                        <?php if(!empty($childcat->badge)): ?>
                                                            <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($childcat->badge); ?></span>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

            </li>
            <li class="drawer-menu2">
                <label for="abce"><a>Collection</a>
                    <span class="menu-category-toggle set2">
                        <i class="fa fa-chevron-down"></i>                       
                    </span>
                </label>


                <ul class="forth-nav">
                    <?php $__currentLoopData = $collections->sortBy('sort_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="parent-category">
                            <a class="menu-category-name ">  
                                <?php echo e($collection->name); ?>

                            
                            <?php if(isset($collection_items[$collection->id]) && $collection_items[$collection->id]->count() > 0): ?>
                                <span class="menu-category-toggle">
                                    <i class="fa fa-chevron-down"></i>
                                </span>
                            <?php endif; ?>
                            </a>
                            <ul class="second-nav" style="display: none;">
                                 <?php $__currentLoopData = $collection_items[$collection->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // 🔹 Skip inactive CollectionItems
                                        if ($item->status != 1) continue;

                                        // 🔹 Determine item name and slug based on type, only if active
                                        $url = '#';
                                        $item_name = $item->item_name ?? '';
                                        $item_slug = $item->item_slug ?? '';

                                        if($item->item_type == 'category') {
                                            $category = \App\Models\Category::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$category) continue;
                                            $item_name = $category->name;
                                            $item_slug = $category->slug;
                                            $url = url('category/'.$item_slug);

                                        } elseif($item->item_type == 'subcategory') {
                                            $subcategory = \App\Models\Subcategory::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$subcategory) continue;
                                            $item_name = $subcategory->subcategoryName;
                                            $item_slug = $subcategory->slug;
                                            $url = url('subcategory/'.$item_slug);

                                        } elseif($item->item_type == 'childcategory') {
                                            $child = \App\Models\Childcategory::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$child) continue;
                                            $item_name = $child->childcategoryName;
                                            $item_slug = $child->slug;
                                            $url = url('childcategory/'.$item_slug);
                                        } else {
                                            continue;
                                        }

                                        // 🔹 Badge class
                                        $badgeClass = '';
                                        if(!empty($item->item_badge)){
                                            switch($item->item_badge) {
                                                case 'Winter': $badgeClass = 'bg-primary'; break;
                                                case 'New': $badgeClass = 'bg-success'; break;
                                                case 'Hot': $badgeClass = 'bg-danger'; break;
                                                case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                case 'Latest': $badgeClass = 'bg-info'; break;
                                                case 'Trending': $badgeClass = 'bg-purple'; break;
                                                case 'Featured': $badgeClass = 'bg-dark'; break;
                                                default: $badgeClass = 'bg-secondary';
                                            }
                                        }
                                    ?>

                                    <li class="parent-subcategory">
                                        <a href="<?php echo e($url); ?>" class="shopbtn menu-subcategory-name">
                                            <?php echo e($item_name); ?>


                                            
                                            <?php if(!empty($scategory) && $scategory->subcategories->count() > 0): ?>
                                                <span class="menu-category-toggle">
                                                    <i class="fa fa-chevron-down"></i>
                                                </span>
                                            <?php endif; ?>

                                            
                                            <?php if(!empty($item->item_badge)): ?>
                                                <span id="tagbadge" class="badge <?php echo e($badgeClass); ?> ms-2">
                                                    <?php echo e($item->item_badge); ?>

                                                </span>
                                            <?php endif; ?>
                                        </a>
                                    </li>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <?php $__currentLoopData = $pagesright; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('page', ['slug' => $value->slug])); ?>"><?php echo e($value->name); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(auth()->guard('customer')->check()): ?>
                <li><a href="<?php echo e(route('customer.logout')); ?>"
                        onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i
                            data-feather="log-out"></i> Logout <i class="fa-solid fa-arrow-right"></i></a></li>
                <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <li>
                    <a href="<?php echo e(route('customer.login')); ?>">
                        <i class="fa-regular fa-user"></i>
                        Login
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('customer.signup')); ?>">
                        <i class="fa-regular fa-pen"></i>
                        Sign Up
                    </a>
                </li>
            <?php endif; ?>
            <br>
        </ul>
    </div>
    <!-- quick view section -->
    <div class="quick-view-product">

    </div>
    <div class="searchsectiontop">
        <div class="max-width">
            <div class="search-sec-two">
                <div class="search-sec-two-first-element">
                    <span class="search-heading">Search Our Site..</span>
                    <div class="crossmark-search"> <i class="fa-solid fa-xmark"></i></div>
                </div>
                <div class="max-width2">
                    <div class="main-search">
                        <form action="<?php echo e(route('search')); ?>">
                            <button>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <input type="text" placeholder="" class="search_keyword search_click"
                                name="keyword" />
                            <div class="fake-placeholder">
                                <span id="placeholderText">Search Products</span>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="search_result"></div>
            

            <div class="col-sm-12"><br>
                <span style="font-weight: 500; font-size: 20px; margin: 10px 0">Need some inspiration?</span><br>


            </div>
        </div>
    </div>


    <div class="cartmenu">
        <?php
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal = str_replace(',', '', $subtotal);
            $subtotal = str_replace('.00', '', $subtotal);
            $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        ?>
        <div class="headtext">
            <span>Shopping Cart</span>

            <div class="crossmark"> <i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="maincontent">


            <ul>
                <?php $__empty_1 = true; $__currentLoopData = Cart::instance('shopping')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="partCot">
                        <div class="productcartshowarea"
                            style="display: grid; grid-template-columns: 20% 60% 20%;gap: 0px;">

                            
                            <div class="part-imgpcart">
                                <a class="cart-photo" href="<?php echo e(route('product', $value->options->get('slug'))); ?>">
                                    <img src="<?php echo e(asset($value->options->get('image'))); ?>" alt="" />
                                </a>
                            </div>

                            
                            <div class="part-namepcart">
                                <div class="highsection">
                                    <div class="cartmiddlepart">
                                        <div class="productnamecartsection">
                                            <span class="ppricecart"><?php echo e(Str::limit($value->name, 40)); ?></span>
                                            <?php if($value->options->get('is_combo')): ?>
                                                <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <?php if(!$value->options->get('is_combo')): ?>
                                        
                                        <div class="size-part">
                                            <p>Size - <?php echo e($value->options->product_size ?? 'N/A'); ?></p>
                                            <p>Color - <?php echo e($value->options->product_color ?? 'N/A'); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <div class="faulsection d-flex align-items-center">
                                        <div class="customquantity"
                                            style="border:1px solid #ff9900; border-radius: 0; background: none;">
                                            <button type="button"
                                                style="border-right:1px solid #ff9900; border-radius: 0; background: none;"
                                                class=" ctrl minus cart_decrementt" data-id="<?php echo e($value->rowId); ?>"
                                                aria-label="decrease">−</button>
                                            <div class="value-box">
                                                <input type="text" class="qty-input" value="<?php echo e($value->qty); ?>"
                                                    readonly aria-label="quantity" />
                                            </div>
                                            <button
                                                style="border-left:1px solid #ff9900; border-radius: 0; background: none;"
                                                type="button" class="ctrl plus cart_incrementt"
                                                data-id="<?php echo e($value->rowId); ?>" aria-label="increase">+</button>
                                        </div>

                                        <div class="removebtnsec">
                                            <button style="margin-left: 5px;" class="remove-cart cart_removee"
                                                data-id="<?php echo e($value->rowId); ?>">
                                                <i class="fa-solid fa-trash-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            
                            <li>
                                <div class="secpricecart" style="text-align: right;">
                                    <span class="cartprice" data-price="<?php echo e($value->price); ?>">
                                        <?php echo e($value->price * $value->qty); ?> ৳
                                    </span>
                                    <span class="cartqnty">(<?php echo e($value->price); ?>৳ X <span
                                            class="qty-text"><?php echo e($value->qty); ?></span>)
                                    </span>
                                </div>
                            </li>

                        </div>
                        <div class="comboProductcartSection">
                            <?php if($value->options->get('is_combo')): ?>
                                <div id="combo-items-<?php echo e($key); ?>" class="combo-inner-products"
                                    style=" margin-top:5px;">
                                    <?php $__currentLoopData = $value->options->get('combo_items') ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                        <div class="productcartshowarea productcartpart2forcombo"
                                            style="display: grid; grid-template-columns:10% 20% 40% 30%; gap: 0px; margin-bottom:5px; padding-bottom:5px;">
                                            <div class="sideblankspace"></div>
                                            
                                            <div class="part-imgpcart">
                                                <a class="cart-photo" href="#">
                                                    <img src="<?php echo e(asset($p['image'])); ?>" alt="<?php echo e($p['name']); ?>"
                                                        style="width:100%; object-fit:cover;" />
                                                </a>
                                            </div>

                                            
                                            <div class="part-namepcart">
                                                <div class="highsection">
                                                    <div class="cartmiddlepart">
                                                        <div class="productnamecartsection">
                                                            <a class="ppricecart"
                                                                href="#"><?php echo e(Str::limit($p['name'], 40)); ?></a>
                                                            <?php if($p['is_combo'] ?? false): ?>
                                                                <span class="badge bg-warning"
                                                                    style="margin-left:5px;">Combo</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="size-part">
                                                        <p>Size - <?php echo e($p['size'] ?? 'N/A'); ?></p>
                                                        <p>Color - <?php echo e($p['color'] ?? 'N/A'); ?></p>
                                                        <p>Quantity - <?php echo e($value->qty); ?></p>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="secpricecart" style="text-align: right;">
                                                <span class="cartprice">
                                                    0 ৳
                                                </span>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <?php if($value->options->get('is_combo')): ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary toggle-combo-items"
                                data-target="#combo-items-<?php echo e($key); ?>"
                                style="margin-bottom:5px;  transform: translate(-50%, -15px);">
                                Hide Items
                            </button>
                        <?php endif; ?>
                    </div>  
                 </ul>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="no-cartproduct">
                        <span class="span-class1"><svg width="50" height="50" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg></span>
                        <span class="span-class2">Your cart is empty</span>
                        <span class="span-class3">You may check out all the available products and buy some in the
                            shop</span>
                        <br>
                        <a href="<?php echo e(route('shop')); ?>"><span class="span-class4">Shop Now <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                    </div>
                <?php endif; ?>
        </div>
        
        <div class="btnfixedset">
            <div class="bottomsetforcart" >
                <p class="checkoutpstyle">
                    <a href="<?php echo e(route('customer.checkout')); ?>">
                       <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>
                        <span>Total (<?php echo e(Cart::instance('shopping')->count()); ?>) Items</span>
                    </a>
                </p>
                <p class="checkoutpstyle"><strong>Total Price : ৳<?php echo e($subtotal); ?></strong></p>
                <a href="<?php echo e(route('customer.checkout')); ?>" class="go_cart"> Checkout
                </a>
            </div>
        </div>
    </div>
    <header class="navbar-top ">
        
        <input type="checkbox" name="drawermenu" id="drawermenu">
        <input type="checkbox" name="drawermenu2" id="drawermenu2">


        <div class="mobile-header">

            <div class="mobile-logo">
                <div class="menu-bar">
                    <a class="toggle" style="color: #fff;font-size:50px">
                       <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="currentColor"><path d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z" fill="currentColor"></path></svg>

                    </a>
                </div>
                <div class="menu-logo">
                    <?php if($generalsetting && $generalsetting->white_logo): ?>
                        <a href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(asset($generalsetting->white_logo)); ?>" alt="" />
                        </a>
                    <?php endif; ?>

                </div>

                <div class="menu-bag">
                    <p>
                        <a class="search-box-enter" >
                           <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="currentColor"><path d="M17.7241 16.1932L13.6436 12.1127C14.626 10.8049 15.1563 9.21299 15.1546 7.57728C15.1546 3.39919 11.7554 0 7.57728 0C3.39919 0 0 3.39919 0 7.57728C0 11.7554 3.39919 15.1546 7.57728 15.1546C9.21299 15.1563 10.8049 14.626 12.1127 13.6436L16.1932 17.7241C16.3998 17.9088 16.6692 18.0073 16.9461 17.9996C17.2231 17.9918 17.4865 17.8783 17.6824 17.6824C17.8783 17.4865 17.9918 17.2231 17.9996 16.9461C18.0073 16.6692 17.9088 16.3998 17.7241 16.1932ZM2.16494 7.57728C2.16494 6.50682 2.48237 5.4604 3.07708 4.57034C3.6718 3.68029 4.51709 2.98657 5.50607 2.57693C6.49504 2.16728 7.58328 2.0601 8.63318 2.26893C9.68307 2.47777 10.6475 2.99325 11.4044 3.75018C12.1613 4.5071 12.6768 5.47149 12.8856 6.52138C13.0945 7.57128 12.9873 8.65952 12.5776 9.64849C12.168 10.6375 11.4743 11.4828 10.5842 12.0775C9.69416 12.6722 8.64774 12.9896 7.57728 12.9896C6.14237 12.9879 4.76672 12.4171 3.75208 11.4025C2.73744 10.3878 2.16666 9.01219 2.16494 7.57728Z" fill="currentColor"></path></svg>
                        </a>
                    </p>
                    <p class="carttoggle">
                        <a href="#">
                       <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>

                        </a>
                        <span class="mobilecart-qty"><?php echo e(Cart::instance('shopping')->count()); ?></span>
                    </p>

                    <!-- <p>
                        <a href="<?php echo e(route('customer.login')); ?>" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fa-regular fa-user"></i>
                        </a>
                    </p> -->

                </div>
            </div>

        </div>

        



        <div class="main-header">



            <div class="logo-area">
                <div class="max-width3">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="logo-header">
                                <div class="main-logo" style="width: fit-content;">
                                    <?php if($generalsetting && $generalsetting->white_logo): ?>
                                        <a href="<?php echo e(route('home')); ?>">
                                            <img src="<?php echo e(asset($generalsetting->white_logo)); ?>" alt="" />
                                        </a>
                                    <?php endif; ?>

                                </div>

                                <!-- <div class="main-search">
                                        <form action="<?php echo e(route('search')); ?>">
                                            <input type="text" placeholder="" class="search_keyword search_click"
                                                name="keyword" />
                                            <div class="fake-placeholder">
                                                <span id="placeholderText">Our Products</span>
                                            </div>
                                            <button>
                                                <i data-feather="search"></i>
                                            </button>
                                        </form>
                                        <div class="search_result"></div>
                                    </div> -->

                                <nav class="navarea-menu">
                                    <ul>

                                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>

                                        <li class="more-menu">
                                            <a href="#">
                                                <span class="drawelabel">
                                                    Shop
                                                    <i class="fa-solid fa-chevron-down rotate-system2"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li><a href="<?php echo e(route('pages.all')); ?>">Categories</a></li>
                                        <li class="more-menu2"><a href="#"> <label class="drawelabel" for="drawermenu2">More <i
                                                        class="fa-solid fa-chevron-down rotate-system2"></i></label></a>
                                        </li>



                                    </ul>

                                </nav>

                                
                                <div class="header-list-items">

                                    <ul style="display: flex;align-items:center;gap:3px">
                                        <!-- Search icon সবসময় -->
                                        <li>
                                            <a class="search-box-enter">
                                               <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="currentColor"><path d="M17.7241 16.1932L13.6436 12.1127C14.626 10.8049 15.1563 9.21299 15.1546 7.57728C15.1546 3.39919 11.7554 0 7.57728 0C3.39919 0 0 3.39919 0 7.57728C0 11.7554 3.39919 15.1546 7.57728 15.1546C9.21299 15.1563 10.8049 14.626 12.1127 13.6436L16.1932 17.7241C16.3998 17.9088 16.6692 18.0073 16.9461 17.9996C17.2231 17.9918 17.4865 17.8783 17.6824 17.6824C17.8783 17.4865 17.9918 17.2231 17.9996 16.9461C18.0073 16.6692 17.9088 16.3998 17.7241 16.1932ZM2.16494 7.57728C2.16494 6.50682 2.48237 5.4604 3.07708 4.57034C3.6718 3.68029 4.51709 2.98657 5.50607 2.57693C6.49504 2.16728 7.58328 2.0601 8.63318 2.26893C9.68307 2.47777 10.6475 2.99325 11.4044 3.75018C12.1613 4.5071 12.6768 5.47149 12.8856 6.52138C13.0945 7.57128 12.9873 8.65952 12.5776 9.64849C12.168 10.6375 11.4743 11.4828 10.5842 12.0775C9.69416 12.6722 8.64774 12.9896 7.57728 12.9896C6.14237 12.9879 4.76672 12.4171 3.75208 11.4025C2.73744 10.3878 2.16666 9.01219 2.16494 7.57728Z" fill="currentColor"></path></svg>
                                            </a>
                                        </li>

                                        <!-- Cart icon সবসময় -->
                                        <li class="wishlist-dialog" id="wishlist_count">
                                           <a href="<?php echo e(route('wishlist')); ?>">
                                            <svg width="24" height="24" aria-hidden="true" role="img" focusable="false">
                                                <use href="#heart" xlink:href="#heart"></use>
                                            </svg>
                                           <span class="wishlist-count-top">
                                            <?php echo e(count(json_decode(request()->cookie('wishlist','[]'), true))); ?>

                                        </span>

                                        </a>


                                        </li>
                                        

                                        <li class="cart-dialog" id="cart-qty">
                                            <a class="carttoggle">

                                               <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>
                                                <span
                                                    class="cart-count-top"><?php echo e(Cart::instance('shopping')->count()); ?></span>
                                                    

                                            </a>
                                        </li>




                                        <li class="for_order">
                                            <p>
                                        <li class="for_order">
                                            <div>
                                                <?php if(auth()->guard('customer')->check()): ?>
                                                    
                                                    <a class="usernamelogo" href="<?php echo e(route('customer.account')); ?>">

                                                        <div class="img_sec"
                                                            style="width:35px; height:35px;position:relative;margin-bottom:5px;border
                                                                            :1px solid #fff;border-radius:50%;">
                                                            <img src="<?php echo e(asset($customer->image) ?? 'public/uploads/default/user.png'); ?>"
                                                                alt="User Photo"
                                                                style="border-radius:50%;height:auto;width:35px;object-fit:cover;">
                                                        </div>

                                                    </a>
                                                <?php else: ?>
                                                    
                                                    <a href="<?php echo e(route('customer.login')); ?>" data-bs-toggle="modal"
                                                        data-bs-target="#loginModal">
                                                        <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 64 64" fill="currentColor"><path d="M56,64V57.48A8.43,8.43,0,0,0,47.56,49H16.44A8.43,8.43,0,0,0,8,57.48V64H.9V57.48A15.53,15.53,0,0,1,16.44,41.94H47.56A15.53,15.53,0,0,1,63.1,57.48V64Zm-23.47-27a18.66,18.66,0,0,1-13.11-5.43,18.54,18.54,0,0,1,0-26.22A18.53,18.53,0,0,1,51.07,18.51,18.52,18.52,0,0,1,32.54,37.05Zm0-30a11.44,11.44,0,1,0,8.09,3.35A11.36,11.36,0,0,0,32.54,7.07Z"></path></svg>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </li>

                                        </p>
                                        </li>







                                    </ul>
                                </div>




                            </div>
                        </div>
                    </div>

                </div>
            </div>

            
        </div>


        <div class="headermenulistsection2">
            <div class="max-width">
                
                <div class="areaflex">
                    <div class="category_menu1">
                        <span class="category-title">Important Links</span>
                        <ul>
                            <li class="track_btn">
                                <a href="<?php echo e(route('contact')); ?>">Contact us</a>
                            </li>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="track_btn"><a
                                        href="<?php echo e(route('page', ['slug' => $page->slug])); ?>"><?php echo e($page->name); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="category_menu1">
                        <span class="category-title">Useful links</span>
                        <ul>
                            <li class="track_btn">
                                <a href="<?php echo e(route('customer.order_track')); ?>"> <i class="fa fa-truck"></i>Track
                                    Order</a>
                            </li>

                        </ul>
                    </div>
                    <div class="category_menu1">
                        <span class="category-title">Helps</span>
                        <ul>
                            <li class="track_btn">
                                <a href="<?php echo e(route('shop')); ?>">All Products</a>
                            </li>
                            <li class="track_btn">
                                <a href="<?php echo e(route('customer.signup')); ?>">SignUp</a>
                            </li>
                            <li class="track_btn">
                                <a href="<?php echo e(route('customer.login')); ?>">Login</a>
                            </li>
                        </ul>
                    </div>
                    <div class="category_menu1"></div>
                </div>
            </div>
        </div>
        <div class="headermenulistsection">
            <div class="max-width">
                <div class="areaflex">
                    <div class="category_menu1">
                        <span class="category-title">All Categories</span>
                        <ul>
                            <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $badgeClass = '';
                                    if(!empty($scategory->badge)){
                                        switch($scategory->badge) {
                                            case 'Winter': $badgeClass = 'bg-primary'; break;
                                            case 'New': $badgeClass = 'bg-success'; break;
                                            case 'Hot': $badgeClass = 'bg-danger'; break;
                                            case 'On Sale': $badgeClass = 'bg-warning'; break;
                                            case 'Latest': $badgeClass = 'bg-info'; break;
                                            case 'Trending': $badgeClass = 'bg-purple'; break;
                                            case 'Featured': $badgeClass = 'bg-dark'; break;
                                            default: $badgeClass = 'bg-secondary';
                                        }
                                    }
                                ?>
                                <li class="parent-category">
                                    <a href="<?php echo e(url('category/' . $scategory->slug)); ?>" class="menu-category-name shopbtn">
                                        <?php echo e($scategory->name); ?>

                                        <?php if(!empty($scategory->badge)): ?>
                                            <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($scategory->badge); ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <?php if($scategory->subcategories->count() > 0): ?>
                                        <span class="menu-category-toggle"><i class="fa fa-chevron-down"></i></span>
                                    <?php endif; ?>
                                    <ul class="second-nav" style="display: none;">
                                        <?php $__currentLoopData = $scategory->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $badgeClass = '';
                                                if(!empty($subcategory->badge)){
                                                    switch($subcategory->badge) {
                                                        case 'Winter': $badgeClass = 'bg-primary'; break;
                                                        case 'New': $badgeClass = 'bg-success'; break;
                                                        case 'Hot': $badgeClass = 'bg-danger'; break;
                                                        case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                        case 'Latest': $badgeClass = 'bg-info'; break;
                                                        case 'Trending': $badgeClass = 'bg-purple'; break;
                                                        case 'Featured': $badgeClass = 'bg-dark'; break;
                                                        default: $badgeClass = 'bg-secondary';
                                                    }
                                                }
                                            ?>
                                            <li class="parent-subcategory">
                                                <a href="<?php echo e(url('subcategory/' . $subcategory->slug)); ?>" class="menu-subcategory-name shopbtn">
                                                    <?php echo e($subcategory->subcategoryName); ?>

                                                    <?php if(!empty($subcategory->badge)): ?>
                                                        <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($subcategory->badge); ?></span>
                                                    <?php endif; ?>
                                                </a>
                                                <?php if($subcategory->childcategories->count() > 0): ?>
                                                    <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                                <?php endif; ?>
                                                <ul class="third-nav" style="display: none;">
                                                    <?php $__currentLoopData = $subcategory->childcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $badgeClass = '';
                                                            if(!empty($childcat->badge)){
                                                                switch($childcat->badge) {
                                                                    case 'Winter': $badgeClass = 'bg-primary'; break;
                                                                    case 'New': $badgeClass = 'bg-success'; break;
                                                                    case 'Hot': $badgeClass = 'bg-danger'; break;
                                                                    case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                                    case 'Latest': $badgeClass = 'bg-info'; break;
                                                                    case 'Trending': $badgeClass = 'bg-purple'; break;
                                                                    case 'Featured': $badgeClass = 'bg-dark'; break;
                                                                    default: $badgeClass = 'bg-secondary';
                                                                }
                                                            }
                                                        ?>
                                                        <li class="childcategory">
                                                            <a href="<?php echo e(url('childcategory/' . $childcat->slug)); ?>" class="menu-childcategory-name shopbtn">
                                                                <?php echo e($childcat->childcategoryName); ?>

                                                                <?php if(!empty($childcat->badge)): ?>
                                                                    <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($childcat->badge); ?></span>
                                                                <?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php $__currentLoopData = $collections->sortBy('sort_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="catagory_menu1">
                        <span class="category-title"><?php echo e($collection->name); ?></span>

                        <?php if(isset($collection_items[$collection->id]) && $collection_items[$collection->id]->count()): ?>
                            <ul>
                                <?php $__currentLoopData = $collection_items[$collection->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // 🔹 Skip inactive CollectionItems
                                        if ($item->status != 1) continue;

                                        // 🔹 Determine item name and slug based on type, only if active
                                        $url = '#';
                                        $item_name = $item->item_name ?? '';
                                        $item_slug = $item->item_slug ?? '';

                                        if($item->item_type == 'category') {
                                            $category = \App\Models\Category::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$category) continue;
                                            $item_name = $category->name;
                                            $item_slug = $category->slug;
                                            $url = url('category/'.$item_slug);

                                        } elseif($item->item_type == 'subcategory') {
                                            $subcategory = \App\Models\Subcategory::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$subcategory) continue;
                                            $item_name = $subcategory->subcategoryName;
                                            $item_slug = $subcategory->slug;
                                            $url = url('subcategory/'.$item_slug);

                                        } elseif($item->item_type == 'childcategory') {
                                            $child = \App\Models\Childcategory::where('id', $item->item_id)
                                                ->where('status', 1)
                                                ->first();
                                            if(!$child) continue;
                                            $item_name = $child->childcategoryName;
                                            $item_slug = $child->slug;
                                            $url = url('childcategory/'.$item_slug);
                                        } else {
                                            continue;
                                        }

                                        // 🔹 Badge class
                                        $badgeClass = '';
                                        if(!empty($item->item_badge)){
                                            switch($item->item_badge) {
                                                case 'Winter': $badgeClass = 'bg-primary'; break;
                                                case 'New': $badgeClass = 'bg-success'; break;
                                                case 'Hot': $badgeClass = 'bg-danger'; break;
                                                case 'On Sale': $badgeClass = 'bg-warning'; break;
                                                case 'Latest': $badgeClass = 'bg-info'; break;
                                                case 'Trending': $badgeClass = 'bg-purple'; break;
                                                case 'Featured': $badgeClass = 'bg-dark'; break;
                                                default: $badgeClass = 'bg-secondary';
                                            }
                                        }
                                    ?>

                                    <li class="parent-category">
                                        <a href="<?php echo e($url); ?>" class="shopbtn">
                                            <?php echo e($item_name); ?>


                                            
                                            <?php if(!empty($scategory) && $scategory->subcategories->count() > 0): ?>
                                                <span class="menu-category-toggle">
                                                    <i class="fa fa-chevron-down"></i>
                                                </span>
                                            <?php endif; ?>

                                            
                                            <?php if(!empty($item->item_badge)): ?>
                                                <span id="tagbadge" class="badge <?php echo e($badgeClass); ?> ms-2">
                                                    <?php echo e($item->item_badge); ?>

                                                </span>
                                            <?php endif; ?>
                                        </a>
                                    </li>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="category_menu1">
                        <div class="fieldarea">
                            <div class="topcategory">
                                <?php $__empty_1 = true; $__currentLoopData = $menucategories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="cat_item">
                                        <div class="cat_img">
                                            <a href="<?php echo e(route('category', $value->slug)); ?>">
                                                <img src="<?php echo e(asset($value->image)); ?>" alt="" />
                                            </a>
                                            <div class="cat_name">
                                                <a href="<?php echo e(route('category', $value->slug)); ?>">
                                                    <?php echo e($value->name); ?>

                                                </a>
                                                <div class="product_count">
                                                    <?php echo e($value->products->count()); ?> Products
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p>No</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- main-header end -->

    </header>



    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>


    </div>
   



    </div>

    <!-- content end -->
    <footer>
        <div class="footer-top">
            <div class="footer-get-in-touch">
                Get in touch
            </div>
            <div class="container">
                <div class="row">
                    <div class="footer_menu-bar">

                        <div class="footer-about">
                            <a href="<?php echo e(route('home')); ?>">
                                <?php if($generalsetting && $generalsetting->white_logo): ?>
                                    <img src="<?php echo e(asset($generalsetting->white_logo)); ?>" alt="" />
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/default-logo.png')); ?>" alt="Default Logo" />
                                <?php endif; ?>

                            </a>
                            <p>Address :<?php echo e($contact->address); ?></p>
                            <a href="tel:<?php echo e($contact->hotline); ?>">Phone :
                                <span class="dci"
                                    style="font-weight: 500; color: #ffdd00;"><?php echo e($contact->hotline); ?></span></a>
                            <a href="mailto:<?php echo e($contact->email); ?>">Email :
                                <span class="dci"
                                    style="font-weight: 500; color: #ffdd00;"><?php echo e($contact->email); ?></span>
                            </a>
                            <br>

                            <div class="footer-menu for-social">
                                <ul>
                                    <span class="title stay_conn"><a>Follow Us</a></span>
                                    <ul class="social_link">
                                        <?php $__currentLoopData = $socialicons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="social_list">
                                                <div class="social-icon-badge"><?php echo e($value->title); ?></div>
                                                <a class="mobile-social-link" href="<?php echo e($value->link); ?>"><i
                                                        class="<?php echo e($value->icon); ?>"></i></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </ul>
                            </div>
                        </div>


                        <!-- col end -->

                        <!-- col end -->
                        <div class="footer-menu">
                            <ul>
                                <span class="title"><a>Useful Link</a></span>
                                <li>
                                    <a href="<?php echo e(route('contact')); ?>"> Contact Us</a>
                                </li>

                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a
                                            href="<?php echo e(route('page', ['slug' => $page->slug])); ?>"><?php echo e($page->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="last-icon">
                                <span>
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </div>
                        </div>

                        <!-- col end -->

                        <div class="footer-menu">
                            <ul>
                                <span class="title"><a>Helps</a></span>
                                <li>
                                    <a href="<?php echo e(route('shop')); ?>">All Products</a>
                                </li>
                                <?php $__currentLoopData = $pagesright; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a
                                            href="<?php echo e(route('page', ['slug' => $value->slug])); ?>"><?php echo e($value->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="last-icon">
                                <span>
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </div>
                        </div>


                        <!-- col end -->
                        <br>
                        <div class="footer-menu payment-partner">
                            <ul>
                                <span class="title"><a>Supports Partner</a></span>
                                <div class="partner">
                                    <li><img src="<?php echo e(asset('public/images/payment.png')); ?>"
                                            style="width: 160px; height: 80px">
                                    </li>
                                    <li><img src="<?php echo e(asset('public/images/cod_logo.webp')); ?>"
                                            style="width: 75px; height: 35px; margin: 3px">
                                    </li>

                                </div>
                            </ul>
                        </div>

                    </div>
                    <!-- col end -->
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="copyright">
                            <p>
                                Copyright © <?php echo e(date('Y')); ?> <?php echo e($generalsetting?->name ?? 'Your Website Name'); ?>.
                                All
                                rights reserved |
                                <span style="color: white;">
                                    Website Design & Developed by :
                                    <a href="https://hasibx.netlify.app" style="color: white;">
                                        Mohibulla Hasib
                                    </a>
                                </span>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick View Button -->
        <?php echo $__env->make('partials.login-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('partials.signup-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </footer>
    <!-- <div id="popupBox" class="popup-notification">

        <a id="popupLink" href="#">
            <img id="popupImg" src="" alt="Product Image">
        </a>


        <div class="onside">
            <div class="icooon">
                <div class="close-btn-pop"><i class="fa-solid fa-times"></i></div>
            </div>
            <div class="setttone">
                <div class="text" id="popupText1">Someone purchased </div>
            </div>
            <a id="popupTextLink" href="#" class="popup-text-link"></a>
            <div class="text" id="popupText"></div>
            </a>
            <div class="time" id="popupTime"></div>
        </div>
    </div> -->

    <input class="checkboxsystem" type="radio" name="group1" id="check1">
    <input class="checkboxsystem" type="radio" name="group1" id="check2">
    <input class="checkboxsystem" type="radio" name="group1" id="check3" checked>
    <input class="checkboxsystem" type="radio" name="group1" id="check4">
    <input class="checkboxsystem" type="radio" name="group1" id="check5">


    <div class="footer_nav">
        <ul>
            <label for="check3">
                <li>
                    <a href="<?php echo e(route('home')); ?>">
                        <span>
                           <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#home" xlink:href="#home"></use> </svg>
                        </span> 
                        <span class="icon-name-mmobile-set" style="padding: 5px">Home</span>
                    </a>
                </li>
            </label>
            <label for="check1">
                <li>
                    <a href="<?php echo e(url('shop')); ?>">
                        <span>
                           <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64.39 64.26" width="18" height="18" fill="currentColor"><path d="M45.47,64.26a11.21,11.21,0,0,1-11.2-11.2V45.34a11.21,11.21,0,0,1,11.2-11.2h7.72a11.21,11.21,0,0,1,11.2,11.2v7.72a11.22,11.22,0,0,1-11.2,11.2Zm0-22.53a3.61,3.61,0,0,0-3.61,3.61v7.72a3.61,3.61,0,0,0,3.61,3.6h7.72a3.6,3.6,0,0,0,3.6-3.6V45.34a3.61,3.61,0,0,0-3.6-3.61ZM11.2,64.26A11.22,11.22,0,0,1,0,53.06V45.34a11.21,11.21,0,0,1,11.2-11.2h7.72a11.21,11.21,0,0,1,11.2,11.2v7.72a11.21,11.21,0,0,1-11.2,11.2Zm0-22.53a3.61,3.61,0,0,0-3.61,3.61v7.72a3.61,3.61,0,0,0,3.61,3.6h7.72a3.61,3.61,0,0,0,3.61-3.6V45.34a3.61,3.61,0,0,0-3.61-3.61ZM45.47,30.12a11.21,11.21,0,0,1-11.2-11.2V11.2A11.21,11.21,0,0,1,45.47,0h7.72a11.21,11.21,0,0,1,11.2,11.2v7.72a11.22,11.22,0,0,1-11.2,11.2Zm0-22.53a3.61,3.61,0,0,0-3.61,3.61v7.72a3.61,3.61,0,0,0,3.61,3.61h7.72a3.61,3.61,0,0,0,3.6-3.61V11.2a3.61,3.61,0,0,0-3.6-3.61ZM11.2,30.12A11.22,11.22,0,0,1,0,18.92V11.2A11.21,11.21,0,0,1,11.2,0h7.72a11.21,11.21,0,0,1,11.2,11.2v7.72a11.21,11.21,0,0,1-11.2,11.2Zm0-22.53A3.61,3.61,0,0,0,7.59,11.2v7.72a3.61,3.61,0,0,0,3.61,3.61h7.72a3.61,3.61,0,0,0,3.61-3.61V11.2a3.61,3.61,0,0,0-3.61-3.61Z"></path></svg>
                        </span>
                        <span class="icon-name-mmobile-set" style="margin-top: 5px">Shop</span>
                    </a>
                </li>
            </label>
            <label for="check1">
                <li>
                   
                     <span class="wishlist-count-top mobilecart-qty">
                         <?php echo e(count(json_decode(request()->cookie('wishlist','[]'), true))); ?>

                    </span>
                    <a href="<?php echo e(route('wishlist')); ?>">
                        <span>
                           <svg width="24" height="24" aria-hidden="true" role="img" focusable="false">
                                                <use href="#heart" xlink:href="#heart"></use>
                                            </svg>
                        </span>
                        <span class="icon-name-mmobile-set" style="margin-top: 5px">Wishlist</span>
                    </a>
                     <a href="<?php echo e(route('wishlist')); ?>">
                                            
                                            
                                        </a>
                </li>
            </label>

            



            <label for="check4">

                <li>
                    <div class="mobilecart-qty"><?php echo e(Cart::instance('shopping')->count()); ?></div>
                    <a class="carttoggle">
                        <!-- <a href="<?php echo e(route('customer.checkout')); ?>"> -->
                        <span>
                            <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>

                        </span>
                        <span class="icon-name-mmobile-set" style="margin-top: 5px">Cart </span>
                    </a>
                </li>
            </label>
            <?php if(Auth::guard('customer')->user()): ?>
                <label for="check5">
                    <li>
                        <a href="<?php echo e(route('customer.account')); ?>">
                            <span>
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="icon-name-mmobile-set" style="margin-top: 5px">Account</span>
                        </a>
                    </li>
                </label>
            <?php else: ?>
                <label for="check5">
                    <li>
                        <a href="<?php echo e(route('customer.login')); ?>">
                            <span>
                               <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 64 64" fill="currentColor"><path d="M56,64V57.48A8.43,8.43,0,0,0,47.56,49H16.44A8.43,8.43,0,0,0,8,57.48V64H.9V57.48A15.53,15.53,0,0,1,16.44,41.94H47.56A15.53,15.53,0,0,1,63.1,57.48V64Zm-23.47-27a18.66,18.66,0,0,1-13.11-5.43,18.54,18.54,0,0,1,0-26.22A18.53,18.53,0,0,1,51.07,18.51,18.52,18.52,0,0,1,32.54,37.05Zm0-30a11.44,11.44,0,1,0,8.09,3.35A11.36,11.36,0,0,0,32.54,7.07Z"></path></svg>
                            </span>
                            <span class="icon-name-mmobile-set" style="margin-top: 5px">Login</span>
                        </a>
                    </li>
                </label>
            <?php endif; ?>
        </ul>
    </div>

    <div class="rightfloatbtn">
        <!-- Main toggle button -->
        <button class="float-toggle" id="floatToggle">
            <i class="fa-solid fa-comment-dots"></i>
        </button>
        <!-- Inner buttons -->
        <div class="float-actions" id="floatActions">
            

            <?php $__currentLoopData = $socialicons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                    $allowedIcons = [
                        'fa-facebook-f' => 'facebook',
                        'fa-facebook-messenger' => 'messenger',
                        'fa-whatsapp' => 'whatsapp',
                        'fa-instagram' => 'instagram',
                        'fa-tiktok' => 'tiktok',
                    ];
                ?>

                <?php $__currentLoopData = $allowedIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iconClass => $iconName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(str_contains($value->icon, $iconClass)): ?>
                    
                        <div class="iconnn">
                            <span><?php echo e($value->title); ?></span>
                            <a class="float-btn <?php echo e($iconName); ?>" href="<?php echo e($value->link); ?>" target="_blank">
                            <i class="<?php echo e($value->icon); ?>"></i>  
                        </a>
                        </div>
                        <?php break; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="iconnn">
                <span>Live Chat</span>
                <a href="https://instagram.com/yourprofile"
                target="_blank" class="float-btn live-chat">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </div>


    <div class="scrolltop" onclick="scrollToTop()">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- <?php
        use App\Models\Product;
        $products = Product::with('image')->take(20)->get();

        $popupProducts = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'img' => $p->image ? asset($p->image->image) : asset('default.jpg'),
                'url' => route('product', ['id' => $p->slug]), // fixed
            ];
        });
    ?>

    <script>
        const products = <?php echo json_encode($popupProducts, 15, 512) ?>;
    </script> -->

    <!-- Quick View Modal -->




    <!-- <script>
        function showPopup() {
            if (!products || products.length === 0) return;

            const product = products[Math.floor(Math.random() * products.length)];
            const minutesAgo = Math.floor(Math.random() * 10) + 1;

            // set image & text
            document.getElementById("popupImg").src = product.img;
            document.getElementById("popupText").innerText = `${product.name}`;
            document.getElementById("popupTime").innerText = `${minutesAgo} minutes ago`;

            // set links (image + text)
            document.getElementById("popupLink").href = product.url;
            document.getElementById("popupTextLink").href = product.url;

            // show popup
            const popup = document.getElementById("popupBox");

            popup.classList.add("show");


            setTimeout(() => popup.classList.remove("show"), 4000);
            const btn = document.querySelector('.close-btn-pop');
            btn.addEventListener("click", () => {
                popup.classList.remove("show")

            })
        }

        // Show popup every 5–10 seconds randomly
        setInterval(() => {
            if (Math.random() > 0.5) showPopup();
        }, 5000);

        // Scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script> -->
    <section>
        <?php echo $__env->make('partials.quick-view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>



    <script>
        const scrollBtn = document.querySelector(".scrolltop");

        window.addEventListener("scroll", () => {
            let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            let scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrollPercent = (scrollTop / scrollHeight) * 100;

            // border progress update
            scrollBtn.style.background = `conic-gradient(#000 ${scrollPercent}%, transparent ${scrollPercent}%)`;
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>




    <!-- /. fixed sidebar -->

    <div id="custom-modal"></div>
    <!-- Toast Notification -->
<div id="wishlist-toast" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: none; padding: 15px 20px; border-radius: 5px; color: #fff; font-weight: bold;"></div>

    <div id="page-overlay"></div>
    <div id="loading">
        <div class="custom-loader"></div>
    </div>
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Ajax-loaded content will appear here -->
            </div>
        </div>
    </div>
<script>
document.getElementById('floatToggle').addEventListener('click', function () {
    const wrapper = document.querySelector('.rightfloatbtn');
    const icon = this.querySelector('i');

    wrapper.classList.toggle('active');

    if (wrapper.classList.contains('active')) {
        icon.classList.remove('fa-comment-dots');
        icon.classList.add('fa-xmark');
    } else {
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-comment-dots');
    }
});
</script>
    <script>
        $(document).ready(function() {
            $('.quick-view-btn').click(function() {
                var slug = $(this).data('slug');
                var url = '<?php echo e(route('quickview', ':slug')); ?>'.replace(':slug', slug);

                $.get(url, function(data) {
                    $('#quickViewModal .modal-content').html(data);
                    $('#quickViewModal').modal('show');
                }).fail(function() {
                    alert('Quick view loading failed!');
                });
            });
        });
    </script>
    

    <script src="<?php echo e(asset('public/frontEnd/js/jquery-3.6.3.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/mobile-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/wsit-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/mobile-menu-init.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontEnd/js/wow.min.js')); ?>"></script>
    <script src="public/frontEnd/js/jquery.syotimer.min.js"></script>



 <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.toggle-combo-items').forEach(function(button) {
                        button.addEventListener('click', function() {
                            let targetSelector = button.getAttribute('data-target');
                            let target = document.querySelector(targetSelector);

                            if (target) {
                                target.classList.toggle('combo-hidden'); // class toggle

                                // Button text update
                                if (target.classList.contains('combo-hidden')) {
                                    button.textContent = "Show Items";
                                } else {
                                    button.textContent = "Hide Items";
                                }
                            }
                        });
                    });
                });
            </script>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.toggle-combo').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const target = document.getElementById(btn.dataset.target);
                            target.classList.toggle('hidden');
                        });
                    });
                });
            </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('.more-menu');
    const menu = document.querySelector('.headermenulistsection');

    trigger.addEventListener('mouseenter', () => {
        menu.classList.add('active');
    });

    trigger.addEventListener('mouseleave', () => {
        menu.classList.remove('active');
    });

    menu.addEventListener('mouseenter', () => {
        menu.classList.add('active');
    });

    menu.addEventListener('mouseleave', () => {
        menu.classList.remove('active');
    });
});

</script>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('.more-menu2');
    const menu2 = document.querySelector('.headermenulistsection2');

    trigger.addEventListener('mouseenter', () => {
        menu2.classList.add('active');
    });

    trigger.addEventListener('mouseleave', () => {
        menu2.classList.remove('active');
    });

    menu2.addEventListener('mouseenter', () => {
        menu2.classList.add('active');
    });

    menu2.addEventListener('mouseleave', () => {
        menu2.classList.remove('active');
    });
});
</script>
<script>
$(document).on('click', '.wishlist-toggle', function(e){
    e.preventDefault();

    let btn = $(this);
    let productId = btn.data('product-id');
    let svg = btn.find('svg use');

    $.ajax({
        url: "<?php echo e(route('wishlist.toggle')); ?>",
        type: "POST",
        data: {
            _token: "<?php echo e(csrf_token()); ?>",
            product_id: productId
        },
        success: function(res){

            // Icon & color toggle
            if(res.status === 'added'){
                svg.attr('href','#heart-filled');
                svg.attr('xlink:href','#heart-filled');
                svg.css('color','#f80653');  // red icon

                // Show toast
                showWishlistToast('Product added to wishlist', '#28a745'); // green
            } else if(res.status === 'removed'){
                svg.attr('href','#heart');
                svg.attr('xlink:href','#heart');
                svg.css('color','black'); // black icon

                // Show toast
                showWishlistToast('Product removed from wishlist', '#dc3545'); // red
            }

            // Header wishlist count update
            if($('.wishlist-count-top').length){
                $('.wishlist-count-top').text(res.count);
            }
        },
        error: function(){
            showWishlistToast('Wishlist update failed!', '#6c757d'); // grey
        }
    });
});

// Toast function
function showWishlistToast(message, bgColor) {
    let toast = $('#wishlist-toast');
    toast.text(message)
         .css('background-color', bgColor)
         .fadeIn(300)
         .delay(1500)
         .fadeOut(500);
}

</script>

    <script>
        new WOW().init();
    </script>
    <script>
        const a = document.getElementById('drawermenu');
        const b = document.getElementById('drawermenu2');

        [a, b].forEach(el => {
            el.addEventListener('change', () => {
                if (el.checked) {
                    (el === a ? b : a).checked = false;
                }
            });
        });

        // document.body.addEventListener('click', (e) => {
        //     if (!a.contains(e.target) && !b.contains(e.target) &&
        //         e.target.tagName !== 'LABEL') {
        //         a.checked = false;
        //         b.checked = false;
        //     }
        // });
    </script>
    <script>
        window.menuCategories = <?php echo json_encode($menucategories, 15, 512) ?>;
        console.log(window.menuCategories);

        window.menuCategories.forEach(function(item) {
            console.log(item.name, item.slug);
        });
    </script>

    <script>
        const texts = [

            ...window.menuCategories.map(item => `Search for ${item.name}`)
        ];

        const placeholder = document.getElementById("placeholderText");
        let index = 0;

        setInterval(() => {
            // Animate up
            placeholder.style.transform = "translateY(-100%)";

            setTimeout(() => {
                // Reset position instantly below
                placeholder.style.transition = "none";
                placeholder.style.transform = "translateY(100%)";
                index = (index + 1) % texts.length;
                placeholder.textContent = texts[index];

                // Animate back to visible
                setTimeout(() => {
                    placeholder.style.transition = "all 0.5s ease";
                    placeholder.style.transform = "translateY(0)";
                }, 20);
            }, 500);
        }, 2500);
    </script>
    <!-- cart update -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- feather icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <!-- <script>
        feather.replace();
    </script> -->
    <script src="<?php echo e(asset('public/backEnd/')); ?>/assets/js/toastr.min.js"></script>
    <?php echo Toastr::message(); ?> <?php echo $__env->yieldPushContent('script'); ?>

    <!-- quick view end -->
    <!-- cart js start -->
    
    
    
    <script>
        function cart_count() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('cart.count')); ?>",
                success: function(data) {
                    if (data) {
                        $("#cart-qty").html(data);
                    } else {
                        $("#cart-qty").empty();
                    }
                },
            });
        }

        function mobile_cart() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('mobile.cart.count')); ?>",
                success: function(data) {
                    if (data) {
                        $(".mobilecart-qty").html(data);
                    } else {
                        $(".mobilecart-qty").empty();
                    }
                },
            });
        }

        function cart_summary() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('shipping.charge')); ?>",
                dataType: "html",
                success: function(response) {
                    $(".cart-summary").html(response);
                },
            });
        }
        function reloadCartMenu(){
            $.ajax({
                url: "<?php echo e(route('cart.menu')); ?>", // এটি তোমার route হতে হবে যা cartmenu view return করে
                type: "GET",
                success: function(data){
                    $(".cartmenu").html(data);
                },
                error: function(err){
                    console.log("Cart menu reload failed:", err);
                }
            });
        }
        $(".addcartbutton").on("click", function() {
            var id = $(this).data("id");
            var qty = 1;
            if (id) {
                $.ajax({
                    cache: "false",
                    type: "GET",
                    url: "<?php echo e(url('add-to-cart')); ?>/" + id + "/" + qty,
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart successfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });
        $(".cart_store").on("click", function() {
            var id = $(this).data("id");
            var qty = $(this).parent().find("input").val();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        qty: qty ? qty : 1
                    },
                    url: "<?php echo e(route('cart.store')); ?>",
                    success: function(data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart succfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });
                
        

                // Remove item from cart
                $(document).on("click", ".cart_removee", function() {
                    var id = $(this).data("id");
                    if (!id) return;

                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('cart.remove')); ?>",
                        data: { id: id },
                        success: function(data) {
                            if (data) {
                                $(".cartlist").html(data); // Update main cart HTML
                                cart_count();             // Update cart count
                                mobile_cart();            // Update mobile cart
                                cart_summary();           // Update cart summary
                                reloadCartMenu();         // Reload cart menu including combo products

                                // Update free shipping progress
                                let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                                updateFreeShippingProgress(subtotal);
                            }
                        },
                        error: function(err){
                            console.log("Remove error:", err);
                        }
                    });
                });
            

            $(".cart_incrementt").on("click", function() {
            var id = $(this).data("id");
            if (!id) return;

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('cart.increment')); ?>",
                data: { id: id },
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                         // Update cart HTML
                        cart_count();
                        mobile_cart();
                        reloadCartMenu();
                        
                        // Update free shipping progress
                        let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                        updateFreeShippingProgress(subtotal);
                         
                    }
                },
                error: function(err){
                    console.log("Increment error:", err);
                }
            });
        });

        $(".cart_decrementt").on("click", function() {
            var id = $(this).data("id");
            if (!id) return;

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('cart.decrement')); ?>",
                data: { id: id },
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data); // Update cart HTML
                        cart_count();
                        mobile_cart();
                        reloadCartMenu();
                        // Update free shipping progress
                        let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                        updateFreeShippingProgress(subtotal);
                    }
                },
                error: function(err){
                    console.log("Decrement error:", err);
                }
            });
        });
   

        
    </script>
    
    <script>
        $(document).ready(function() {
            $(".minus").click(function() {
                var $input = $(this).parent().find("input");
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $(".plus").click(function() {
                var $input = $(this).parent().find("input");
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
    </script>
    <!-- cart js end -->
    <script>
        $(".search_click").on("keyup change", function() {
            var keyword = $(".search_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "<?php echo e(route('livesearch')); ?>",
                success: function(products) {
                    if (products) {
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
        $(".msearch_click").on("keyup change", function() {
            var keyword = $(".msearch_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "<?php echo e(route('livesearch')); ?>",
                success: function(products) {
                    if (products) {
                        $("#loading").hide();
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
    </script>
    <!-- search js start -->
    <script></script>
    <script></script>
    <script>
        $(".district").on("change", function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: "<?php echo e(route('districts')); ?>",
                success: function(res) {
                    if (res) {
                        $(".area").empty();
                        $(".area").append('<option value="">Select..</option>');
                        $.each(res, function(key, value) {
                            $(".area").append('<option value="' + key + '" >' + value +
                                "</option>");
                        });
                    } else {
                        $(".area").empty();
                    }
                },
            });
        });
    </script>

    <script>
        $(".search-box-enter").on("click", function() {
            $("#page-overlay").show();
            $(".searchsectiontop").addClass("active");
        });

        $("#page-overlay").on("click", function() {
            $("#page-overlay").hide();
            $(".searchsectiontop").removeClass("active");

        });

        $(".crossmark-search").on("click", function() {
            $("#page-overlay").hide();
            $(".searchsectiontop").removeClass("active");
        });
    </script>
    <script>
        $(".carttoggle").on("click", function() {
            $("#page-overlay").show();
            $(".cartmenu").addClass("active");
        });

        $("#page-overlay").on("click", function() {
            $("#page-overlay").hide();
            $(".cartmenu").removeClass("active");

        });

        $(".crossmark").on("click", function() {
            $("#page-overlay").hide();
            $(".cartmenu").removeClass("active");
        });
    </script>

    <script>
        $(".toggle").on("click", function() {
            $("#page-overlay").show();
            $(".mobile-menu").addClass("active");
        });

        $("#page-overlay").on("click", function() {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
            $(".feature-products").removeClass("active");
        });

        $(".mobile-menu-close").on("click", function() {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
        });

        $(".mobile-filter-toggle").on("click", function() {
            $("#page-overlay").show();
            $(".feature-products").addClass("active");
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".parent-category").each(function() {
                const menuCatToggle = $(this).find(".menu-category-toggle");
                const secondNav = $(this).find(".second-nav");

                menuCatToggle.on("click", function() {
                    menuCatToggle.toggleClass("active");
                    secondNav.slideToggle("fast");
                    $(this).closest(".parent-category").toggleClass("active");
                });
            });
            $(".parent-subcategory").each(function() {
                const menuSubcatToggle = $(this).find(".menu-subcategory-toggle");
                const thirdNav = $(this).find(".third-nav");

                menuSubcatToggle.on("click", function() {
                    menuSubcatToggle.toggleClass("active");
                    thirdNav.slideToggle("fast");
                    $(this).closest(".parent-subcategory").toggleClass("active");
                });
            });
        });
    </script>

    <script>
        var menu = new MmenuLight(document.querySelector("#menu"), "all");

        var navigator = menu.navigation({
            selectedClass: "Selected",
            slidingSubmenus: true,
            // theme: 'dark',
            title: "ক্যাটাগরি",
        });

        var drawer = menu.offcanvas({
            // position: 'left'
        });

        //  Open the menu.
        document.querySelector('a[href="#menu"]').addEventListener("click", (evnt) => {
            evnt.preventDefault();
            drawer.open();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener("scroll", function() {
                if (window.scrollY > 300) {
                    document.querySelector(".navbar-top").classList.add("fixed-top");

                    document.querySelector(".navarea-menu").classList.add("addcolor");
                    document.querySelector(".header-list-items").classList.add("addcolor");
                    document.querySelector(".cart-dialog").classList.add("addcolor");
                    document.querySelector(".headermenulistsection").classList.add("addmargin");




                } else {
                    document.querySelector(".navbar-top").classList.remove("fixed-top");

                    document.querySelector(".navarea-menu").classList.remove("addcolor");
                    document.querySelector(".header-list-items").classList.remove("addcolor");
                    document.querySelector(".cart-dialog").classList.remove("addcolor");
                    document.querySelector(".mobile-header").classList.remove("addcolor");
                    document.querySelector(".headermenulistsection").classList.remove("addmargin");
                    document.body.style.paddingTop = "0";
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener("scroll", function() {
                if (window.scrollY > 300) {
                    document.querySelector(".mobile-header").classList.add("sticky");

                } else {
                    document.querySelector(".mobile-header").classList.remove("sticky");

                    document.body.style.paddingTop = "0";
                }
            });
        });
        /*=== Main Menu Fixed === */
        // document.addEventListener("DOMContentLoaded", function () {
        //     window.addEventListener("scroll", function () {
        //         if (window.scrollY > 0) {
        //             document.getElementById("m_navbar_top").classList.add("fixed-top");
        //             // add padding top to show content behind navbar
        //             navbar_height = document.querySelector(".navbar").offsetHeight;
        //             document.body.style.paddingTop = navbar_height + "px";
        //         } else {
        //             document.getElementById("m_navbar_top").classList.remove("fixed-top");
        //             // remove padding top from body
        //             document.body.style.paddingTop = "0";
        //         }
        //     });
        // });
        /*=== Main Menu Fixed === */

        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $(".scrolltop:hidden").stop(true, true).fadeIn();
            } else {
                $(".scrolltop").stop(true, true).fadeOut();
            }
        });
        $(function() {
            $(".scroll").click(function() {
                $("html,body").animate({
                    scrollTop: $(".gotop").offset().top
                }, "1000");
                return false;
            });
        });
    </script>
    <script>
        $(".filter_btn").click(function() {
            $(".filter_sidebar").addClass('active');
            $("body").css("overflow-y", "hidden");
        })
        $(".filter_close").click(function() {
            $(".filter_sidebar").removeClass('active');
            $("body").css("overflow-y", "auto");
        })
    </script>
    <!--search ANIMAtion end-->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo e($gtm->code); ?>" height="0"
            width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>
<?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/master.blade.php ENDPATH**/ ?>