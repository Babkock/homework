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
			var cunt = "";
			switch (this.album.country) {
				case "us":
					cunt = "United States";
					break;
				case "uk":
					cunt = "United Kingdom";
					break;
				case "es":
					cunt = "Spain";
					break;
				case "ca":
					cunt = "Canada";
					break;
				case "de":
					cunt = "Germany";
					break;
				case "ru":
					cunt = "Russian Federation";
					break;
				case "dk":
					cunt = "Denmark";
					break;
				case "se":
					cunt = "Sweden";
					break;
				case "no":
					cunt = "Norway";
					break;
				case "nl":
					cunt = "Netherlands";
					break;
				default:
					cunt = "Unknown Country";
					break;
			}
			return cunt;
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
