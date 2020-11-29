<template>
	<div class="album">
		<div class="cover">
			<slot name="img"></slot>
		</div>
		<h2><a :href="artisthref" v-text="artist"></a> - <slot name="title"></slot></h2>
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
			type: Number,
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
			let jsDate = new Date(Date.parse(this.posted.replace(/[-]/g,'/')));
			return jsDate.toDateString();
		},

		countryexpand: function() {
			let c = "";
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

.albums-box {
	display:flex;
	flex-direction:row;
	flex-wrap:wrap;
}

div.album {
	@include WidthMargins(32%, 3px, 3px);
	margin-top:6px;
	margin-bottom:7px;
	@include BackBorderColor(rgba(30, 30, 30, 0.3), 1px solid gray, #dfdfdf);
	padding:7px;
	text-align:left;
	float:left;
}
</style>
