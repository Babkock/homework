/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import Album from "../vue/album.vue";
import SearchBox from "../vue/search-box.vue";

Vue.component('album', Album)
Vue.component('search-box', SearchBox)

Vue.mixin({
	data: () => {
		return {
			searchType: "artist"
		};
	},

	methods: {
		BuyAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/buy?id=" + i;
		},

		EditAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		},

		Register() {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/register";
		}
	}
})

let app = new Vue({
	el: "#browse",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			id: 0,
			heading: "{{HEADING}}",
			artist: "{{BROWSE_ARTIST}}",
			album: "{{BROWSE_ALBUM}}",
			country: "{{BROWSE_COUNTRY}}",
			argument: "{{BROWSE_GET}}",
			val: "{{BROWSE_GET_VALUE}}",
			ajaxError: "",
			primary: [],
			secondary: [],
			tertiary: []
		};
	},

	methods: {
		FetchAlbums(mode) {
			let arg = this.argument;     // 'c', 'a', 'b'
			let val = this.val;          // 'us', 'Erases Eraser', 'x'
			let userId = new FormData();
			userId.append("id", this.id);

				if (mode === "newest") {
					this.$http.post("browse?mode=" + mode, userId).then((response) => {
						this.primary = response.data;
					}, () => {
						this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
						console.error("Couldn't fetch albums with mode 'newest'.");
					});
				}
				else if (mode === "expensive") {
					this.$http.post("browse?mode=" + mode, userId).then((response) => {
						this.secondary = response.data;
					}, () => {
						this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
						console.error("Couldn't fetch albums with mode 'expensive'.");
					});
				}
				else if (mode === "purchased") {
					this.$http.post("browse?mode=" + mode, userId).then((response) => {
						this.tertiary = response.data;
					}, () => {
						this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
						console.error("Couldn't fetch albums with mode 'purchased'.");
					});
				}
				else if (mode === "artist") {
					if (this.country.length > 1) {
						this.$http.post("browse?mode=" + mode + "&a=" + encodeURI(this.artist) + "&c=" + this.country, userId).then((response) => {
							this.primary = response.data;
						}, () => {
							this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
							console.error("Couldn't fetch albums with mode 'artist', artist '" + this.artist + "'' and country '" + this.country + "'");
						});
					}
					else {
						this.$http.post("browse?mode=" + mode + "&a=" + encodeURI(this.artist), userId).then((response) => {
							this.primary = response.data;
						}, () => {
							this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
							console.error("Couldn't fetch albums with mode 'artist'.");
						});
					}
				}
				else if (mode === "album") {
					this.$http.post("browse?mode=" + mode + "&b=" + encodeURI(this.album), userId).then((response) => {
						this.primary = response.data;
					}, () => {
						this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
						console.error("Couldn't fetch albums with mode 'album'.");
					});
				}
				else if (mode === "country") {
					this.$http.post("browse?mode=" + mode + "&c=" + this.country, userId).then((response) => {
						this.primary = response.data;
					}, () => {
						this.ajaxError = "<p class=\"error\">Couldn't fetch albums from the server.</p>";
						console.error("Couldn't fetch albums with mode 'country'.");
					});
				}
				else {
					console.error("FetchAlbums() argument error");
				}

		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		if (this.country === "" || this.country.length < 1)
			this.country = "Anywhere";
		
		switch (this.argument) {
			case "a":
				this.FetchAlbums("artist");
				break;
			case "b":
				this.FetchAlbums("album");
				break;
			case "c":
				this.FetchAlbums("country");
				break;
			default:
				this.FetchAlbums("newest");
				this.FetchAlbums("expensive");
				if (this.id != 0) {
					this.FetchAlbums("purchased");
				}
				break;
		}
	}
})