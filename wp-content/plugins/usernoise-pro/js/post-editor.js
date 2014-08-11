(
	function(){
		tinymce.create(
			"tinymce.plugins.UsernoiseShortcodes", {
				init: function(a, b) {},
				createControl: function(button, e){
					if (button == "usernoise_button"){
						button = e.createMenuButton( "usernoise_button", { title: "Usernoise shortcodes", icons: false});
						var a = this;
						button.onRenderMenu.add(function(c,b){
							a.addMenuItem(b,"Usernoise form", '[usernoise]');
							a.addMenuItem(b,"Link to Usernoise", '[usernoise_link]Link[/usernoise_link]');
							a.addMenuItem(b, 'Show Usernoise button', '[show_usernoise_button]');
							a.addMenuItem(b, 'Hide Usernoise button', '[hide_usernoise_button]');
						});
						return button;
					}
					return null;
				},
				addMenuItem:function(d,e,a){
					d.add({title: e, onclick: function(){
						tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)
					}})}
			}
		);
		tinymce.PluginManager.add( "UsernoiseShortcodes", tinymce.plugins.UsernoiseShortcodes);
	}
)();