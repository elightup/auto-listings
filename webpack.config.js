const path = require('path');

var config = {
    module: {
        rules: [
        {
            test: /\.js/,
            exclude: /node_modules/,
            use: {
            loader: 'babel-loader',
                options: {
                    plugins: ['@babel/plugin-transform-react-jsx', '@babel/plugin-proposal-class-properties']
                }
            }
        }
        ]
    }
};

var adminConfig = Object.assign( {}, config, {
    entry: [
        './assets/admin/js/editor.js',
        './assets/admin/js/tabs.js',
        './assets/admin/js/inserter.js',
    ],
    output: {
        path: path.resolve(__dirname, 'assets/admin/js'),
        filename: "search-form.js"
    },
} );

module.exports = [
    adminConfig
];