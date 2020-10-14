<!DOCTYPE html>
<!--
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
-->
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Awesome Recipes &bull; Edit</title>
	<link rel="icon" type="image/png" href="/images/favicon.png" />
	<link rel="stylesheet" href="/homework/assets/css/recipesProject.css" />
	<link rel="stylesheet" href="/homework/assets/css/ingredient.css" />
	<script src="https://unpkg.com/vue@2.6.11"></script>
	<script src="/homework/assets/js/ingredient.js"></script>
</head>
<body>
	<div class="container">
		<header>
			<h1>Awesome Recipe Editor</h1>
			<nav>
				<ul>
					<li><a href="home.html" title="Awesome Recipes Home Page" alt="Awesome Recipes Home Page">Home</a></li>
					<li><a href="edit" title="Go to Recipe Editor" alt="Go to Recipe Editor">Edit Recipes</a></li>
					<li><a href="#" title="Dummy Link" alt="Dummy Link">Contact</a></li>
					<li><a href="#" title="Dummy Link" alt="Dummy Link">Staff</a></li>
				</ul>
			</nav>
		</header>
		<?php
		if (!isset($_GET['fname'])) {
		?>
		<main id="menu">
			<ul v-if="this.recipeFiles.length > 0">
				<li v-for="(f, index) in this.recipeFiles" :key="index">
					<a :href="editurl(f)" title="Edit this file in the Recipe Editor" alt="Edit this file in the Recipe Editor">{{ f }}</a>
				</li>
			</ul>
		</main>
		<?php
		}
		else {

		?>
		<main id="editor">
			<form method="post" enctype="multipart/form-data">
				<div class="formflex large">
					<span><b>Filename of Recipe</b></span>
					<input type="text" v-model="this.recipe.filename" placeholder="Filename" />
				</div>
				<div class="formflex">
					<span><b>Title of Recipe:</b></span>
					<input type="text" v-model="this.recipe.title" placeholder="Pepperjack Mac n Cheese" />
				</div>
				<div class="formflex">
					<span><b>Image Filename:</b></span>
					<input type="text" v-model="this.recipe.image" placeholder="img/test.jpg" />
				</div>
				<div class="formflex">
					<span><b>Difficulty:</b></span>
					<select v-model="this.recipe.difficulty">
						<option value="easy">Easy</option>
						<option value="medium">Medium</option>
						<option value="hard">Hard</option>
					</select>
				</div>
				<div class="formflex">
					<span><b>Preparation Time:</b></span>
					<input type="number" v-model="this.recipe.preparation.quantity" />
					<select v-model="this.recipe.preparation.measurement">
						<option value="seconds">seconds</option>
						<option value="minutes">minutes</option>
						<option value="hours">hours</option>
						<option value="days">days</option>
					</select>
				</div>
				<table><tbody v-if="this.recipe.ingredients">
					<tr is="ingredient" v-for="(ings, index) in this.recipe.ingredients" :key="index" :id="index" :value="index" :name="index" title="Enter the number of the given ingredient"></tr>
				</tbody></table>
				<button @click="StoreObjectAs(this.recipe.filename); alert('Recipe saved successfully');">Save Recipe</button>
			</form>
		</main>
		<?php

		}
		?>
		<footer>
			<p><a href="/homework/index">&rarr; Return to WDV321 Homework &larr;</a></p>
			<p>Copyright &copy; 2020 Tanner Babcock.</p>
		</footer>
	</div>
	<script src="/homework/assets/js/editor.min.js"></script>
</body>
</html>