/**
 * @version $Id: dynamic-params.js 6850 2013-01-28 18:13:53Z btowles $
 * @author RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
var dynamicParams = new Class({
	Implements: [Options],
	options: {
		addButton: '',
		moreField: '',
		basename: '',
		params: '',
		paramsid: '',
		extLinks: '.rokquickcart-extendedlink',
		fields: 1
	},
	
	initialize: function(options) {
		this.setOptions(options);
		
		this.addButton = document.id(this.options.addButton);
		this.moreField = document.id(this.options.moreField);
		
		if (!this.addButton) 
			throw new Error('Add Button ('+this.options.addButton+') cannot be find. Class initialization stopped.');
		if (!this.moreField) 
			throw new Error('More Field container ('+this.options.moreField+') cannot be find. Class initialization stopped.');
		
		if (!this.addButton || !this.moreField) return false;
		
		this.rendered = this.moreField.getElements(this.options.extLinks);
		
		if (this.rendered.length) this.extLinksEvents();
		this.extendedlinkInit.delay(350, this);
		this.eventAdd();
		this.eventOnchange();
		
	},
	
	eventAdd: function() {
		var self = this, last, input2;
		this.addButton.addEvent('click', function(e){
			if (e) e.stop();
			self.moreField.getParent().getParent().getParent().getParent().getParent().setStyle('height', '');
			if (self.moreField.getLast() === null){
				last = 0;
			}
			else {
				last = self.moreField.getLast().id;
				last = last.split("_").slice(-1)[0].toInt();
			}
			var id = {
				'div': self.options.basename + '_' + (last + 1),
				'name': self.options.params + '[' + self.options.basename + ']['+(last + 1) + ']',
				'value': self.options.params + '[' + self.options.basename + ']['+(last + 1) + ']'
			};
			var div = new Element('div', {'id': id.div, 'class': 'roknavmenu-extendedlink', 'styles': {'margin': '5px 0'}});
			
			var size = (self.options.fields == 1) ? 22 : 10;
			
			var input1 = new Element('input', {'type': 'text', 'name': id.name, 'size': size}).inject(div).setProperty('value', 'Name');
			if (self.options.fields == 2) 
				input2 = new Element('input', {'type': 'text', 'name': id.value, 'size': size}).inject(div).setProperty('value', 'Value');
			
			var remove = new Element('button', {'class': 'remove'}).set('text', '-').inject((input2) ? input2 : input1, 'after');

			var fx = {
				'remove': new Fx.Tween(remove, {'duration': 200, 'link': 'cancel'}).set('opacity', 0),
				'div': new Fx.Tween(div, {'duration': 200, 'link': 'cancel'}).set('opacity', 0)
			};

			div.inject(self.moreField);
			fx.div.start('opacity', 1);

			input1.addEvents({
				'focus': function() {if (this.value == "Name") this.value = "";},
				'blur': function() {if (this.value === "") this.value = "Name";}
			});
			
			if (self.options.fields == 2) {
				input2.addEvents({
					'focus': function() {if (this.value == "Value") this.value = "";},
					'blur': function() {if (this.value === "") this.value = "Value";}
				});
			}
			
			new Element('div', {'class': 'clr'}).inject(div);
			div.addEvents({
				'mouseenter': function() {
					if (fx.remove) fx.remove.start('opacity', 1);
				},
				'mouseleave': function() {
					if (fx.remove) fx.remove.start('opacity', 0);
				}
			});

			remove.addEvent('click', function(e) {
				new Event(e).stop();
				self.moreField.getParent().getParent().getParent().getParent().getParent().setStyle('height', '');
				fx.div.start('opacity', 0).chain(function() {
					delete fx.remove;
					delete fx.div;
					(function() {
						div.empty().dispose();
						self.extendedlinkReorder();
					}).delay(100);
				});
			});
		});	
	},
	
	extLinksEvents: function() {
		this.rendered.each(function(render) {
			var inputs = render.getElements('input');
			inputs.each(function(input, i) {
				input.addEvents({
					'focus': function() {if ((this.value == "Name" && !i) || (this.value == "Value" && i == 1)) this.value = "";},
					'blur': function() {
						if (this.value === "" && !i) this.value = "Name";
						else if (this.value === "" && i == 1) this.value = "Value";
					}
				});
			}, this);
		}, this);
	},
	
	extendedlinkInit: function() {
		var more = this.moreField, self = this;
		more.getChildren().each(function(div, i) {
			var inputs = div.getElements('input');
			var input1 = inputs[0], input2 = inputs[1];
			var remove = new Element('button', {'class': 'remove'}).set('text', '-').inject((input2) ? input2 : input1, 'after');

			var fx = {
				'remove': new Fx.Tween(remove, {'duration': 200, 'link': 'cancel'}).set('opacity', 0),
				'div': new Fx.Tween(div, {'duration': 200, 'link': 'cancel'}).set('opacity', 1)
			};

			input1.addEvents({
				'focus': function() {if (this.value == "Name") this.value = "";},
				'blur': function() {if (this.value === "") this.value = "Name";}
			});
			
			if (self.options.fields == 2) 
				input2.addEvents({
					'focus': function() {if (this.value == "Value") this.value = "";},
					'blur': function() {if (this.value === "") this.value = "Value";}
				});

			div.addEvents({
				'mouseenter': function() {
					fx.remove.start('opacity', 1);
				},
				'mouseleave': function() {
					if (fx) fx.remove.start('opacity', 0);
				}
			});

			remove.addEvent('click', function(e) {
				new Event(e).stop();
				more.getParent().getParent().getParent().getParent().getParent().setStyle('height', '');
				fx.div.start('opacity', 0).chain(function() {
					delete fx.remove;
					delete fx.div;
					(function() {
						div.empty().dispose();
						self.extendedlinkReorder();
					}).delay(100);
				});
			});
		});
		
		self.moreField.getParent().getParent().getParent().getParent().getParent().setStyle('height', '');
	},
	
	extendedlinkReorder: function() {
		this.moreField.getChildren().each(function(div, i) {
			div.setProperty('id', this.options.paramsid + this.options.basename  + '_' + (i + 1));
			div.getElements('input').each(function(input, j) {
				if (!j) input.setProperty('name', this.options.params + '[' + this.options.basename + '][' + (i + 1) + ']');
				else input.setProperty('name', this.options.params + '[' + this.options.basename + '][' + (i + 1) + ']');
			}, this);
		}, this);
	},

    eventOnchange: function() {
        var image = document.getElement(".image-preview");
        var selector = document.id("jform_image");

        selector.addEvent('change', function() {
            var imagepath = this.getProperty('value');
            if(imagepath){
                image.setProperty('src', '../'+imagepath);
            }
            else {
                image.setProperty('src', '../images/rokquickcart/blank.png');
            }

        });

    }
});

window.addEvent('domready', function(){
	
	window.jInsertFieldValue = function(value, id) {
		var old_id = document.id(id).value;
		if (old_id != id) {
			var elem = document.id(id);
			elem.value = value;
			elem.fireEvent("change");
		}
	};
});