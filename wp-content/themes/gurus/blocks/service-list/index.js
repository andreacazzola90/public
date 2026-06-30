/* global wp */
( function ( blocks, blockEditor, components, data, element ) {
	'use strict';

	var registerBlockType  = blocks.registerBlockType;
	var InspectorControls  = blockEditor.InspectorControls;
	var useBlockProps      = blockEditor.useBlockProps;
	var PanelBody          = components.PanelBody;
	var SelectControl      = components.SelectControl;
	var ToggleControl      = components.ToggleControl;
	var Spinner            = components.Spinner;
	var useSelect          = data.useSelect;
	var createElement      = element.createElement;
	var Fragment           = element.Fragment;

	registerBlockType( 'gurus/service-list', {
		edit: function ( props ) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps    = useBlockProps();

			var terms = useSelect( function ( select ) {
				return select( 'core' ).getEntityRecords(
					'taxonomy',
					'service-category',
					{ per_page: -1, orderby: 'name', order: 'asc', _fields: 'id,name,slug' }
				);
			}, [] );

			var termOptions = [ { label: '— Seleziona categoria —', value: '' } ];
			if ( Array.isArray( terms ) ) {
				terms.forEach( function ( term ) {
					termOptions.push( { label: term.name, value: term.slug } );
				} );
			}

			var previewLabel = attributes.categorySlug
				? 'Categoria: ' + attributes.categorySlug
				: 'Nessuna categoria selezionata';

			return createElement(
				Fragment,
				null,
				/* ── Inspector sidebar ── */
				createElement(
					InspectorControls,
					null,
					createElement(
						PanelBody,
						{ title: 'Impostazioni Lista Servizi', initialOpen: true },
						terms === null
							? createElement( Spinner )
							: createElement( SelectControl, {
								__next40pxDefaultSize: true,
								__nextHasNoMarginBottom: true,
								label: 'Categoria di servizi',
								value: attributes.categorySlug,
								options: termOptions,
								onChange: function ( val ) {
									setAttributes( { categorySlug: val } );
								},
							} ),
						createElement( ToggleControl, {
							__nextHasNoMarginBottom: true,
							label: 'Mostra sottotitolo',
							checked: attributes.showSubtitle,
							onChange: function ( val ) {
								setAttributes( { showSubtitle: val } );
							},
						} )
					)
				),
				/* ── Editor preview placeholder ── */
				createElement(
					'div',
					blockProps,
					createElement(
						'div',
						{
							style: {
								padding: '1.25em 1.5em',
								background: '#f6f7f7',
								border: '1px dashed #999',
								borderRadius: '4px',
								textAlign: 'center',
								color: '#3c434a',
							},
						},
						createElement( 'strong', null, '📋 Lista Servizi' ),
						createElement( 'br' ),
						createElement(
							'span',
							{ style: { fontSize: '13px', color: '#666' } },
							previewLabel + ( attributes.showSubtitle ? ' · con sottotitolo' : '' )
						)
					)
				)
			);
		},
	} );
} )(
	window.wp.blocks,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.data,
	window.wp.element
);
