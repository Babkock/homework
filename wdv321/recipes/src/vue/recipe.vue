<template>
	<div class="recipe" :id="myid">
		<h2><slot name="title"></slot></h2>
		<div class="imgbox">
			<slot name="img"></slot>
		</div>
		<slot name="info"></slot>
		<h3>Ingredients:</h3>
		<slot name="ingredients"></slot>
		<br />
		<slot name="steps"></slot>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: Number,
			required: true
		},
		filename: {
			type: String,
			required: true
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

.recipe {
	color:white;
	background-color:rgba(0, 0, 0, 0.1);
	h2 {
		color:aqua;
		text-shadow:2px 2px #004455;
	}
	p {
		font-size:1.09em;
	}
	p b {
		font-size:1.1em;
	}
	ol {
		border:1px solid gray;
		padding:3px;
		text-align:left;
		margin-left:1.2em;
		li {
			font-size:1.08em;
			line-height:1.5;
		}
	}

	.imgbox {
		text-align:center;
		border:1px solid #dfdfdf;
		opacity:0.9;
		margin-left:4%;
		margin-right:4%;
		&:hover {
			opacity:1;
			border:1px solid white;
		}
		img {
			width:100%;
			height:100%;
		}
	}
}
</style>
