<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$flat_pm_css = get_option( 'flat_pm_css' );
$flat_pm_stylization = get_option( 'flat_pm_stylization' );

$default_options = include_once FLATPM_DEFAULTS . '/options.php';

$cross_offset     = ( $flat_pm_stylization['cross']['offset'] === 'true' ) ? $flat_pm_stylization['cross']['height'] : '0';
$cross_height     = ( $flat_pm_stylization['cross']['height'] === '' )     ? $default_options['flat_pm_stylization']['cross']['height']     : $flat_pm_stylization['cross']['height'];
$cross_width      = ( $flat_pm_stylization['cross']['width'] === '' )      ? $default_options['flat_pm_stylization']['cross']['width']      : $flat_pm_stylization['cross']['width'];
$cross_background = ( $flat_pm_stylization['cross']['background'] === '' ) ? $default_options['flat_pm_stylization']['cross']['background'] : $flat_pm_stylization['cross']['background'];
$cross_thickness  = ( $flat_pm_stylization['cross']['thickness'] === '' )  ? $default_options['flat_pm_stylization']['cross']['thickness']  : $flat_pm_stylization['cross']['thickness'];
$cross_crosshair  = ( $flat_pm_stylization['cross']['crosshair'] === '' )  ? $default_options['flat_pm_stylization']['cross']['crosshair']  : $flat_pm_stylization['cross']['crosshair'];
$cross_text       = $flat_pm_stylization['cross']['text'];
?>
<!--noptimize-->
<noscript data-noptimize id="fpm_modul">
<style>
html{max-width:100vw}
.fpm-async:not([data-fpm-type="outgoing"]) + .fpm-async:not([data-fpm-type="outgoing"]){display:none}
[data-fpm-type]{background-color:transparent;transition:background-color .2s ease}
[data-fpm-type]{position:relative;overflow:hidden;border-radius:3px;z-index:0}
<?php if( $flat_pm_stylization['ad_preloader']['style'] !== 'none' ){ ?>
[data-fpm-type]:before {content:'<?php echo esc_html( $flat_pm_stylization['ad_preloader']['text'] ); ?>';position:absolute;color:<?php echo esc_html( $flat_pm_stylization['ad_preloader']['color'] ); ?>;top:1px;left:1px;right:1px;bottom:1px;display:flex;justify-content:center;align-items:center;<?php if( in_array( $flat_pm_stylization['ad_preloader']['style'], array( 'animation', 'greybackground' ) ) ){ ?>background-color:<?php echo esc_html( $flat_pm_stylization['ad_preloader']['background'] ); ?>;<?php } ?>
<?php if( in_array( $flat_pm_stylization['ad_preloader']['style'], array( 'greyborder' ) ) ){ ?>
border:1px solid <?php echo esc_html( $flat_pm_stylization['ad_preloader']['background'] ); ?>;<?php } ?>font-size:18px;z-index:-2;transition:opacity .4s ease;}
<?php if( $flat_pm_stylization['ad_preloader']['style'] === 'animation' ){ ?>
[data-fpm-type]:after{content:'';position:absolute;top:1px;left:1px;right:1px;bottom:1px;background-image:linear-gradient(to right,transparent,rgba(255,255,255,.6),transparent);transform:translateX(-100%);z-index:-1;animation:fpm-loader 2s ease-in-out infinite;z-index:-1;transition:opacity .4s ease;}
<?php } ?>
@keyframes fpm-loader {to{transform:translateX(100%)}}
<?php } ?>
.fpm-cross{transition:box-shadow .2s ease;position:absolute;top:-<?php echo esc_html( $cross_offset ); ?>px;right:0;width:<?php echo esc_html( $cross_width ); ?>px;height:<?php echo esc_html( $cross_height ); ?>px;background:<?php echo esc_html( $cross_background ); ?>;display:block;cursor:pointer;z-index:99;border:none;padding:0;min-width:0;min-height:0}
.fpm-cross:hover{box-shadow:0 0 0 50px rgba(0,0,0,.2) inset}
.fpm-cross:after,
.fpm-cross:before{transition:transform .3s ease;content:'';display:block;position:absolute;top:0;left:0;right:0;bottom:0;width:calc(<?php echo esc_html( min( $cross_height, $cross_width ) ); ?>px / 2);height:<?php echo esc_html( $cross_thickness ); ?>px;background:<?php echo esc_html( $cross_crosshair ); ?>;transform-origin:center;transform:rotate(45deg);margin:auto}
.fpm-cross:before{transform:rotate(-45deg)}
.fpm-cross:hover:after{transform:rotate(225deg)}
.fpm-cross:hover:before{transform:rotate(135deg)}
.fpm-timer{position:absolute;top:-<?php echo esc_html( $cross_offset ); ?>px;right:0;padding:0 15px;color:<?php echo esc_html( $cross_text ); ?>;background:<?php echo esc_html( $cross_background ); ?>;line-height:<?php echo esc_html( $cross_height ); ?>px;height:<?php echo esc_html( $cross_height ); ?>px;text-align:center;font-size:14px;z-index:99}
[data-fpm-type="outgoing"].center .fpm-timer,[data-fpm-type="outgoing"].center .fpm-cross{top:0!important}
.fpm-timer span{font-size:16px;font-weight:600}
[data-fpm-type="outgoing"]{transition:transform <?php echo esc_html( $flat_pm_stylization['outgoing']['speed'] ); ?>ms ease,opacity <?php echo esc_html( $flat_pm_stylization['outgoing']['speed'] ); ?>ms ease,min-width 0s;transition-delay:0s,0s,.3s;position:fixed;min-width:250px!important;z-index:9999;opacity:0;background:<?php echo esc_html( $flat_pm_stylization['outgoing']['background'] ); ?>;pointer-events:none;will-change:transform;overflow:visible;max-width:100vw}

<?php if( $flat_pm_stylization['cross']['offset'] === 'true' ){ ?>
[data-fpm-type="outgoing"].top-center .fpm-timer,
[data-fpm-type="outgoing"].left-top .fpm-timer{top:0;right:0}
[data-fpm-type="outgoing"].top-center .fpm-cross,
[data-fpm-type="outgoing"].left-top .fpm-cross{top:0;right:-<?php echo esc_html( $cross_offset ); ?>px}
[data-fpm-type="outgoing"].right-top .fpm-timer{top:0;left:0;right:auto}
[data-fpm-type="outgoing"].right-top .fpm-cross{top:0;left:-<?php echo esc_html( $cross_offset ); ?>px;right:auto}
<?php } ?>

[data-fpm-type="outgoing"] *{max-width:none}

[data-fpm-type="outgoing"].left-top [id*="yandex_rtb_"],
[data-fpm-type="outgoing"].right-top [id*="yandex_rtb_"],
[data-fpm-type="outgoing"].left-center [id*="yandex_rtb_"],
[data-fpm-type="outgoing"].right-center [id*="yandex_rtb_"],
[data-fpm-type="outgoing"].left-bottom [id*="yandex_rtb_"],
[data-fpm-type="outgoing"].right-bottom [id*="yandex_rtb_"]{max-width:336px;min-width:160px}

[data-fpm-type].no-preloader:after,[data-fpm-type].no-preloader:before,
[data-fpm-type="outgoing"]:after,[data-fpm-type="outgoing"]:before{display:none}

[data-fpm-type="outgoing"].fpm-show{opacity:1;pointer-events:all;min-width:0!important}

<?php if( $flat_pm_stylization['outgoing']['popup_animation'] === '0' ){ ?>
[data-fpm-type="outgoing"].center{position:fixed;top:50%;left:50%;height:auto;z-index:-2;opacity:0;transform:translateX(-50%) translateY(-50%)}
[data-fpm-type="outgoing"].center.fpm-show{opacity:1}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['popup_animation'] === '1' ){ ?>
[data-fpm-type="outgoing"].center{position:fixed;top:50%;left:50%;height:auto;z-index:-2;opacity:0;transform:translateX(-50%) translateY(-50%) scale(.6)}
[data-fpm-type="outgoing"].center.fpm-show{transform:translateX(-50%) translateY(-50%) scale(1);opacity:1}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['popup_animation'] === '2' ){ ?>
[data-fpm-type="outgoing"].center{position:fixed;top:50%;left:50%;height:auto;z-index:-2;opacity:0;transform:translateX(-50%) translateY(-40%)}
[data-fpm-type="outgoing"].center.fpm-show{transform:translateX(-50%) translateY(-50%);opacity:1}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['popup_animation'] === '3' ){ ?>
[data-fpm-type="outgoing"].center{position:fixed;top:50%;left:50%;height:auto;z-index:-2;opacity:0;transform:translateX(-50%) translateY(-50%) scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].center.fpm-show{transform:translateX(-50%) translateY(-50%) scale(1) rotate(0);opacity:1}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['popup_animation'] === '4' ){ ?>
[data-fpm-type="outgoing"].center{position:fixed;top:50%;left:50%;height:auto;z-index:-2;opacity:0;transform:translateX(-50%) translateY(-50%) scale(2)}
[data-fpm-type="outgoing"].center.fpm-show{transform:translateX(-50%) translateY(-50%) scale(1);opacity:1}
<?php } ?>
[data-fpm-type="outgoing"].center.fpm-show{z-index:2000}

<?php if( $flat_pm_stylization['outgoing']['sticky_animation'] === '0' ){ ?>
[data-fpm-type="outgoing"].left-top{top:0;left:0}
[data-fpm-type="outgoing"].top-center{top:0;left:50%;transform:translateX(-50%)}
[data-fpm-type="outgoing"].right-top{top:0;right:0}
[data-fpm-type="outgoing"].left-center{top:50%;left:0;transform:translateY(-50%)}
[data-fpm-type="outgoing"].right-center{top:50%;right:0;transform:translateY(-50%)}
[data-fpm-type="outgoing"].left-bottom{bottom:0;left:0}
[data-fpm-type="outgoing"].bottom-center{bottom:0;left:50%;transform:translateX(-50%)}
[data-fpm-type="outgoing"].right-bottom{bottom:0;right:0}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['sticky_animation'] === '1' ){ ?>
[data-fpm-type="outgoing"].left-top{top:0;left:0;transform:scale(.6)}
[data-fpm-type="outgoing"].top-center{top:0;left:50%;transform:translateX(-50%) scale(.6)}
[data-fpm-type="outgoing"].right-top{top:0;right:0;transform:scale(.6)}
[data-fpm-type="outgoing"].left-center{top:50%;left:0;transform:translateY(-50%) scale(.6)}
[data-fpm-type="outgoing"].right-center{top:50%;right:0;transform:translateY(-50%) scale(.6)}
[data-fpm-type="outgoing"].left-bottom{bottom:0;left:0;transform:scale(.6)}
[data-fpm-type="outgoing"].bottom-center{bottom:0;left:50%;transform:translateX(-50%) scale(.6)}
[data-fpm-type="outgoing"].right-bottom{bottom:0;right:0;transform:scale(.6)}
[data-fpm-type="outgoing"].fpm-show.left-top{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.top-center{transform:translateX(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-top{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.left-center{transform:translateY(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-center{transform:translateY(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.left-bottom{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.bottom-center{transform:translateX(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-bottom{transform:scale(1)}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['sticky_animation'] === '2' ){ ?>
[data-fpm-type="outgoing"].left-top{top:0;left:0;transform:translateX(-100%)}
[data-fpm-type="outgoing"].top-center{top:0;left:50%;transform:translateX(-50%) translateY(-100%)}
[data-fpm-type="outgoing"].right-top{top:0;right:0;transform:translateX(100%)}
[data-fpm-type="outgoing"].left-center{top:50%;left:0;transform:translateX(-100%) translateY(-50%)}
[data-fpm-type="outgoing"].right-center{top:50%;right:0;transform:translateX(100%) translateY(-50%)}
[data-fpm-type="outgoing"].left-bottom{bottom:0;left:0;transform:translateX(-100%)}
[data-fpm-type="outgoing"].bottom-center{bottom:0;left:50%;transform:translateX(-50%) translateY(100%)}
[data-fpm-type="outgoing"].right-bottom{bottom:0;right:0;transform:translateX(100%)}
[data-fpm-type="outgoing"].fpm-show.left-center,
[data-fpm-type="outgoing"].fpm-show.right-center{transform:translateX(0) translateY(-50%)}
[data-fpm-type="outgoing"].fpm-show.top-center,
[data-fpm-type="outgoing"].fpm-show.bottom-center{transform:translateX(-50%) translateY(0)}
[data-fpm-type="outgoing"].fpm-show.left-top,
[data-fpm-type="outgoing"].fpm-show.right-top,
[data-fpm-type="outgoing"].fpm-show.left-bottom,
[data-fpm-type="outgoing"].fpm-show.right-bottom{transform:translateX(0)}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['sticky_animation'] === '3' ){ ?>
[data-fpm-type="outgoing"].left-top{top:0;left:0;transform:scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].top-center{top:0;left:50%;transform:translateX(-50%) scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].right-top{top:0;right:0;transform:scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].left-center{top:50%;left:0;transform:translateY(-50%) scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].right-center{top:50%;right:0;transform:translateY(-50%) scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].left-bottom{bottom:0;left:0;transform:scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].bottom-center{bottom:0;left:50%;transform:translateX(-50%) scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].right-bottom{bottom:0;right:0;transform:scale(.2) rotate(720deg)}
[data-fpm-type="outgoing"].fpm-show.left-top{transform:scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.top-center{transform:translateX(-50%) scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.right-top{transform:scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.left-center{transform:translateY(-50%) scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.right-center{transform:translateY(-50%) scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.left-bottom{transform:scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.bottom-center{transform:translateX(-50%) scale(1) rotate(0)}
[data-fpm-type="outgoing"].fpm-show.right-bottom{transform:scale(1) rotate(0)}
<?php } ?>
<?php if( $flat_pm_stylization['outgoing']['sticky_animation'] === '4' ){ ?>
[data-fpm-type="outgoing"].left-top{top:0;left:0;transform:scale(2)}
[data-fpm-type="outgoing"].top-center{top:0;left:50%;transform:translateX(-50%) scale(2)}
[data-fpm-type="outgoing"].right-top{top:0;right:0;transform:scale(2)}
[data-fpm-type="outgoing"].left-center{top:50%;left:0;transform:translateY(-50%) scale(2)}
[data-fpm-type="outgoing"].right-center{top:50%;right:0;transform:translateY(-50%) scale(2)}
[data-fpm-type="outgoing"].left-bottom{bottom:0;left:0;transform:scale(2)}
[data-fpm-type="outgoing"].bottom-center{bottom:0;left:50%;transform:translateX(-50%) scale(2)}
[data-fpm-type="outgoing"].right-bottom{bottom:0;right:0;transform:scale(2)}
[data-fpm-type="outgoing"].fpm-show.left-top{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.top-center{transform:translateX(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-top{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.left-center{transform:translateY(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-center{transform:translateY(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.left-bottom{transform:scale(1)}
[data-fpm-type="outgoing"].fpm-show.bottom-center{transform:translateX(-50%) scale(1)}
[data-fpm-type="outgoing"].fpm-show.right-bottom{transform:scale(1)}
<?php } ?>

.fpm-overlay{position:fixed;width:100%;height:100%;pointer-events:none;top:0;left:0;z-index:1000;opacity:0;background:<?php echo esc_html( $flat_pm_stylization['outgoing']['overlay'] ); ?>;transition:all <?php echo esc_html( $flat_pm_stylization['outgoing']['speed'] ); ?>ms ease;-webkit-backdrop-filter:blur(<?php echo esc_html( $flat_pm_stylization['outgoing']['blur'] ); ?>px);backdrop-filter:blur(<?php echo esc_html( $flat_pm_stylization['outgoing']['blur'] ); ?>px)}
[data-fpm-type="outgoing"].center.fpm-show ~ .fpm-overlay{opacity:1;pointer-events:all}
.fpm-fixed{position:fixed;z-index:50}
.fpm-stop{position:relative;z-index:50}
.fpm-preroll{position:relative;overflow:hidden;display:block}
.fpm-preroll.hasIframe{padding-bottom:56.25%;height:0}
.fpm-preroll iframe{display:block;width:100%;height:100%;position:absolute}
.fpm-preroll_flex{display:flex;align-items:center;justify-content:center;position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.65);opacity:0;transition:opacity .35s ease;z-index:2}
.fpm-preroll_flex.fpm-show{opacity:1}
.fpm-preroll_flex.fpm-hide{pointer-events:none;z-index:-1}
.fpm-preroll_item{position:relative;max-width:calc(100% - 68px);max-height:100%;z-index:-1;pointer-events:none;cursor:default}
.fpm-preroll_flex.fpm-show .fpm-preroll_item{z-index:3;pointer-events:all}
.fpm-preroll_flex .fpm-timer,
.fpm-preroll_flex .fpm-cross{top:10px!important;right:10px!important}
.fpm-preroll_hover{position:absolute;top:0;left:0;right:0;bottom:0;width:100%;height:100%;z-index:2}
.fpm-preroll_flex:not(.fpm-show) .fpm-preroll_hover{cursor:pointer}
.fpm-hoverroll{position:relative;overflow:hidden;display:block}
.fpm-hoverroll_item{position:absolute;bottom:0;left:50%;margin:auto;transform:translateY(100%) translateX(-50%);transition:all <?php echo esc_html( $flat_pm_stylization['outgoing']['speed'] ); ?>ms ease;z-index:1000;max-height:100%}

.fpm-preroll_item [id*="yandex_rtb_"],
.fpm-hoverroll_item [id*="yandex_rtb_"]{min-width:160px}

.fpm-hoverroll:hover .fpm-hoverroll_item:not(.fpm-hide){transform:translateY(0) translateX(-50%)}
.fpm-slider{display:grid}
.fpm-slider > *{grid-area:1/1;margin:auto;opacity:0;transform:translateX(200px);transition:all <?php echo esc_html( ( 1.4 * $flat_pm_stylization['outgoing']['speed'] ) ); ?>ms ease;pointer-events:none;width:100%;z-index:0}
.fpm-slider > *.fpm-hide{transform:translateX(-100px)!important;opacity:0!important;z-index:0!important}
.fpm-slider > *.fpm-show{transform:translateX(0);pointer-events:all;opacity:1;z-index:1}
.fpm-slider .fpm-timeline{width:100%;height:2px;background:#f6f5ff;position:relative}
.fpm-slider .fpm-timeline:after{content:'';position:absolute;background:#d5ceff;height:100%;transition:all <?php echo esc_html( $flat_pm_stylization['outgoing']['speed'] ); ?>ms ease;width:0}
.fpm-slider > *.fpm-show .fpm-timeline:after{animation:timeline var(--duration) ease}
.fpm-slider > *:hover .fpm-timeline:after{animation:timeline-hover}
@keyframes timeline-hover{}
@keyframes timeline{0% {width:0}100% {width:100%}}
<?php echo wp_kses_post( stripslashes( $flat_pm_css ) ); ?>
</style>
</noscript>
<!--/noptimize-->


<!--noptimize-->
<?php
$javascript = file_get_contents( FLATPM_DIR . '/assets/front/main.js' );

echo wp_get_inline_script_tag( $javascript, array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
?>
<!--/noptimize-->