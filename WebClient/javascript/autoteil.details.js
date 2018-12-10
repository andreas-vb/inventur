$.widget("autoteil.details", {
	load: function(autoteilUrl){
		$.ajax({
			url: autoteilUrl,
			dataType: "json",
			success: function(autoteil) {
				this.element.find(".h3_details").text(autoteil.title);
				this.element.find(".title").text(autoteil.title);
				this.element.find(".author").text(autoteil.author);
				this.element.find(".preis").text(autoteil.preis + " €");
				this.element.find(".gesamtwert").text((autoteil.preis * autoteil.bestand) + " €");
				this.element.find(".bestand").text(autoteil.bestand);
				this.element.find(".farbe").text(autoteil.farbe);
				this.element.find(".inventur_date").text(autoteil.inventur_date);
				this.element.find(".notes").text(autoteil.notes);
			},
			context: this
		});
	}
});