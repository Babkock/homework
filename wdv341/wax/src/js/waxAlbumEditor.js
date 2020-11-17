/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import AlbumInputRow from "../vue/album-input-row.vue";
import TrackInputRow from "../vue/track-input-row.vue";

Vue.component('album-input-row', AlbumInputRow)
Vue.component('track-input-row', TrackInputRow)

var app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			file: false,
			uploaded: false,
			tracks: 3,
			showingTracks: false,
			tracksButton: "Showing Tracks",
			imageFilename: "",
			ajaxResult: "",
			album: {
				id: 0,
				title: "",
				artist: "",
				media: "",
				discs: 1,
				price: 5.99,
				// seller: "",		Don't worry about seller and buyer, these will be set by the PHP
				// buyer: "",       form handler.
				image: "",
				label: "",
				posted: ""
				tracklist: [
					{
						title: "Track One",
						length: "1:00"
					},
					{
						title: "Track Two",
						length: "1:00"
					}
				]
			}
		};
	},

	/* Button handlers */
	methods: {
		/* Add a new, empty track to the Album */
		AddTrack() {

		},

		/* Remove the last track from the Album */
		RemoveTrack() {

		}
	}
})
