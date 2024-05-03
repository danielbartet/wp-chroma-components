const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin'); // Importación corregida
const autoprefixer = require('autoprefixer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    entry: {
        app: './src/index.js',
        errorcatcher: './components/error-reporting/js/error-catcher.js',
        quiz: './components/quiz/src/quiz-app.js',
        form: './components/forms/master-form.js'
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist')
    },
    devServer: {
        contentBase: './dist',
        compress: true
    },
    watch: true,
    watchOptions: {
        ignored: /node_modules/,
        poll: 3000 // Check for changes every second
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                parallel: true
            }),
            new OptimizeCssAssetsPlugin({})
        ]
    },
    plugins: [
        new CleanWebpackPlugin(), // Se utiliza la nueva importación corregida
        new MiniCssExtractPlugin({
            filename: 'cmquiz.css',
        }),
        new webpack.LoaderOptionsPlugin({
            options: {
                postcss: [
                    autoprefixer()
                ]
            }
        })
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'eslint-loader',
                        options: {
                            fix: true,
                            cache: true
                        }
                    },
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                ]
            },
            {
                test: /\.(sa|sc|c)ss$/,
                exclude: /node_modules/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'postcss-loader',
                    'sass-loader'
                ]
            },
        ]
    }
};