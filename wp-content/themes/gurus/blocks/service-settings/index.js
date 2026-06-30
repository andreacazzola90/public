/* global wp */
( function ( plugins, wpEditor, blockEditor, components, data, element, coreData ) {
	'use strict';

	var registerPlugin              = plugins.registerPlugin;
	var PluginDocumentSettingPanel  = wpEditor.PluginDocumentSettingPanel;
	var MediaUpload                 = blockEditor.MediaUpload;
	var MediaUploadCheck            = blockEditor.MediaUploadCheck;
	var PanelRow                    = components.PanelRow;
	var Button                      = components.Button;
	var TextareaControl             = components.TextareaControl;
	var ResponsiveWrapper           = components.ResponsiveWrapper;
	var useSelect                   = data.useSelect;
	var useEntityProp               = coreData.useEntityProp;
	var createElement               = element.createElement;
	var Fragment                    = element.Fragment;

	registerPlugin( 'gurus-service-settings', {
		render: function () {
			/* Only show on service posts */
			var postType = useSelect( function ( select ) {
				return select( 'core/editor' ).getCurrentPostType();
			}, [] );

			if ( postType !== 'service' ) {
				return null;
			}

			/* ── Excerpt (introductory text) ── */
			var excerptProp    = useEntityProp( 'postType', 'service', 'excerpt' );
			var excerptValue   = excerptProp[0] || '';
			var setExcerpt     = excerptProp[1];

			/* ── Featured image (icon / image) ── */
			var featuredProp   = useEntityProp( 'postType', 'service', 'featured_media' );
			var featuredId     = featuredProp[0];
			var setFeaturedId  = featuredProp[1];

			var featuredImage  = useSelect( function ( select ) {
				return featuredId ? select( 'core' ).getMedia( featuredId, { context: 'view' } ) : null;
			}, [ featuredId ] );

			var imgSrc = featuredImage && featuredImage.media_details &&
				featuredImage.media_details.sizes &&
				featuredImage.media_details.sizes.medium
				? featuredImage.media_details.sizes.medium.source_url
				: ( featuredImage ? featuredImage.source_url : null );

			return createElement(
				PluginDocumentSettingPanel,
				{
					name:            'service-intro-panel',
					title:           'Immagine e testo introduttivo',
					className:       'gurus-service-intro-panel',
					initialOpen:     true,
				},

				/* ── Image / icon ── */
				createElement( PanelRow, null,
					createElement( 'label', { style: { fontWeight: 600, marginBottom: '6px', display: 'block' } },
						'Immagine / icona del servizio'
					)
				),
				createElement( PanelRow, null,
					createElement(
						MediaUploadCheck,
						null,
						createElement( MediaUpload, {
							onSelect: function ( media ) { setFeaturedId( media.id ); },
							allowedTypes: [ 'image' ],
							value: featuredId,
							render: function ( ref ) {
								var open = ref.open;
								return createElement(
									Fragment,
									null,
									imgSrc
										? createElement(
											'div',
											{ style: { marginBottom: '8px', maxWidth: '120px' } },
											createElement( 'img', {
												src:   imgSrc,
												alt:   '',
												style: { width: '100%', borderRadius: '4px', display: 'block' },
											} )
										)
										: null,
									createElement(
										'div',
										{ style: { display: 'flex', gap: '8px', flexWrap: 'wrap' } },
										createElement( Button, {
											onClick:   open,
											variant:   'secondary',
											isSmall:   true,
										}, featuredId ? 'Cambia immagine' : 'Seleziona immagine' ),
										featuredId
											? createElement( Button, {
												onClick:  function () { setFeaturedId( 0 ); },
												variant:  'tertiary',
												isSmall:  true,
												isDestructive: true,
											}, 'Rimuovi' )
											: null
									)
								);
							},
						} )
					)
				),

				/* ── Introductory text ── */
				createElement( PanelRow, null,
					createElement( TextareaControl, {
						__nextHasNoMarginBottom: true,
						label:    'Testo introduttivo',
						help:     'Breve descrizione mostrata sotto il titolo e nelle anteprime dei servizi.',
						value:    excerptValue,
						rows:     4,
						onChange: function ( val ) { setExcerpt( val ); },
					} )
				)
			);
		},
	} );
} )(
	window.wp.plugins,
	window.wp.editor,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.data,
	window.wp.element,
	window.wp.coreData
);
