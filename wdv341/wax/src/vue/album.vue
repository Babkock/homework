<template>
	<div class="album">
		<div class="cover">
			<img :src="album.image" />
		</div>
		<h2><a :href="artisthref" v-text="album.artist"></a> - {{ album.title }}</h2>
		<h3>{{ album.discs }}x {{ album.media }}</h3>
		<h3><span class="price"><b>${{ album.price }}</b></span> from <span class="country" v-text="countryExpand"></span></h3>
		<h4><a :href="userhref" v-text="album.seller"></a></h4>
		<button @click="BuyAlbum(album.id)">Buy Now</button>
		<h3>Tracklist:</h3>
		<ol>
			<li v-for="(track, index) in album.tracklist"><span class="title" v-text="track.title"></span> &nbsp;&nbsp;&nbsp;&nbsp;<span class="length" v-text="track.length"></span></li>
		</ol>
		<p>Posted for sale <span class="date" v-text="niceposted"></span>.</p>
	</div>
</template>

<script>
export default {
	props: {
		album: {
			type: Object,
			required: true
		}
	},

	data: () => {
		return {
			//album: {...this.value}
		};
	},

	computed: {
		artisthref: function() {
			return "browse?a=" + encodeURI(this.album.artist);
		},

		niceposted: function() {
			var jsDate = new Date(Date.parse(this.album.posted.replace(/[-]/g,'/')));
			return jsDate.getMonth() + " " + jsDate.getDate() + ", " + jsDate.getFullYear();
		},

		countryexpand: function() {
			var c = "";
			switch (this.album.country) {
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
