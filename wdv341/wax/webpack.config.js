/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
const env = require("../../../env.json");
const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");
const config = require("./package.json");

module.exports = {
	mode: process.env.NODE_ENV,
	entry: {
		waxAccount: "./src/js/waxAccount.js",
		waxAlbumEditor: "./src/js/waxAlbumEditor.js",
		waxBrowse: "./src/js/waxBrowse.js",
		waxContact: "./src/js/waxContact.js",
		waxIndex: "./src/js/waxIndex.js",
		waxRegister: "./src/js/waxRegister.js",
		waxSettings: "./src/js/waxSettings.js"
	},
	output: {
		path: path.resolve(__dirname, "../../assets/js"),
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
	plugins: [
		new VueLoaderPlugin(),
		new webpack.DefinePlugin({
			"VERSION": JSON.stringify(config.version)
		})
	]
};
