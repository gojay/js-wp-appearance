var Widgets;

(function($) {
	Widgets = {

		/* debug */

		debug: function( isDebug ) {
			if (!isDebug) {
				console = {};
				console.log = function() {};
				console.info = function() {};
				console.error = function() {};
				console.warn = function() {};
			} else console = console;
		},

		/* log styles */

		styles: {
			green : 'padding:0 5px; background:#222; color:#bada55;',
			blue  : 'padding:0 5px; background:#F0F0EE; color:#08C;',
			red   : 'padding:0 5px; background:#F0F0EE; color:#9B0000;'
		},

		/* initialize */

		init: function(_options) {

			var self = this;
			var wid, multi;

			var defaults = {
				'avWidgets': '#available-widget',
				'widgets'  : '.widgets-sortables',
				'ajaxurl'  : 'ajax.php',
				'debug'    : true
			};
			// merge options
			var options = this.options = $.extend(defaults, _options);
			// debugging ?
			self.debug(options.debug);

			// init portlet style

			$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix")
				.find(".portlet-header")
				.addClass("ui-widget-header ui-corner-all")
				.prepend("<a class='ui-icon ui-icon-triangle-1-s'></a>");

			/* Events */

			/* aksi show/hide */
			$('a.ui-icon').live("click", function() {
				$(this).toggleClass("ui-icon-triangle-1-s").toggleClass("ui-icon-triangle-1-n");
				$(this).parents(".portlet:first").find(".portlet-inside:first").toggle();
				return false;
			});
			/* aksi save */
			$("input.widget-control-save").live("click", function() {
				this.save($(this).closest("div.portlet"), 0, 0);
				return false;
			});
			/* aksi hapus */
			$("a.widget-control-remove").live("click", function() {
				this.save($(this).closest("div.portlet"), 0, 1);
				return false;
			});
			/* aksi close */
			$("a.widget-control-close").live("click", function() {
				this.close($(this).closest("div.portlet"));
				return false;
			});

			/* draggable */
			$(options.avWidgets + '> .portlet').draggable({
				// connectToSortable: '.widgets-sortables',
				connectToSortable: options.widgets,
				handle: "> .portlet-header",
				helper: "clone",
				cursor: "move",
				start: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[draggable][start] %c' + $('h4', ui.helper).text().trim(), self.styles.green);
					/* ================================================== */

					// tampilkan widget hanya header saja
					// dan sesuaikan lebar
					ui.helper.css({'height':'36px', 'min-width':'227px'}).removeClass('span4');

					// set widget id
					wid = this.id;
				},
				stop: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[draggable][stop] %c' + $('h4', ui.helper).text().trim(), self.styles.green);
					/* ================================================== */

					// aksi setelah drag selesai/berhenti

				}
			});

			/* droppable */
			$(options.avWidgets).droppable({
				tolerance: "pointer",
				drop: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[droppable][drop] %c' + $('h4', ui.draggable).text().trim(), self.styles.green);
					/* ================================================== */

					// tambah class 'deleteing'
					// sbg tanda aksi hapus widget
					ui.draggable.addClass("deleting");

					// hidden info remove widget pd header
					$("#removing-widget").hide().children("span").html("");

				},
				over: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[droppable][over] %c' + $('h4', ui.draggable).text().trim(), self.styles.green);
					/* ================================================== */

					// tambah class 'deleteing'		
					// sbg tanda aksi hapus widget
					ui.draggable.addClass("deleting");

					// hidden widget placeholder
					$("div.widget-placeholder").hide();

					// tampilkan info remove widget pd header
					if (ui.draggable.hasClass("ui-sortable-helper")) {
						var title = $(".portlet-header", ui.draggable).children("h4").html();
						$("#removing-widget").show().find("span").html(title);
					}
				},
				out: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[droppable][out] %c' + $('h4', ui.draggable).text().trim(), self.styles.green);
					/* ================================================== */

					// hapus class 'deleting'
					ui.draggable.removeClass("deleting");

					// tampilkan widget placeholder
					$("div.widget-placeholder").show();

					// hidden info remove widget pd header 
					$("#removing-widget").hide().children("span").html("");

				}
			});

			/* sortable */
			$(options.widgets).sortable({
				placeholder: "widget-placeholder",
				items: "> .portlet",
				cursor: "move",
				start: function(event, ui) {
					/* =================== debug ======================== */
					console.log('%c'+ui.item.parents('.widget-holder-wrap').find('h3').text().trim(), 'color:red');
					console.log('[sortable][start] %c' + $('h4', ui.helper).text().trim(), self.styles.green);
					/* ================================================== */

					// tampilkan widget hanya header saja
					// dan sesuaikan lebar
					ui.helper.css({'height':'36px', 'min-width':'227px'});

					// slideUp widget (dgn click 'ui-icon')
					$('a.ui-icon', ui.helper).click();

				},
				stop: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[sortable][stop] %c' + $('h4', ui.item).text().trim(), self.styles.green);
					/* ================================================== */

					// hapus class 'span4'
					// utk menyesuaikan lebar widget dgn panelnya
					ui.item.removeClass('span4');


					// [drop delete], 
					// aksi hapus widget dgn droppable
					// jika item memiliki class "deleting"  
					if (ui.item.hasClass("deleting")) {
						// hapus item
						self.del(ui.item, 0, 1);
						return;
					}

					// [drag add], 
					// hapus class "ui-draggable"
					// jika item memiliki class "ui-draggable"
					if (ui.item.hasClass("ui-draggable")) {
						ui.item.removeClass("ui-draggable");
					}

					// [drag add], 
					// aksi tambah widget
					// jika input hidden class "add" memiliki value
					var add = $("input.add", ui.item).val();
					if (add) {
						// hapus deskripsi
						$('.portlet-description', ui.item).remove();

						// ubah item ID [widget_id]-[position] dengan variabel multi
						ui.item.attr("id", wid + '-' + multi);

						// increase value multi
						// ubah value input.multi
						multi++;
						$('#available-widget #' + wid).find('input.multi').val(multi);

						// slideDown widget setelah ditambahkan (dgn click 'ui-icon')
						$('a.ui-icon', ui.item).click();

						// hapus semua input hidden
						ui.item.each(function(i,e) {
							$('input[type=hidden]', e).remove();
						});

						// kosongkan value input hidden 'add', 
						// jadi, untuk event selanjutnya adalah sortable widget,
						// bukan draggable widget / drag add
						$('input.add', ui.item).val('');

						// save widget
						self.save(ui.item, 1, 0);

						// selesai disini, tanpa saveOrder
						return;
					}

					// aksi sortorder : save order
					self.saveOrder(ui.item.parent(), 1);
				},
				receive: function(event, ui) {
					/* =================== debug ======================== */
					console.log('[sortable][receive] %c' + $('h4', ui.helper).text().trim(), self.styles.green);
					/* ================================================== */

					// set value multi, digunakan untuk ubah item ID
					multi = $('.multi', ui.helper).val();
				}
			});
		},

		/* Save Order */

		saveOrder: function(item, loader) {
			console.log('%cSAVE ORDER', this.styles.blue);
		},

		/* Save */

		save: function(item, add, del) {
			console.log('%cSAVE', this.styles.blue);
		},

		/* Delete */

		del: function(item, slide, drop) {
			console.log('%cDELETE', this.styles.red);
		},

		/* Close */

		close: function(item) {
			$(item).find('a.ui-icon').toggleClass("ui-icon-triangle-1-s").toggleClass("ui-icon-triangle-1-n");
			item.find('.portlet-inside').hide('fast');
		}
	};

})(jQuery);