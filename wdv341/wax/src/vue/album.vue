<template>
	<div class="album" :id="myid">
		<div class="cover">
			<slot name="img"></slot>
		</div>
		<h2><a :href="artisthref" v-text="artist"></a> - <slot name="title"></slot></h2>
		<p>From <span v-text="niceposted"></span></p>
		<slot name="info"></slot>
		<h3>Tracklist:</h3>
		<slot name="tracklist">
		</slot>
		<p>Posted: <span class="date" v-text="niceposted"></span>.</p>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: String,
			required: true
		},
		artist: {
			type: String,
			default: "Unknown Artist"
		},
		posted: {
			type: String,
			required: true
		},
		country: {
			type: String,
			default: "us"
		}
	},

	data: () => {
		return {
			//album: {...this.value}
		};
	},

	computed: {
		artisthref: function() {
			return "browse?a=" + encodeURI(this.artist);
		},

		niceposted: function() {
			var jsDate = new Date(Date.parse(this.posted.replace(/[-]/g,'/')));
			return jsDate.getMonth() + " " + jsDate.getDate() + ", " + jsDate.getFullYear();
		},

		countryexpand: function() {
			var c = "";
			switch (this.country) {
				case "us":
					c = "United States";
					break;
				case "uk":
					c = "United Kingdom";
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
				default:
					c = "Unknown Country";
					break;
			}
			return c;
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

div.album {
	@include WidthMargins(32%, 1px, 1px);
	margin-top:6px;
	margin-bottom:7px;
	background:rgba(30, 30, 30, 0.3);
	color:#dfdfdf;
	padding:7px;
	border:1px solid gray;
	text-align:left;
}
</style>
