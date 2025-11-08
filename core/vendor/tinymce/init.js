/**
 * Initialisation de TinyMCE
 */
tinymce.init({
	// Classe où appliquer l'éditeur
	selector: ".editorWysiwyg",
	// Langue
	language: "fr_FR",
	// Plugins
	plugins: "advlist anchor autolink autoresize autosave charmap improvedcode codesample colorpicker contextmenu directionality emoticons fullscreen hr image imagetools insertdatetime link lists media nonbreaking noneditable pagebreak paste preview searchreplace stickytoolbar tabfocus table template textcolor textpattern toc visualblocks visualchars wordcount",
	// Contenu de la barre d'outils
	toolbar: "restoredraft | undo redo | styleselect fontsizeselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | insert | emoticons | improvedcode codesample preview | fullscreen",
	// Contenu du menu contextuel
	contextmenu: "cut copy paste pastetext | selectall searchreplace",
	// Fichiers CSS à intégrer à l'éditeur
	content_css: [
		baseUrl + "core/layout/common.css",
		baseUrl + "core/vendor/tinymce/content.css",
		baseUrl + "site/data/theme.css",
		baseUrl + "site/data/custom.css"
	],
	// Classe à ajouter à la balise body dans l'iframe
	body_class: "editorWysiwyg",
	// Suppression du marquage
	branding: false,
	// Autorise l'ajout de script
	extended_valid_elements: "script[language|type|src],pre[*],code[*]",
	// Dimensionnement des médias
	media_dimensions: true,
	// Active l'onglet avancé lors de l'ajout d'une image
	image_advtab: true,
	// Active l'implémentation de la balise html 5 <figure>
	image_caption: true,
	// Urls absolues
	relative_urls: false,
	// Modification des liens
	link_context_toolbar: true,
	// Url de base
	document_base_url: baseUrl,
	// Gestionnaire de fichiers
	filemanager_access_key: privateKey,
	external_filemanager_path: baseUrl + "core/vendor/filemanager/",
	external_plugins: {
		"filemanager": baseUrl + "core/vendor/filemanager/plugin.min.js"
	},
	// Thème mobile
	mobile: {
		theme: "mobile"
	},
	// Contenu du bouton insérer
	insert_button_items: "image link media template codesample inserttable | hr | anchor",
	// codesample
	codesample_languages: [
        {text: "HTML/XML", value: "markup"},
        {text: "JavaScript", value: "javascript"},
        {text: "CSS", value: "css"},
        {text: "PHP", value: "php"},
        {text: "Json", value: "json"},
        {text: "C", value: "clike"},
        {text: "Apache", value: "apacheconf"},
        {text: "Markdown", value: "markdown"}
    ],
	// Contenu du bouton formats
	style_formats: [
		{title: "Headers", items: [
			{title: "Header 1", format: "h1"},
			{title: "Header 2", format: "h2"},
			{title: "Header 3", format: "h3"},
			{title: "Header 4", format: "h4"},
			{title: "Header 5", format: "h5"},
			{title: "Header 6", format: "h6"}
		]},
		{title: "Inline", items: [
			{title: "Bold", icon: "bold", format: "bold"},
			{title: "Italic", icon: "italic", format: "italic"},
			{title: "Underline", icon: "underline", format: "underline"},
			{title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
			{title: "Superscript", icon: "superscript", format: "superscript"},
			{title: "Subscript", icon: "subscript", format: "subscript"},
			{title: "Code", icon: "code", format: "code"}
		]},
		{title: "Blocks", items: [
			{title: "Paragraph", format: "p"},
			{title: "Blockquote", format: "blockquote"},
			{title: "Div", format: "div"},
			{title: "Pre", format: "pre"}
		]},
		{title: "Alignment", items: [
			{title: "Left", icon: "alignleft", format: "alignleft"},
			{title: "Center", icon: "aligncenter", format: "aligncenter"},
			{title: "Right", icon: "alignright", format: "alignright"},
			{title: "Justify", icon: "alignjustify", format: "alignjustify"}
		]}
	],
	// Templates
	templates: [
		{
			title: "Bloc de texte",
			url: baseUrl + "core/vendor/tinymce/templates/block.html",
			description: "Bloc de texte avec un titre."
		},
		{
			title: "Colonnes symétriques : 6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/col6.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes symétriques : 4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col4.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes symétriques : 3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/col3.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes asymétriques : 4 - 8",
			url: baseUrl + "core/vendor/tinymce/templates/col4-8.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes asymétriques : 8 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col8-4.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes asymétriques : 2 - 10",
			url: baseUrl + "core/vendor/tinymce/templates/col2-10.html",
			description: "Grille adaptative sur 12 colonnes"
		},
		{
			title: "Colonnes asymétriques : 10 - 2",
			url: baseUrl + "core/vendor/tinymce/templates/col10-2.html",
			description: "Grille adaptative sur 12 colonnes"
		}
	]
});
