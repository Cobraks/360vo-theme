<?php
// classes/ColorPalette.php
if (! defined('ABSPATH')) {
    exit;
}

class E360VO_ColorPalette
{
    /**
     * Todas tus paletas de color.
     * Clave = slug que eliges en el Customizer ('azul', 'rojo', …)
     * Valor = array var-css => valor-hsla
     */
    protected static $palettes = [
        'azul' => [
            '--primary0'              => 'hsla(0,0%,0%,1)',
            '--primary5'              => 'hsla(225,100%,10.4%,1)',
            '--primary10'             => 'hsla(222,100%,14.9%,1)',
            '--primary15'             => 'hsla(220,100%,19.2%,1)',
            '--primary20'             => 'hsla(220,100%,23.7%,1)',
            '--primary25'             => 'hsla(220,90.5%,29%,1)',
            '--primary30'             => 'hsla(223,69.1%,35.5%,1)',
            '--primary35'             => 'hsla(223,58.7%,40.8%,1)',
            '--primary40'             => 'hsla(224,51.5%,46.1%,1)',
            '--primary50'             => 'hsla(225,54.8%,56.7%,1)',
            '--primary60'             => 'hsla(225,73.7%,67.3%,1)',
            '--primary70'             => 'hsla(225,100%,77.5%,1)',
            '--primary80'             => 'hsla(226,100%,85.3%,1)',
            '--primary90'             => 'hsla(230,100%,92.9%,1)',
            '--primary95'             => 'hsla(236,100%,96.9%,1)',
            '--primary99'             => 'hsla(285,100%,99.2%,1)',
            '--primary100'            => 'hsla(0,0%,100%,1)',

            '--secondary0'            => 'hsla(0,0%,0%,1)',
            '--secondary5'            => 'hsla(226,50%,8.6%,1)',
            '--secondary10'           => 'hsla(226,33.3%,12.9%,1)',
            '--secondary15'           => 'hsla(227,26.4%,17.1%,1)',
            '--secondary20'           => 'hsla(227,21.1%,21.4%,1)',
            '--secondary25'           => 'hsla(227,17.6%,25.7%,1)',
            '--secondary30'           => 'hsla(227,15.6%,30.2%,1)',
            '--secondary35'           => 'hsla(227,13.5%,34.9%,1)',
            '--secondary40'           => 'hsla(228,12.3%,39.8%,1)',
            '--secondary50'           => 'hsla(228,10.3%,49.4%,1)',
            '--secondary60'           => 'hsla(228,12.6%,59.6%,1)',
            '--secondary70'           => 'hsla(231,17.9%,70.4%,1)',
            '--secondary80'           => 'hsla(231,29.2%,81.2%,1)',
            '--secondary90'           => 'hsla(231,70%,92.2%,1)',
            '--secondary95'           => 'hsla(236,100%,96.9%,1)',
            '--secondary98'           => 'hsla(257,100%,98.6%,1)',
            '--secondary99'           => 'hsla(285,100%,99.2%,1)',
            '--secondary100'          => 'hsla(0,0%,100%,1)',

            '--tertiary0'             => 'hsla(0,0%,0%,1)',
            '--tertiary5'             => 'hsla(300,63.2%,7.5%,1)',
            '--tertiary10'            => 'hsla(302,41%,12%,1)',
            '--tertiary15'            => 'hsla(304,32.5%,16.3%,1)',
            '--tertiary20'            => 'hsla(304,25.7%,20.6%,1)',
            '--tertiary25'            => 'hsla(304,21.9%,25.1%,1)',
            '--tertiary30'            => 'hsla(306,19.7%,29.8%,1)',
            '--tertiary35'            => 'hsla(306,17.7%,34.3%,1)',
            '--tertiary40'            => 'hsla(308,16%,39.2%,1)',
            '--tertiary50'            => 'hsla(307,13.6%,49%,1)',
            '--tertiary60'            => 'hsla(309,16.9%,59.4%,1)',
            '--tertiary70'            => 'hsla(310,24.2%,70%,1)',
            '--tertiary80'            => 'hsla(311,40.2%,81%,1)',
            '--tertiary90'            => 'hsla(312,100%,92%,1)',
            '--tertiary95'            => 'hsla(318,100%,96.1%,1)',
            '--tertiary98'            => 'hsla(338,100%,98.4%,1)',
            '--tertiary99'            => 'hsla(300,100%,99.2%,1)',
            '--tertiary100'           => 'hsla(0,0%,100%,1)',

            '--neutral0'              => 'hsla(0,0%,0%,1)',
            '--neutral5'              => 'hsla(225,11.1%,7.1%,1)',
            '--neutral10'             => 'hsla(240,6.9%,11.4%,1)',
            '--neutral15'             => 'hsla(240,5.1%,15.3%,1)',
            '--neutral20'             => 'hsla(240,4%,19.6%,1)',
            '--neutral25'             => 'hsla(240,3.3%,23.9%,1)',
            '--neutral30'             => 'hsla(240,2.8%,28.2%,1)',
            '--neutral35'             => 'hsla(240,2.4%,32.9%,1)',
            '--neutral40'             => 'hsla(240,2.1%,37.6%,1)',
            '--neutral50'             => 'hsla(255,1.7%,47.1%,1)',
            '--neutral60'             => 'hsla(255,1.8%,57.3%,1)',
            '--neutral70'             => 'hsla(264,3%,67.6%,1)',
            '--neutral80'             => 'hsla(255,3.6%,78.4%,1)',
            '--neutral82'             => 'hsla(270,7.4%,89.4%,1)',
            '--neutral85'             => 'hsla(240,1.4%,85.7%,1)',
            '--neutral87'             => 'hsla(0,0%,87.5%,1)',
            '--neutral90'             => 'hsla(0,0%,100%,1)',
            '--neutral92'             => 'hsla(0,0%,85.1%,1)',
            '--neutral95'             => 'hsla(270,15.4%,94.9%,1)',
            '--neutral98'             => 'hsla(276,55.6%,98.2%,1)',
            '--neutral99'             => 'hsla(285,100%,99.2%,1)',
            '--neutral100'            => 'hsla(0,0%,100%,1)',

            '--neutral-variant0'      => 'hsla(0,0%,0%,1)',
            '--neutral-variant5'      => 'hsla(227,23.1%,7.6%,1)',
            '--neutral-variant10'     => 'hsla(228,16.7%,11.8%,1)',
            '--neutral-variant15'     => 'hsla(233,11.1%,15.9%,1)',
            '--neutral-variant20'     => 'hsla(228,9.8%,20%,1)',
            '--neutral-variant25'     => 'hsla(228,8.1%,24.3%,1)',
            '--neutral-variant30'     => 'hsla(234,6.8%,29%,1)',
            '--neutral-variant35'     => 'hsla(234,5.8%,33.7%,1)',
            '--neutral-variant40'     => 'hsla(234,5.1%,38.4%,1)',
            '--neutral-variant50'     => 'hsla(235,4.5%,48%,1)',
            '--neutral-variant60'     => 'hsla(235,5.2%,58.2%,1)',
            '--neutral-variant70'     => 'hsla(240,6.3%,68.6%,1)',
            '--neutral-variant80'     => 'hsla(235,10.5%,79.4%,1)',
            '--neutral-variant82'     => 'hsla(237,9.2%,76.2%,1)',
            '--neutral-variant85'     => 'hsla(238,9.9%,78%,1)',
            '--neutral-variant87'     => 'hsla(238,10.2%,78.7%,1)',
            '--neutral-variant90'     => 'hsla(240,20.8%,90.6%,1)',
            '--neutral-variant95'     => 'hsla(240,50%,96.1%,1)',
            '--neutral-variant98'     => 'hsla(257,100%,98.6%,1)',
            '--neutral-variant99'     => 'hsla(285,100%,99.2%,1)',
            '--neutral-variant100'    => 'hsla(0,0%,100%,1)',

            '--key-colors--primary'   => 'hsla(224,51.5%,46.1%,1)',
            '--key-colors--secondary' => 'hsla(228,12.3%,39.8%,1)',
            '--key-colors--tertiary'  => 'hsla(308,16%,39.2%,1)',
            '--key-colors--error'     => 'hsla(0,75.5%,41.6%,1)',
            '--key-colors--neutral'   => 'hsla(240,2.1%,37.6%,1)',
            '--key-colors--neutral-variant' => 'hsla(234,5.1%,38.4%,1)',

            '--lightsurface1'         => 'hsla(285,100%,99.2%,1)',
            '--lightsurface2'         => 'hsla(285,100%,99.2%,1)',
            '--lightsurface3'         => 'hsla(285,100%,99.2%,1)',
            '--lightsurface4'         => 'hsla(285,100%,99.2%,1)',
            '--lightsurface5'         => 'hsla(285,100%,99.2%,1)',

            '--surface1'              => 'hsla(231,9%,15%,1)',
            '--surface2'              => 'hsla(228,11%,17%,1)',
            '--surface3'              => 'hsla(230,12%,20%,1)',
            '--surface4'              => 'hsla(230,13%,21%,1)',
            '--surface5'              => 'hsla(228,14%,22%,1)',
        ],
        'rojo' => [
            '--primary10'   => 'hsla(0,100%,15%,1)',
            '--primary20'   => 'hsla(0,100%,25%,1)',
            
        ],
        
    ];

    public function __construct()
    {
        // Priority muy bajo para que salga justo después de <meta> y antes de tus CSS
        add_action('wp_head', [$this, 'print_inline_palette'], 5);
    }

    public function print_inline_palette()
    {
        $scheme = get_theme_mod('th360_color_scheme', 'azul');
        if (empty(self::$palettes[$scheme])) return;

        $css = ':root{';
        foreach (self::$palettes[$scheme] as $var => $val) {
            $css .= "{$var}:{$val};";
        }
        $css .= '}';
        echo "<style id=\"e360vo-color-palette\">{$css}</style>";
    }
}
