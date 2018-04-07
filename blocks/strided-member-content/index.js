/**
 * Block dependencies
 */
import classnames from 'classnames';
import icons from './icons.js';
import './style.scss';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const {
  registerBlockType,
  Editable,
  AlignmentToolbar,
  BlockControls,
  BlockAlignmentToolbar,
  InspectorControls,
  BlockDescription,
} = wp.blocks;
const {
  Toolbar,
  Button,
  Tooltip,
  PanelBody,
  PanelRow,
  FormToggle,
  RadioControl
} = wp.components;


/**
  * Register block
 */
export default registerBlockType(
    'strided-app/strided-member-content',
    {
        title: __( 'Strided Member Content' ),
        category: 'common',
        icon: 'star-filled',
        keywords: [
            __( 'Horses horse' ),
            __( 'Arena arenas' ),
            __( 'Run runs' ),
        ],
        attributes: {
          title: {
            type: 'string',
            source: 'children',
            selector: '.strided-content-title'
          },
          message: {
            type: 'array',
            source: 'children',
            selector: '.message-body',
          },
          alignment: {
            type: 'string',
          },
          highContrast: {
            type: 'boolean',
            default: false,
          },
          dataType: {
            type: 'string',
          }
        },
        edit: props => {
          const toggleHighContrast = () => {
            props.setAttributes( { highContrast: ! props.attributes.highContrast } );
          }
          const setDataType = ( dataType ) => {
            props.setAttributes( { dataType: dataType } );
          }
          const { dataType } = props.attributes;
          return [
  					!! props.focus && (
              <InspectorControls key="inspector">

                <BlockDescription>
                  <p>{ __( 'Display member content for horses, arenas, or runs.' ) }</p>
                </BlockDescription>

                <PanelBody title={ __( 'Strided Data' ) }
                >

                  <PanelRow>
                    <RadioControl
                      label="Data Type"
                      help="The type of data to show"
                      selected={ dataType }
                      options={ [
                          { label: 'Horses', value: 'h' },
                          { label: 'Runs', value: 'r' },
                          { label: 'Arenas', value: 'a' },
                      ] }
                      onChange={ setDataType }
                    />
                  </PanelRow>

                </PanelBody>

              </InspectorControls>
  					),
            !! props.focus && (
              <BlockControls key="controls">
                <AlignmentToolbar
                  value={ props.attributes.alignment }
                  onChange={ ( value ) => props.setAttributes( { alignment: value } ) }
                />
                <Toolbar
                  className='components-toolbar'
                >
                  <Tooltip text={ __( 'High Contrast' )  }>
                    <Button
                      className={ classnames(
                        'components-icon-button',
                        'components-toolbar__control',
                        { 'is-active': props.attributes.highContrast },
                      ) }
                      onClick={ toggleHighContrast }
                    >
                      {icons.contrast}
                    </Button>
                  </Tooltip>
                </Toolbar>
              </BlockControls>
            ),
            <div
              className={ classnames(
                props.className,
                { 'high-contrast': props.attributes.highContrast },
              ) }
            >
              <Editable
                tagName="h2"
                placeholder={ __( 'Enter title here...' ) }
                value={ props.attributes.title }
                style={ { textAlign: props.attributes.alignment } }
                onChange={ ( value ) => props.setAttributes( { title: value } ) }
                focus={ props.focus }
              />
              <Editable
                tagName="div"
                multiline="p"
                placeholder={ __( 'Enter your message here..' ) }
                value={ props.attributes.message }
                style={ { textAlign: props.attributes.alignment } }
                onChange={ ( value ) => props.setAttributes( { message: value } ) }
                focus={ props.focus }
      				/>
            </div>
          ];
        },
        save: props => {
          return (
            <div className="strided-member-content">
              <h2
                className={ classnames(
                  'strided-content-title',
                  { 'high-contrast': props.attributes.highContrast },
                ) }
                style={ { textAlign: props.attributes.alignment } }
              >
                { props.attributes.title }
              </h2>
              <div
                className={ classnames(
                  'message-body',
                  { 'high-contrast': props.attributes.highContrast },
                ) }
                style={ { textAlign: props.attributes.alignment } }
              >
                { props.attributes.message }
              </div>
            </div>
          );
        },

    },
);
