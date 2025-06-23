require('dotenv').config();
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = (env, argv) => {
    const mode = argv.mode || process.env.APP_ENV || 'production';
    
    return {
        mode: mode,
        entry: {},
        output: {
            path: path.resolve(__dirname, 'assets/')
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        },
        plugins: [
            new CopyWebpackPlugin({
                patterns: [ 
                    { from: './node_modules/bootstrap/dist/css/bootstrap.min.css', to: 'bootstrap/css/[name][ext]' },
                    { from: './node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', to: 'bootstrap/js/[name][ext]' },
                    { from: './node_modules/bootstrap-icons/font/bootstrap-icons.min.css', to: 'bootstrap/icons/css/[name][ext]' },
                    { from: './node_modules/bootstrap-icons/font/fonts/*', to: 'bootstrap/icons/css/fonts/[name][ext]' },
                    { from: './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css', to: 'bootstrap/css/[name][ext]' },
                    // { from: './node_modules/bootstrap-datepicker/dist/js/*.js', to: 'bootstrap/js/[name][ext]' },
                    { from: './node_modules/@fortawesome/fontawesome-free/css/all.min.css', to: 'build/fontawesome/css/[name][ext]' },
                    { from: './node_modules/@fortawesome/fontawesome-free/js/all.min.js', to: 'build/fontawesome/js/[name][ext]' }, 
                    { from: './node_modules/@fortawesome/fontawesome-free/scss/*.scss', to: 'build/fontawesome/scss/[name][ext]' }, 
                    { from: './node_modules/@fortawesome/fontawesome-free/webfonts/*', to: 'build/fontawesome/webfonts/[name][ext]' }, 
                    { from: './node_modules/print-js/dist/print.css', to: 'build/printjs/css/[name][ext]' },
                    { from: './node_modules/print-js/dist/print.js', to: 'build/printjs/js/[name][ext]' },
                    { from: './node_modules/select2/dist/css/select2.min.css', to: 'bootstrap/css/[name][ext]' },
                    { from: './node_modules/select2/dist/js/select2.min.js', to: 'bootstrap/js/[name][ext]' },
                    { from: './node_modules/toastr/build/toastr.min.css', to: 'build/toastr/css/[name][ext]' },
                    { from: './node_modules/toastr/build/toastr.min.js', to: 'build/toastr/js/[name][ext]' }, 
                    { from: './node_modules/chart.js/dist/chart.js', to: 'build/charts/js/[name][ext]' },
                    { from: './node_modules/sweetalert2/dist/sweetalert2.min.css', to: 'build/sweetalert/css/[name][ext]' },
                    { from: './node_modules/sweetalert2/dist/sweetalert2.all.min.js', to: 'build/sweetalert/js/[name][ext]' },
                    // { from: './node_modules/popper.js/dist/*.js', to: 'build/js/[name][ext]' }, // Use this if you are not using bootstrap.bundle.min.js
                    { from: './node_modules/datatables/media/css/jquery.dataTables.min.css', to: 'build/jquery/css/[name][ext]' },
                    { from: './node_modules/datatables/media/js/jquery.dataTables.min.js', to: 'build/jquery/js/[name][ext]' },
                    { from: './node_modules/jquery/dist/jquery.min.js', to: 'build/jquery/js/[name][ext]' },
                    { from: './node_modules/datatables/media/images', to: 'build/jquery/images' }, 
                    { from: './node_modules/animate.css/animate.min.css', to: 'build/animation/animate/css/[name][ext]' }, 
                    { from: './node_modules/nouislider/dist/nouislider.min.css', to: 'build/nouislider/css/[name][ext]' }, 
                    { from: './node_modules/nouislider/dist/nouislider.min.js', to: 'build/nouislider/js/[name][ext]' }, 
                ]
            })
        ],
        resolve: {
            extensions: ['.js', 'css']
        },
        devtool: 'source-map' // Optional, for easier debugging
    };
};