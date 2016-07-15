
// Do not change any of this !!!

frslib._class = function(def) {
	// pokud není konstruktor definován, použijeme nový (nechceme použít zděděný)
	var constructor = def.hasOwnProperty('constructor') ? def.constructor : function() { };
	// proces vytváření třídy rozdělíme do kroků
	for (var name in frslib._class.Initializers) {
		frslib._class.Initializers[name].call(constructor, def[name], def);
	}
	return constructor;
};

frslib._class.Initializers = {
	Extends: function(parent) {
		if (parent) {
		var F = function() { };
		this._superClass = F.prototype = parent.prototype;
		this.prototype = new F;
		}
	},

	Mixins: function(mixins, def) {
		// kostruktoru přidáme metodu mixin
		this.mixin = function(mixin) {
			for (var key in mixin) {
				if (key in frslib._class.Initializers) continue;
				this.prototype[key] = mixin[key];
			}
			this.prototype.constructor = this;
		};
		// a přidanou metodu hned využijeme pro rozšíření prototype
		var objects = [def].concat(mixins || []);
		for (var i = 0, l = objects.length; i < l; i++) {
			this.mixin(objects[i]);
		}
	}
};