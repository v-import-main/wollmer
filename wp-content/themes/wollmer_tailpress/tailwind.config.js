const _ = require("lodash");
const theme = require('./theme.json');
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");

module.exports = {
    content: [
        './*.html',
        './**/*.html',
        './*.php',
        './**/*.php',
        './resources/css/*.css',
        './resources/js/*.js',
        './safelist.txt'
    ],
    theme: {
        container: {
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '0rem'
            },
        },
        extend: {
            colors: tailpress.colorMapper(tailpress.theme('settings.color.palette', theme)),
            fontSize: tailpress.fontSizeMapper(tailpress.theme('settings.typography.fontSizes', theme)),
            aspectRatio: {
                '4/3': '4 / 3',
                '6/5': '6 / 5',
            },
            gridTemplateColumns: {
                'a1': 'auto minmax(auto, 1fr)',
                '1a': 'minmax(auto, 1fr) auto',
                'a1a': 'auto minmax(auto, 1fr) auto',
                '1a1': 'minmax(auto, 1fr) auto minmax(auto, 1fr)',
                'aa1': 'repeat(2,auto) minmax(auto, 1fr)',
                '1aa': 'minmax(auto, 1fr) repeat(2,auto)',
                'a11': 'minmax(auto, 1fr) repeat(2,auto, 1fr)',
                '11a': 'repeat(2,auto, 1fr) minmax(auto, 1fr)',
                full: '100%'
            }
        },
        screens: {
            'xs': '480px',
            'sm': '600px',
            'md': '782px',
            'lg': '976px',
            'xl': '1440px'
        }
    },
    plugins: [
        tailpress.tailwind
    ]
};
