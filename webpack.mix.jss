let mix = require("laravel-mix");

const cssFiles = [
    "all.min.css",
    "animate.css",
    "app.css",
    "app.min.css",
    "bootstrap.min.css",
    "custom.css",
    "jquery-ui.css",
    "lighslider.css",
    "main.css",
    "mobile-menu.css",
    "nice-select.css",
    "owl.carousel.min.css",
    "owl.theme.default.min.css",
    "responsive.css",
    "select2.min.css",
    "slick-theme.css",
    "slick.css",
    "style.css",
    "wsit-menu.css",
    "zoomsl.css",
];

cssFiles.forEach((file) => {
    mix.styles(`resources/css/${file}`, `public/css/${file}`);
});

mix.copyDirectory("resources/fonts", "public/fonts").copyDirectory(
    "resources/img",
    "public/img"
);

mix.browserSync({
    proxy: "http://127.0.0.1:8000",
    files: [
        "resources/views/**/*.blade.php",
        "resources/css/**/*.css",
        "public/css/**/*.css",
        "public/js/**/*.js",
    ],
    open: false,
    notify: false,
});
