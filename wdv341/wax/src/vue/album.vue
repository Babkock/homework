<template>
	<div class="album" :id="myid">
		<div class="cover">
			<slot name="img"></slot>
		</div>
		<h2><a :href="idhref">#</a> <a :href="artisthref" v-text="aartist"></a> - <i><a :href="albumhref" v-text="atitle"></a></i></h2>
		<button class="expand" @click="ToggleAlbumDetails()" v-text="expandText"></button>
		<div v-if="showingExtra">
			<h3 v-if="apurchased === 'n'"><span class="price" :title="currencyexpand" :alt="currencyexpand"><span v-html="currencysymbol"></span>{{ aprice }}</span> from <a :href="sellerhref" v-text="aseller"></a></h3>
			<h3 v-else>Sold for <span class="price" :title="currencyexpand" :alt="currencyexpand"><span v-html="currencysymbol"></span>{{ aprice }}</span> to <a :href="buyerhref" v-text="abuyer"></a></h3>
			<slot name="info"></slot>
			<div class="alb-info">
				<div class="prop">
					Country:
				</div>
				<div class="val">
					<b class="country" v-text="countryexpand"></b>
				</div>
			</div>
			<div class="alb-info">
				<div class="prop">
					Date Posted:
				</div>
				<div class="val">
					<b class="date" v-text="niceposted"></b>
				</div>
			</div>
			<div class="alb-info" v-if="apurchased !== 'n'">
				<div class="prop">
					Date Purchased:
				</div>
				<div class="val">
					<b class="date" v-text="nicepurchased"></b>
				</div>
			</div>
			<h3>Tracklist:</h3>
			<slot name="tracklist">
			</slot>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: Number,
			required: true
		},
		aartist: {
			type: String,
			default: "Unknown Artist"
		},
		atitle: {
			type: String,
			default: "Unknown Album"
		},
		aposted: {
			type: String,
			required: true
		},
		acountry: {
			type: String,
			default: "us"
		},
		aprice: {
			type: String,
			required: true
		},
		acurrency: {
			type: String,
			default: "usd"
		},
		aseller: {
			type: String,
			required: true
		},
		asellerid: {
			type: Number,
			required: true
		},
		abuyer: {
			type: String,
			default: ""
		},
		abuyerid: {
			type: Number,
			default: null
		},
		apurchased: {
			type: String,
			required: true
		}
	},

	data: () => {
		return {
			showingExtra: false,
			expandText: "  +  "
		};
	},

	computed: {
		artisthref: function() {
			return "browse?a=" + encodeURI(this.aartist);
		},

		albumhref: function() {
			return "browse?b=" + encodeURI(this.atitle);
		},

		idhref: function() {
			return "browse?id=" + this.myid;
		},

		niceposted: function() {
			let jsDate = new Date(Date.parse(this.aposted.replace(/[-]/g, '/')));
			return jsDate.toDateString();
		},

		nicepurchased: function() {
			let jsDate = new Date(Date.parse(this.apurchased.replace(/[-]/g, '/')));
			return jsDate.toDateString();
		},

		sellerhref: function() {
			return "user?id=" + this.asellerid;
		},

		buyerhref: function() {
			return "user?id=" + this.abuyerid;
		},

		alclass: function() {
			return ((this.abuyer != null) ? "album" : "album sold");
		},

		countryexpand: function() {
			let c = "";
			switch (this.acountry.toLowerCase()) {
				case "us":
					c = "United States";
					break;
				case "mx":
					c = "Mexico";
					break;
				case "uk":
					c = "United Kingdom";
					break;
				case "ie":
					c = "Ireland";
					break;
				case "es":
					c = "Spain";
					break;
				case "fr":
					c = "France";
					break;
				case "ca":
					c = "Canada";
					break;
				case "de":
					c = "Germany";
					break;
				case "ru":
					c = "Russian Federation";
					break;
				case "it":
					c = "Italy";
					break;
				case "fi":
					c = "Finland";
					break;
				case "dk":
					c = "Denmark";
					break;
				case "se":
					c = "Sweden";
					break;
				case "no":
					c = "Norway";
					break;
				case "nl":
					c = "Netherlands";
					break;
				case "au":
					c = "Australia";
					break;
				case "cn":
					c = "China";
					break;
				case "jp":
					c = "Japan";
					break;
				case "kr":
					c = "South Korea";
					break;
				case "ph":
					c = "Philippines";
					break;
				case "lv":
					c = "Latvia";
					break;
				case "cz":
					c = "Czech Republic";
					break;
				case "br":
					c = "Brazil";
					break;
				case "is":
					c = "Iceland";
					break;
				case "am":
					c = "Armenia";
					break;
				case "az":
					c = "Azerbaijan";
					break;
				case "ch":
					c = "Switzerland";
					break;
				case "tr":
					c = "Turkey";
					break;
				case "at":
					c = "Austria";
					break;
				case "ua":
					c = "Ukraine";
					break;
				case "ba":
					c = "Bosnia and Herzegovina";
					break;
				case "in":
					c = "India";
					break;
				case "hu":
					c = "Hungary";
					break;
				case "ro":
					c = "Romania";
					break;
				default:
					c = "Unknown Country";
					break;
			}
			return c;
		},

		currencyexpand: function() {
			let c = "";
			switch (this.acurrency.toLowerCase()) {
				case "usd":
					c = "US Dollars";
					break;
				case "cad":
					c = "Canadian Dollars";
					break;
				case "mxn":
					c = "Mexican Pesos";
					break;
				case "gbp":
					c = "GB Pounds";
					break;
				case "rub":
					c = "Russian Rubles";
					break;
				case "dkk":
					c = "Danish Krone";
					break;
				case "sek":
					c = "Swedish Krona";
					break;
				case "isk":
					c = "Iceland Krona";
					break;
				case "eur":
					c = "Euros";
					break;
				case "pln":
					c = "Poland Zloty";
					break;
				case "krw":
					c = "Korean Won";
					break;
				case "jpy":
					c = "Japanese Yen";
					break;
				case "nok":
					c = "Norweigan Krone";
					break;
				case "ang":
					c = "Dutch Guilders";
					break;
				case "cny":
					c = "Chinese Yuan Renminbi";
					break;
				case "aud":
					c = "Australian Dollars";
					break;
				case "chf":
					c = "Swiss Francs";
					break;
				case "btc":
					c = "Bitcoin";
					break;
				default:
					c = "Unknown Currency";
					break;
			}
			return c;
		},

		currencysymbol: function() {
			let c = "";
			switch (this.acurrency.toLowerCase()) {
				case "usd": case "cad": case "aud": case "mxn":
					c = "$";
					break;
				case "gbp":
					c = "&pound;";
					break;
				case "eur":
					c = "&euro;";
					break;
				case "rub":
					c = "&#x20bd;";
					break;
				case "dkk": case "sek": case "isk": case "nok":
					c = "kr.";
					break;
				case "chf":
					c = "CHF";
					break;
				case "jpy": case "cny":
					c = "&yen;";
					break;
				case "ang":
					c = "&fnof;";
					break;
				case "krw":
					c = "&#8361;";
					break;
				case "pln":
					c = "z&lstrok;";
					break;
				case "btc":
					c = "BTC";
					break;
				default:
					c = "?";
					break;
			}
			return c;
		}
	},

	methods: {
		ToggleAlbumDetails() {
			this.showingExtra = ((this.showingExtra === true) ? false : true);
			this.expandText = ((this.showingExtra === true) ? "  -  " : "  +  ");
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

.albums-box {
	display:flex;
	flex-direction:row;
	flex-wrap:wrap;
	justify-content:center;
}

div.album {
	@include WidthMargins(30.5%, 3px, 3px);
	margin-top:6px;
	margin-bottom:7px;
	@include BackBorderColor(rgba(30, 30, 30, 0.3), 1px solid gray, #dfdfdf);
	padding:7px;
	text-align:center;
	float:left;
	h2, h3, p {
		text-align:center;
	}
	ol, ol li {
		text-align:left;
		font-size:1.04em;
	}
	.cover {
		text-align:center;
		display:block;
		width:100%;
		img {
			@include WidthMargins(80%, 10%, 10%);
			margin-top:4px;
			opacity:0.9;
			&:hover {
				margin-top:4px;
				opacity:1;
			}
		}
	}
}

.track-list {
	width:100%;
	text-align:left;
	tbody, tbody tr {
		width:100%;
	}
	tbody tr td {
		background:rgba(10, 10, 10, 0.2);
		padding:6px;
		font-size:1.12em;
	}
}

button.expand {
	width:90%;
}

.alb-info {
	display:flex;
	flex-direction:row;
	flex-wrap:nowrap;
	width:98%;
	div {
		@include BackBorderColor(rgba(10, 10, 10, 0.2), 1px solid rgba(10, 10, 10, 0.4), #dfdfdf);
		padding:5px;
		padding-top:7px;
	}
	.prop {
		@include WidthMargins(48%, 1%, 1%);
		font-size:1.1em;
		text-align:right;
	}
	.val {
		@include WidthMargins(49%, 1%, 0%);
		font-size:1.09em;
		text-align:left;
	}
}
</style>
