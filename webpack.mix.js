/**
 * Laravel Mix Configuration
 *
 * We use Laravel Mix as an easy-to-understand interface for webpack,
 * which can otherwise be quite complicated. Mix is super simple and
 * works very well.
 *
 * @link https://laravel.com/docs/5.6/mix
 *
 * @author  Bernskiold Media <info@bernskioldmedia.com>
 * @package BernskioldMedia\Equmeniakyrkan\Equmenisk
 **/

const mix = require( 'laravel-mix' );

/**************************************************************
 * Build Process
 *
 * This part handles all the compilation and concatenation of
 * all the theme's resources.
 *************************************************************/

/*
 * Asset Directory Path
 */
const assetPaths = {
	scripts: 'assets/scripts',
	styles: 'assets/styles',
	images: 'assets/images',
	fonts: 'assets/fonts'
};

/*
 * Set Laravel Mix options.
 *
 * @link https://laravel-mix.com/docs/5.0/css-preprocessors
 */
mix.options( {
	processCssUrls: false,
	postCss: [
		require( 'postcss-custom-properties' )(),
		require( 'postcss-preset-env' )( {
			stage: 4,
			browsers: [
				'> 1%',
				'last 2 versions',
				'ie >= 11'
			],
			autoprefixer: { grid: true }
		} )
	]
} );

/*
 * Process the SCSS
 *
 * @link https://laravel-mix.com/docs/5.0/css-preprocessors
 * @link https://github.com/sass/dart-sass#javascript-api
 */
const sassConfig = {
	sassOptions: {
		outputStyle: 'compressed',
		indentType: 'tab',
		indentWidth: 1,
	}
};

// Process the scss files.
mix.sass( `${ assetPaths.styles }/src/admin-bar.scss`, `${ assetPaths.styles }/dist`, sassConfig )
   .sass( `${ assetPaths.styles }/src/admin.scss`, `${ assetPaths.styles }/dist`, sassConfig );

/**
 * Maybe enable sourcemaps
 **/
if ( ! mix.inProduction() ) {
	mix.sourceMaps();
}

/*
 * Custom Webpack Config
 *
 * @link https://laravel.com/docs/6.x/mix#custom-webpack-configuration
 * @link https://webpack.js.org/configuration/
 */
mix.webpackConfig( {
	mode: mix.inProduction() ? 'production' : 'development',
	devtool: mix.inProduction() ? '' : 'source-map',
	stats: 'minimal',
	performance: {
		hints: false
	},
	externals: {
		jquery: 'jQuery'
	},
	watchOptions: {
		ignored: /node_modules/
	}
} );
