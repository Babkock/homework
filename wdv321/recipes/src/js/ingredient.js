class Ingredient {
	constructor(ingName, ingQuantity, ingQuantMst, optional) {
		this.name = ingName;
		this.quantity = ingQuantity;
		this.measurement = ingQuantMst;
		this.optional = optional;
	}

	stringify() {
		return this.quantity + " " + this.measurement + " " + this.name;
	}

	json() {
		return JSON.stringify(this);
	}
}
