<template>
	<div class="album" :id="myid">
		<div class="cover">
			<slot name="img"></slot>
		</div>
		<h2><a :href="artisthref" v-text="aartist"></a> - <i><a :href="albumhref" v-text="atitle"></a></i></h2>
		<button @click="ToggleAlbumDetails()" v-text="expandText"></button>
		<div v-if="showingExtra">
			<slot name="info"></slot>
			<h3>Tracklist:</h3>
			<slot name="tracklist">
			</slot>
			<p><b>Posted</b>: <span class="date" v-text="niceposted"></span></p>
			<p><b>Country</b>: <span class="acountry" v-text="countryexpand"></span></p>
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
		}
	},

	data: () => {
		return {
			showingExtra: true,
			expandText: "  -  "
		};
	},

	computed: {
		artisthref: function() {
			return "browse?a=" + encodeURI(this.aartist);
		},

		albumhref: function() {
			return "browse?b=" + encodeURI(this.atitle);
		},

		niceposted: function() {
			let jsDate = new Date(Date.parse(this.aposted.replace(/[-]/g,'/')));
			return jsDate.toDateString();
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

		/*
		currencyExpand: function() {
			let c = "";
			switch (this.acurrency) {
				case "usd":
					c = "US Dollars";
					break;
				case "gbp":
					c = "GB Pounds";
					break;
				case "eur":
					c = "Euros";
					break;
				default:
					c = "Unknown Currency";
					break;
			}
			return c;
		} */
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
</style>
