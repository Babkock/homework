/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock

	src/css  =>  assets/css
	src/js   =>  assets/js
*/
const env = require('../../../env.json');
const path = require('path');
const webpack = require('webpack');
const { VueLoaderPlugin } = require('vue-loader');
const config = require('./package.json');

module.exports = {
	mode: process.env.NODE_ENV,
	entry: {
		display: "./src/js/display.js",
		editor: "./src/js/editor.js"
	},
	output: {
		path: path.resolve(__dirname, "./assets/js"),
		filename: "[name].min.js",
		libraryTarget: "umd",
		umdNamedDefine: true
	},
	module: {
		rules: [{
			test: /\.scss$/,
			use: [
				{
					loader: "file-loader",
					options: {
						name: "../css/[name].css"
					}
				}, {
					loader: "extract-loader"
				}, {
					loader: "css-loader"
				}, {
					loader: "sass-loader",
					options: {
						outputStyle: "compact"
					}
				}
			]
		}, {
			test: /\.vue$/,
			loader: "vue-loader",
			options: {
				loaders: {
					"scss": ["style-loader", "css-loader", "sass-loader"]
				}
			}
		}]
	},
	resolve: {
		alias: {
			"vue": "vue/dist/vue.esm.js"
		},
		extensions: ['*', '.js', '.vue', '.json']
	},
	externals: {
		vue: {

		}
	},
	plugins: [
		new VueLoaderPlugin(),
		new webpack.DefinePlugin({
			"VERSION": JSON.stringify(config.version)
		})
	]
}