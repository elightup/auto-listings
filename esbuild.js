const esbuild = require( "esbuild" );
const { externalGlobalPlugin } = require( "esbuild-plugin-external-global" );

const config = {
	bundle: true,
	minify: true,
	loader: {
		'.js': 'jsx',
	},
	plugins: [
		externalGlobalPlugin( {
			'react': 'React',
			'react-dom': 'ReactDOM',
			'@wordpress/element': 'wp.element',
		} ),
	],
};

esbuild.build( {
	...config,
	entryPoints: [
        'assets/admin/js/search-form/index.js',
	 ],
	outfile: 'assets/admin/js/search-form.js',
} );
