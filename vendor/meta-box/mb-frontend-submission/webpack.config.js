const path = require('path');

module.exports = {
  devtool: '',
  entry: './assets/js/index.js',
  output: {
    filename: 'frontend-submission.js',
    path: path.resolve(__dirname, 'assets'),
  }
};