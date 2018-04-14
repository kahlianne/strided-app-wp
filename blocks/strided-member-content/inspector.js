/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { settings } = wp.date;
const { Component } = wp.element;
const {
    InspectorControls,
    ColorPalette,
} = wp.blocks;
const {
    Button,
    ButtonGroup,
    PanelBody,
    PanelRow,
    RadioControl,
    RangeControl,
    ToggleControl,
    Toolbar,
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {

    constructor( ) {
        super( ...arguments );
    }

    render() {
        const { attributes: { radioControl, rangeControl, toggleControl, }, setAttributes } = this.props;

        return (
            <InspectorControls>
                <PanelBody
                    title={ 'Settings' }
                    initialOpen={ true }
                >
                    <RadioControl
                        label={ 'Content Type' }
                        selected={ radioControl }
                        options={ [
                            { label: 'Horses', value: 'horse' },
                            { label: 'Arenas', value: 'arena' },
                            { label: 'Runs', value: 'run' },
                        ] }
                        onChange={ radioControl => setAttributes( { radioControl } ) }
                    />
                    <RangeControl
                        beforeIcon="arrow-left-alt2"
                        afterIcon="arrow-right-alt2"
                        label={ 'Items to Display' }
                        value={ rangeControl }
                        onChange={ rangeControl => setAttributes( { rangeControl } ) }
                        min={ 1 }
                        max={ 20 }
                    />
                    <ToggleControl
                        label={ 'Toggle Control' }
                        checked={ toggleControl }
                        onChange={ toggleControl => setAttributes( { toggleControl } ) }
                    />
                </PanelBody>
            </InspectorControls>  
        );
    }
}
